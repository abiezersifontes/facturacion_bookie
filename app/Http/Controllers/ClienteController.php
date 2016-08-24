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

		$clientes = DB::connection('sqlsrv')->table('BookieAdmin.dbo.Clientes')->select('NombreCliente','Rif')->get();
		foreach ($clientes as $value) {

			$array = array(	'Rif' => $value->Rif,
											'NombreCliente' => $value->NombreCliente
										);
										
			$validator = Validator::make($array, [
            'Rif' => 'unique:Factu_clientes',
        ]);
			if ($validator->fails())
			{
    		continue;
			}else {
				$cliente_fac = new Factu_cliente;
				$cliente_fac->rif = $array->Rif;
				$cliente_fac->nombre = $array->NombreCliente;
				$cliente_fac->save();
			}
			}
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
