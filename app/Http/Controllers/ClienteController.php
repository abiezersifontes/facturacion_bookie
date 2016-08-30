<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Factu_cliente;
use Illuminate\Http\Request;
use DB;
use Validator;
class ClienteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clientes = DB::connection('sqlsrv')->table('BookieAdmin.dbo.Clientes')
		->join('BookieAdmin.dbo.Contratos','BookieAdmin.dbo.Contratos.ClienteId','=','BookieAdmin.dbo.Clientes.ClienteID')
		->join('BookieAdmin.dbo.Direcciones','BookieAdmin.dbo.Direcciones.DireccionId','=','BookieAdmin.dbo.Clientes.DireccionFiscalId')
		->join('BookieAdmin.dbo.Estados','BookieAdmin.dbo.Estados.EstadoId','=','BookieAdmin.dbo.Direcciones.EstadoId')
		->join('BookieAdmin.dbo.Ciudades', function ($join) {
			$join->on('BookieAdmin.dbo.Ciudades.CiudadId', '=', 'BookieAdmin.dbo.Direcciones.CiudadId')
			->on('BookieAdmin.dbo.Ciudades.EstadoId', '=', 'BookieAdmin.dbo.Direcciones.EstadoId');
		})
		->select('BookieAdmin.dbo.Clientes.Nacionalidad','BookieAdmin.dbo.Clientes.Rif','BookieAdmin.dbo.Clientes.NombreCliente',
		'BookieAdmin.dbo.Direcciones.CalleAvenida','BookieAdmin.dbo.Direcciones.EdificioResidencia','BookieAdmin.dbo.Direcciones.PisoNivel',
		'BookieAdmin.dbo.Direcciones.ApartamentoOficina','BookieAdmin.dbo.Estados.Estado','BookieAdmin.dbo.Ciudades.Ciudad','BookieAdmin.dbo.Contratos.DistribuidorId')
		->get();
		/***CodSucursal***
		1 = 'CIUDAD BOLIVAR'
		2 = 'PUERTO ORDAZ'
		3 = 'EL TIGRE'
		4 = 'PUERTO LA CRUZ'
		*/
		foreach ($clientes as $value) {

			$array = ['tipdoc'			=>	$value->Nacionalidad,
								'numdoc'			=>	$value->Rif,
								'nombre'			=>	$value->NombreCliente,
								'direccion'		=>	$value->CalleAvenida.$value->EdificioResidencia.$value->PisoNivel.$value->ApartamentoOficina,
								'ciudad'			=>	$value->Ciudad,
								'estado'			=>	$value->Estado,
								'CodSucursal'	=>	$value->DistribuidorId,
							];

			$validator = Validator::make($array, [
          'numdoc' => 'unique:Factu_clientes',
        ]);

				if ($validator->fails()){
    			continue;
				}else {
					$cliente_fac = new Factu_cliente;
					$cliente_fac->tipdoc = $array['tipdoc'];
					$cliente_fac->numdoc = $array['numdoc'];
					$cliente_fac->nombre = $array['nombre'];
					$cliente_fac->direccion = $array['direccion'];
					$cliente_fac->ciudad = $array['ciudad'];
					$cliente_fac->estado = $array['estado'];
					$cliente_fac->CodSucursal = $array['CodSucursal'];
					$cliente_fac->save();
				}
			}
		}

		public function contratos(){
			$contratos = DB::connection('sqlsrv')->table('BookieAdmin.dbo.Contratos')->first();
			dd($contratos);
		}
		public function prueba(){
			$cobros = DB::connection('sqlsrv')->table('BookieAdmin.dbo.CobrosDetalles')
			->distinct()
			->select('BookieAdmin.dbo.Cobros.CobroId')
			->join('BookieAdmin.dbo.Cobros','BookieAdmin.dbo.Cobros.CobroId','=','BookieAdmin.dbo.CobrosDetalles.CobroId')
			->join('BookieAdmin.dbo.Clientes','BookieAdmin.dbo.Cobros.ClienteId','=','BookieAdmin.dbo.Cobros.ClienteId')
			->join('BookieAdmin.dbo.Contratos','BookieAdmin.dbo.Contratos.ClienteId','=','BookieAdmin.dbo.Clientes.ClienteId')
			->join('BookieAdmin.dbo.GruposCobranzas','BookieAdmin.dbo.GruposCobranzas.GrupoCobranzaId','=','BookieAdmin.dbo.Contratos.GrupoCobranzaId')
			->whereBetween('BookieAdmin.dbo.CobrosDetalles.FechaDocumento', ['2016-07-01', '2016-07-31'])
			->get();
			//->paginate(50);
			/*->select(DB::raw("SELECT DISTINCT C.CobroId, CL.Rif, CD.FechaDocumento, CD.Monto,
				(SELECT TOP 1 CT.GrupoCobranzaid
				FROM BookieAdmin.dbo.Contratos CT
				WHERE CT.ClienteId = C.ClienteId) as Banco
			  FROM BookieAdmin.dbo.CobrosDetalles CD
			  LEFT JOIN BookieAdmin.dbo.Cobros C ON C.CobroId = CD.CobroId
			  LEFT JOIN BookieAdmin.dbo.Clientes CL ON CL.ClienteId = C.ClienteId
			  LEFT JOIN BookieAdmin.dbo.Contratos CT ON CT.ClienteId = C.ClienteId
			  LEFT JOIN BookieAdmin.dbo.GruposCobranzas GC ON GC.GrupoCobranzaId = CT.GrupoCobranzaId
			  WHERE CD.FechaDocumento BETWEEN '20160701 00:01:00' and '20160731 23:59:00'");*/
			dd($cobros);
		}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
