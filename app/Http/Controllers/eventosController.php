<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\eventos;
use App\Models\boletas;
use Illuminate\Support\Facades\DB;
use Exception;

class eventosController extends Controller
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
                'Codigo' => ['required', 'string', 'min:4', 'max:15'],
                'Nombre' => ['required', 'string', 'min:5', 'max:100'],
                'FechaEvento' => ['required', 'date', 'min:10', 'max:10', 'date_format:Y-m-d'],
                'BoletasZona1' => ['required', 'numeric','digits_between:1,4','min:1'],
                'BoletasZona2' => ['numeric','digits_between:1,4'],
                'BoletasZona3' => ['numeric','digits_between:1,4'],
                'BoletasZona4' => ['numeric','digits_between:1,4'],
                'NombreZona1' => ['required', 'string', 'min:3','max:20'],
                'NombreZona2' => ['string', 'max:20' ],
                'NombreZona3' => ['string', 'max:20'],
                'NombreZona4' => ['string', 'max:20'],
                'ValorZona1' => ['required', 'numeric','digits_between:1,7','min:1'],
                'ValorZona2' => ['required', 'numeric','digits_between:1,7'],
                'ValorZona3' => ['required', 'numeric','digits_between:1,7'],
                'ValorZona4' => ['required', 'numeric','digits_between:1,7'],
                'Estado' => ['required', 'string', 'in:Activo,Inactivo']
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
                'date' => 'El atributo :attribute debe ser una fecha válida',
                'digits_between' => 'El atributo :attribute debe tener entre :min y :max digitos.',
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
                    $model = eventos::create($params_array);
                    // $model = eventos::create([
                    //     'Codigo'        => $params_array['Codigo'],
                    //     'Nombre'        => $params_array['Nombre'],
                    //     'FechaEvento'   => $params_array['FechaEvento'],
                    //     'BoletasZona1'  => $params_array['BoletasZona1'],
                    //     'BoletasZona2'  => $params_array['BoletasZona2'],
                    //     'BoletasZona3'  => $params_array['BoletasZona3'],
                    //     'BoletasZona4'  => $params_array['BoletasZona4'],
                    //     'NombreZona1'   => $params_array['NombreZona1'],
                    //     'NombreZona2'   => $params_array['NombreZona2'],
                    //     'NombreZona3'   => $params_array['NombreZona3'],
                    //     'NombreZona4'   => $params_array['NombreZona4'],
                    //     'ValorZona1'    => $params_array['ValorZona1'],
                    //     'ValorZona2'    => $params_array['ValorZona2'],
                    //     'ValorZona3'    => $params_array['ValorZona3'],
                    //     'ValorZona4'    => $params_array['ValorZona4'],
                    //     'Estado'        => $params_array['Estado']
                    // ]);
                    $this->Boletas($model);
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
            $rules = [
                'Codigo' => ['required', 'string', 'min:5', 'max:15'],
                'Nombre' => ['required', 'string', 'min:5', 'max:100'],
                'FechaEvento' => ['required', 'date', 'min:10', 'max:10', 'date_format:Y-m-d'],
                'BoletasZona1' => ['required', 'numeric','digits_between:1,4', 'min:1'],
                'BoletasZona2' => ['required', 'numeric','digits_between:1,4'],
                'BoletasZona3' => ['required', 'numeric','digits_between:1,4'],
                'BoletasZona4' => ['required', 'numeric','digits_between:1,4'],
                'NombreZona1' => ['required', 'string', 'max:20', 'min:3'],
                'NombreZona2' => ['string', 'max:20'],
                'NombreZona3' => ['string', 'max:20'],
                'NombreZona4' => ['string', 'max:20'],
                'ValorZona1' => ['required', 'numeric','digits_between:1,7','min:1'],
                'ValorZona2' => ['required', 'numeric','digits_between:1,7'],
                'ValorZona3' => ['required', 'numeric','digits_between:1,7'],
                'ValorZona4' => ['required', 'numeric','digits_between:1,7'],
                'Estado' => ['required', 'string', 'in:Activo,Inactivo']
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
                'date' => 'El atributo :attribute debe ser una fecha válida',
                'digits_between' => 'El atributo :attribute debe tener entre :min y :max digitos.',
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
                    eventos::find($id)->update($params_array);
                    // $model=eventos::find($id);
                    // $model->Codigo =  $params_array['Codigo'];
                    // $model->Nombre =  $params_array['Nombre'];
                    // $model->FechaEvento =  $params_array['FechaEvento'];
                    // $model->BoletasZona1 =  $params_array['BoletasZona1'];
                    // $model->BoletasZona2 =  $params_array['BoletasZona2'];
                    // $model->BoletasZona3 =  $params_array['BoletasZona3'];
                    // $model->BoletasZona4 =  $params_array['BoletasZona4'];
                    // $model->NombreZona1 =  $params_array['NombreZona1'];
                    // $model->NombreZona2 =  $params_array['NombreZona2'];
                    // $model->NombreZona3 =  $params_array['NombreZona3'];
                    // $model->NombreZona4 =  $params_array['NombreZona4'];
                    // $model->ValorZona1 =  $params_array['ValorZona1'];
                    // $model->ValorZona2 =  $params_array['ValorZona2'];
                    // $model->ValorZona3 =  $params_array['ValorZona3'];
                    // $model->ValorZona4 =  $params_array['ValorZona4'];
                    // $model->Estado =  $params_array['Estado'];
                    // $model->save();
                    $this->Boletas($model);
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
    public function destroy(Request $request,$id)
    {
        $Ids[] = $id;
        $retorna = $this->Eliminar($Ids, $request, false);
        return response()->json($retorna, $retorna['code']);
    }

    /**
     * crea las boletas del evento
     * @param App\Models\eventos
     */
    
    public function Boletas( eventos $model)
    {
        if( $model->NombreZona1 !== '' && $model->BoletasZona1 >0) {
            $this->makeBoletas($model->id, 1, $model->BoletasZona1);
        }
        if( $model->NombreZona2 !== '' && $model->BoletasZona2 >0) {
            $this->makeBoletas($model->id, 2, $model->BoletasZona2);
        }
        if( $model->NombreZona3 !== '' && $model->BoletasZona3 >0) {
            $this->makeBoletas($model->id, 3, $model->BoletasZona3);
        }
        if( $model->NombreZona4 !== '' && $model->BoletasZona4 >0) {
            $this->makeBoletas($model->id, 4, $model->BoletasZona4);
        }

    }

    /**
     * @param int idEvento
     * @param int Zona
     * @param int Boletas
     */
    public function makeBoletas($idevento, $zona, $boletas )
    {
        for( $i=1; $i<= $boletas; $i++ ) {
            boletas::insertOrIgnore([
                'idEvento'  => $idevento,
                'Zona'      => $zona,
                'Numero'    => $i
            ]);
        }
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
            $instance = new eventos;
            
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
            $instance = new eventos;
            DB::beginTransaction();
            $lContinue=true;
            try {
                $tDetalle = "";
                foreach ($aIds as $id) {
                    // deterina si puede borrar
                    $model=boletas::where('idEvento','=',$id)
                                  ->where('Estado','=','Vendida');
                    if($model !== null && $model->count()>0) {
                        $retorna = array(
                            'code' => '400',
                            'status' => 'error',
                            'message' => '',
                            'data'    => array('record' => $model),
                            'errors' => '',
                        );
                        $lContinue=false;
                        return $retorna;
                        break;
                    } else  {
                        $instance::where('Id', $id)->delete();
                    }
                }
                if($lContinue) {
                    $retorna = array(
                        'code' => '200',
                        'status' => 'success',
                        'data' => 'No Data',
                        'message' => 'Delete success',
                    );
                    DB::commit();
                } else  {
                    DB::rollback();
                    $retorna = array(
                        'code' => '400',
                        'status' => 'error',
                        'message' => 'Evento(s) con boletas vendidas, no se puede eliminar',
                        'errors' => ''
                    );    
                }
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
