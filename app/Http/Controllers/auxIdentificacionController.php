<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\auxIdentificacion;
use Illuminate\Support\Facades\DB;
use Exception;

class auxIdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params) && !empty($params_array)) {
            // define reglas de validación
            $rules = [
                'Codigo' => ['required', 'string', 'min:1', 'max:2'],
                'Nombre' => ['required', 'string', 'min:1', 'max:50']
            ];

            // define mensajes para la validación
            $messages = [
                'required' => 'El atributo :attribute es requerido',
                'string' => 'El atributo :attribute debe ser una cadena',
                'numeric' => 'El atributo :attribute debe ser un número',
                'min' => 'El atributo :attribute no puede ser menor a :min caracteres',
                'max' => 'El atributo :attribute no puede ser mayor a :max caracteres',
                'exist' => 'El valor indicado en el atributo :attribute no se encuentra registrado',
                'in' => 'El atributo :attribute debe ser uno de los siguientes valores :values',
                'date' => 'El atributo :attribute debe ser una fecha válida'
            ];

            // validar datos de entrada
            $validacion = Validator::make($params_array, $rules, $messages);

            if ($validacion->fails()) {
                $retorna = array(
                    'code' => '400',
                    'status' => 'error',
                    'message' => 'Error en los datos de entrada',
                    'errors' => $validacion->errors(),
                );
            } else {
                try {
                    DB::beginTransaction();
                    $model = auxIdentificacion::create([
                        'Codigo' => $params_array['Codigo'],
                        'Nombre' => $params_array['Nombre']
                    ]);
                    $retorna = array(
                        'code' => '200',
                        'status' => 'success',
                        'data'    => array('record' => $model)
                    );
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $retorna = array(
                        'code' => '400',
                        'status' => 'error',
                        'message' => 'Error (DB) al intentar grabar los datos',
                        'errors' => $e->getMessage(),
                    );
                }
            }
            return response()->json($retorna, $retorna['code']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params) && !empty($params_array)) {
            // define reglas de validación
            $rules = [
                'Codigo' => ['required', 'string', 'min:1', 'max:2'],
                'Nombre' => ['required', 'string', 'min:1', 'max:50']
            ];

            // define mensajes para la validación
            $messages = [
                'required' => 'El atributo :attribute es requerido',
                'string' => 'El atributo :attribute debe ser una cadena',
                'numeric' => 'El atributo :attribute debe ser un número',
                'min' => 'El atributo :attribute no puede ser menor a :min caracteres',
                'max' => 'El atributo :attribute no puede ser mayor a :max caracteres',
                'exist' => 'El valor indicado en el atributo :attribute no se encuentra registrado',
                'in' => 'El atributo :attribute debe ser uno de los siguientes valores :values',
                'date' => 'El atributo :attribute debe ser una fecha válida'
            ];

            // validar datos de entrada
            $validacion = Validator::make($params_array, $rules, $messages);

            if ($validacion->fails()) {
                $retorna = array(
                    'code' => '400',
                    'status' => 'error',
                    'message' => 'Error en los datos de entrada',
                    'errors' => $validacion->errors(),
                );
            } else {
                try {
                    DB::beginTransaction();
                    $model=auxIdentificacion::find($id);
                    $model->Codigo =  $params_array['Codigo'];
                    $model->Nombre =  $params_array['Nombre'];
                    $model->save();
                    $retorna = array(
                        'code' => '200',
                        'status' => 'success',
                        'data'    => 'no data'
                    );
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $retorna = array(
                        'code' => '400',
                        'status' => 'error',
                        'message' => 'Error (DB) al intentar grabar los datos',
                        'errors' => $e->getMessage(),
                    );
                }
            }
            return response()->json($retorna, $retorna['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
