<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\personas;
use Illuminate\Support\Facades\DB;
use Exception;

class PersonsController extends Controller
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
                'idIdentificacion' => ['required', 'numeric', 'exists:aux_identificacion,id'],
                'Identificacion' => ['required', 'string', 'min:1', 'max:15', 'unique:bol_personas'],
                'Nombres' => ['required', 'string', 'min:1', 'max:50'],
                'Apellidos' => ['required', 'string', 'min:1', 'max:50'],
                'Telefonos' => ['required', 'string', 'max:50'],
                'Email' => ['email', 'max:100'],
                'Estado' => ['required', 'string', 'in:Activo,Inactivo'],
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
                    $model = personas::create([
                        'idIdentificacion'      => $params_array['idIdentificacion'],
                        'Identificacion'        => $params_array['Identificacion'],
                        'Nombres'               => $params_array['Nombres'],
                        'Apellidos'             => $params_array['Apellidos'],
                        'Telefonos'             => $params_array['Telefonos'],
                        'Email'                 => $params_array['Email'],
                        'Estado'                => $params_array['Estado']
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
                'idIdentificacion' => ['required', 'numeric', 'exists:aux_identificacion,id'],
                'Identificacion' => ['required', 'string', 'min:1', 'max:15'],
                'Nombres' => ['required', 'string', 'min:1', 'max:50'],
                'Apellidos' => ['required', 'string', 'min:1', 'max:50'],
                'Telefonos' => ['required', 'string', 'max:50'],
                'Email' => ['email', 'max:100'],
                'Estado' => ['required', 'string', 'in:Activo,Inactivo'],
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
                    $model=personas::find($id);
                    $model->idIdentificacion =  $params_array['idIdentificacion'];
                    $model->Identificacion =  $params_array['Identificacion'];
                    $model->Nombres =  $params_array['Nombres'];
                    $model->Apellidos =  $params_array['Apellidos'];
                    $model->Telefonos =  $params_array['Telefonos'];
                    $model->Email =  $params_array['Email'];
                    $model->Estado =  $params_array['Estado'];
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
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $Ids[] = $id;
        $retorna = $this->Eliminar($Ids, $request, false);
        return response()->json($retorna, $retorna['code']);
         
    }

    /**
     * Obtirne los combos
     * @param Request $request
     * 
     */

     public function getCombox(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $data1=null;
        $lBack=false;

        if ($params->combos == "all" || $params->combos = 'auxIdentificacion') {
            $claseModelo='App\Models\auxIdentificacion';
            $datamodel1= new $claseModelo;
            $data1 =  $datamodel1::selectRaw('Id value, Nombre label')->orderByRaw('Id asc')->get();
            if( $data1 !== null ) $lBack=true;
        }

        if ($lBack) {
            $retorna = array(
                'status'  => 'success',
                'code'    => 200,
                'message' => 'data returned',
                'data'    => array('tiposIdentificacion' => $data1)
            );
        } else {
            $retorna = array(
                'code' => '400',
                'status' => 'error',
                'message' => 'No hay datos',
                'errors' => '',
                'data' => ''
            );
        }
        return response()->json($retorna, $retorna['code']);
     }

     /**
      * Lista de registros
      * @param Request $request
      */
     public function List(Request $request) {
        try {
            $sortBy = $request->sortBy;
            $descending = $request->descending;
            $page = $request->page;
            $rowsPerPage = $request->rowsPage == "Todos" ? 0 : $request->rowsPage;
            $columns = $request->columns;

            $start = ($page - 1) * $rowsPerPage;
            $search = isset($request->filter) ? '%' . strtolower($request->filter) . '%' : '';
            $orderedBy = [];
            $cols = [];
            $filter = ""; // "delete= false"
            $filterOr = ""; // "or"

            foreach ($columns as $col) {
                if (isset($col['fromdual']) && $col['fromdual']) {
                    if (isset($col['field']))
                        $cols[] = "'' " . $col['field'];
                } else {
                    $cols[] = $col['field'];
                    if ($search != '') {
                        if (isset($col['filter']) && $col['filter'] == true) {
                            $filter .= $filterOr . "lower(" . $col['field'] . ")  like  '" . iconv('latin5', 'utf-8', $search) . "' ";
                            $filterOr = " or ";
                        }
                    }
                }
            }
            $colsRaw = implode(",", $cols);
            $instance = new personas;
            
            if ($sortBy) {
                $orderedBy = [];
                if (is_array($sortBy)) {
                    foreach ($sortBy as $idx => $col) {
                        if ($descending[$idx]) {
                            $orderedBy[] = $col . " desc";
                        } else {
                            $orderedBy[] = $col . " asc";
                        }
                    }
                } else {
                    $orderedBy[] = $sortBy . " " . $descending;
                }
            }
            $aRelations = $instance->Relations();
            $totalTabla = $instance::count();
            if ($rowsPerPage == 0) {
                $rowsPerPage = $totalTabla;
            }

            if ($search != '') {
                if (count($orderedBy) > 0) {
                    $data = $instance::with($aRelations)->selectRaw($colsRaw)->whereRaw($filter)->orderByRaw(implode(",", $orderedBy))->skip($start)->take($rowsPerPage)->get();
                } else {
                    $data = $instance::with($aRelations)->selectRaw($colsRaw)->whereRaw($filter)->skip($start)->take($rowsPerPage)->get();
                }
            } else {
                if (count($orderedBy) > 0) {
                    $data = $instance::with($aRelations)->selectRaw($colsRaw)->orderByRaw(implode(",", $orderedBy))->skip($start)->take($rowsPerPage)->get();
                } else {
                    $data = $instance::with($aRelations)->selectRaw($colsRaw)->skip($start)->take($rowsPerPage)->get();
                }
            }

            $retorna = array(
                'status'  => 'success',
                'code'    => 200,
                'message' => 'data returned',
                'data'    => array('records' => $data, 'Total' => $totalTabla)
            );
        } catch (Exception $e) {
            $retorna = array(
                'status' => 'Error',
                'code' => '404',
                'message' => $e->getMessage(),
                'data' => 'No data',
            );
        }
        return response()->json($retorna, $retorna['code']);
     }
     /**
     * Eliminar registro
     *
     * @param array $aIds arreglo de Id a borrar (si es borrado de varios)
     * @param  \Illuminate\Http\Request  $request
     * @param bobolean $lBloque si el borrado es de varios registros
     * @return \Illuminate\Http\Response
     */
    public static function Eliminar($aIds, Request $request, $lBoque)
    {

        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params) && !empty($params_array)) {
            $instance = new personas;
            

            DB::beginTransaction();
            try {
                $tDetalle = "";
                foreach ($aIds as $id) {
                    $res = $instance::where('Id', $id)->delete();
                }
                $retorna = array(
                    'code' => '200',
                    'status' => 'success',
                    'data' => 'No Data',
                    'message' => 'Delete success',
                );
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                $retorna = array(
                    'code' => '400',
                    'status' => 'error',
                    'message' => 'Error al intentar eliminar los datos',
                    'errors' => $e->getMessage(),
                );
            }
        } else {
            $retorna = array(
                'code' => '401',
                'status' => 'error',
                'message' => "¡ Método de solicitud inválida !",
                'data' => '',
            );
        }
        return $retorna;
    }
    
}
