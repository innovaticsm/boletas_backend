<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\eventos;
use App\Models\boletas;
use App\Models\personas;
use Illuminate\Support\Facades\DB;
use Exception;

class ticketsController extends Controller
{

    /**
     * Obtirne los combos
     * @param Request $request
     * 
     */

    public function getCombox(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $data1 = null;
        $lBack = false;
        $fecha = date("Y-m-d");

        if ($params->combos == "all" || $params->combos = 'eventos') {
            $datamodel1 = new eventos;
            $data1 =  $datamodel1::selectRaw('Id value, concat_ws(" - ", Nombre, concat("Fecha: ", date_format(FechaEvento,"%Y-%m-%d"))) label, NombreZona1, NombreZona2, NombreZona3, NombreZona4')
                ->where('FechaEvento', '>=', $fecha)
                ->where('Estado', '=', 'Activo')
                ->orderByRaw('FechaEvento asc')->get();
            if ($data1 !== null) $lBack = true;
        }
        if ($params->combos == "all" || $params->combos = 'compradores') {
            $datamodel2 = new personas;
            $data2 =  $datamodel2::selectRaw('Id value, concat(Identificacion, " - ", Nombres, " " ,Apellidos) label')
                ->where('Estado', '=', 'Activo')
                ->orderByRaw('Nombres asc, Apellidos asc')->get();
            if ($data2 !== null) $lBack = true;
        }


        if ($lBack) {
            $retorna = array(
                'status'  => 'success',
                'code'    => 200,
                'message' => 'data returned',
                'data'    => array('events' => $data1, 'compradores' => $data2)
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
     * lee zonas disponibles
     * @param Request $request
     */
    public function getTickets(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $data = null;
        $lBack = false;

        $datamodel1 = new boletas;
        $data =  $datamodel1::selectRaw('Id value, concat( "Boleta: ",Zona,":",Numero) label')
            ->where('idEvento', '=', $params->event)
            ->where('Zona', '=', $params->zone)
            ->where('Estado', '=', 'Libre')
            ->orderByRaw('Numero asc')->get();
        if ($data !== null) $lBack = true;


        if ($lBack) {
            $retorna = array(
                'status'  => 'success',
                'code'    => 200,
                'message' => 'data returned',
                'data'    => array('records' => $data)
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
     * @param Request $request
     */
    public function updateTicket(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        try {
            DB::beginTransaction();
            $model = boletas::find($params->idboleta);
            $model->idPersona =  $params->idcomprador;
            $model->Estado =  "Vendida";
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
        return response()->json($retorna, $retorna['code']);
    }
}
