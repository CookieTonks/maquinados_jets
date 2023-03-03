<?php

namespace App\Http\Controllers;

use App\Models;

use App\Models\materiales;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;



class almacen_controller extends Controller
{


    //Maybe we going to delete this
    public function filtro_almacen()
    {
        $notificaciones =  Models\notifications::all();

        $materiales = models\materiales::where('estatus', '=', 'P.REVISION')
            ->where('estatus', '=', 'ASI')
            ->get();
        return view('modulos.almacen.filtro_almacen', compact('materiales', 'notificaciones'));
    }

    public function buscador_almacen()
    {
        $notificaciones =  Models\notifications::all();

        $materiales = models\materiales::all();
        return view('modulos.almacen.buscador_almacen', compact('materiales', 'notificaciones'));
    }
    public function dashboard_almacen()
    {
        $materiales_revision =  models\materiales::where('estatus', '=', 'P/ALMACEN')
            ->Where('tipo', '=', 'MATERIAL')
            ->get();

        $materiales_recepcion =  models\materiales::where('estatus', '=', 'ASIGNADA')
            ->Where('tipo', '=', 'MATERIAL')
            ->orwhere('estatus', '=', 'PARCIAL')
            ->get();

            $notificaciones =  Models\notifications::all();

        return view('modulos.almacen.dashboard_almacen ', compact('materiales_revision', 'materiales_recepcion', 'notificaciones'));
    }

    public function recepcion_material(Request $request)
    {


        $date = Carbon::now();

        $registro_material = new models\registros_almacen();
        $registro_material->id_material = $request->id;
        $registro_material->ot = $request->ot;
        $registro_material->descripcion = $request->descripcion;
        $registro_material->factura = $request->factura;
        $registro_material->cantidad = $request->cantidad;
        $registro_material->tipo_recepcion = $request->tipo_recepcion;
        $registro_material->tipo_entrega = $request->tipo_entrega;
        $registro_material->oc = $request->oc;
        $registro_material->personal = $request->personal;
        $registro_material->fecha_recepcion = $date;
        $registro_material->save();

        if ($request->tipo_recepcion === 'PARCIAL') {
            $recepcion_material = models\materiales::where('id', '=', $request->id)->first();
            $recepcion_material->estatus = 'PARCIAL';
            $recepcion_material->fecha_almacen = $date;
            $cantidad_total = $recepcion_material->cantidad_recibida + $request->cantidad_recibida;
            $recepcion_material->cantidad_recibida = $cantidad_total;
            $recepcion_material->personal_almacen = Auth::user()->name;
            $recepcion_material->save();
        } elseif ($request->tipo_recepcion === 'FINAL') {
            $recepcion_material = models\materiales::where('id', '=', $request->id)->first();
            $recepcion_material->estatus = 'RECIBIDA';
            $recepcion_material->fecha_almacen = $date;
            $cantidad_total = $recepcion_material->cantidad_recibida + $request->cantidad_recibida;
            $recepcion_material->cantidad_recibida = $cantidad_total;
            $recepcion_material->personal_almacen = Auth::user()->name;
            $recepcion_material->save();
        }

        if ($registro_material->tipo_entrega === 'PRODUCCION') {
            
              $registro_jets = new models\jets_registros();
        $registro_jets->ot = $request->ot;
        $registro_jets->movimiento = 'ALMACEN - PRODUCCION';
        $registro_jets->responsable = Auth::user()->name;
        $registro_jets->save();

        $ruta = models\jets_rutas::where('ot', '=', $request->ot)->first();
        $ruta->sistema_almacenr = 'DONE';
        $ruta->sistema_compras = 'DONE';
        $ruta->sistema_almacen = 'DONE';
        $ruta->save();

            
            $produccion = models\production::where('ot', '=', $request->ot)->first();
            if ($produccion->estatus === 'REGISTRADA') {

                $produccion->estatus = "L.PRODUCCION";
                $produccion->save();
            }
        }

        return back()->with('mensaje-success', '¡Alta de material registrada!');
    }

    public function envio_material(Request $request)
    {
        $date = Carbon::now();

        $registro_material = new models\registros_almacen();
        $registro_material->id_material = $request->id;
        $registro_material->ot = $request->ot;
        $registro_material->descripcion = $request->descripcion;
        $registro_material->cantidad = $request->cantidad;
        $registro_material->tipo_recepcion = 'STOCK ALMACEN';
        $registro_material->personal = $request->personal;
        $registro_material->fecha_recepcion = $date;
        $registro_material->save();


        $recepcion_material = models\materiales::where('id', '=', $request->id)->first();
        $recepcion_material->estatus = 'SOLICITADA';
        $recepcion_material->cantidad_almacen = $request->cantidad_almacen;
        $recepcion_material->fecha_almacen = $date;
        $recepcion_material->personal_almacen = Auth::user()->name;
        $recepcion_material->save();
        
    $material = Models\materiales::where('ot', '=', $request->ot)->count();
    $material_solicitado = Models\materiales::where('ot', '=', $request->ot)->where('estatus', '=', 'SOLICITADA')->count();
    
    
 
     $ruta = models\jets_rutas::where('ot', '=', $request->ot)->first();
        $ruta->sistema_almacen = 'DONE';
        $ruta->save();
    
     $registro_jets = new models\jets_registros();
        $registro_jets->ot = $request->ot;
        $registro_jets->movimiento = 'ALMACEN - COMPRAS';
        $registro_jets->responsable = Auth::user()->name;
        $registro_jets->save();

        if ($registro_material->tipo_entrega == 'produccion') {
            $produccion = models\production::where('ot', '=', $request->ot)->first();

            if ($produccion->estatus == 'Registrada') {

                $produccion->estatus = "L.Produccion";
                $produccion->save();
            }
        }
        return back()->with('mensaje-success', '¡Alta de material registrada!');
    }


    //Hay material va para compras
    public function material_produccion(Request $request)
    {
        $date = Carbon::now();

        $recepcion_material = models\materiales::where('id', '=', $request->id)->first();
        $recepcion_material->estatus = 'RECIBIDA';
        $recepcion_material->fecha_almacen = $date;
        $recepcion_material->personal_almacen = Auth::user()->name;
        $recepcion_material->save();
        
            $material = Models\materiales::where('ot', '=', $request->ot)->count();
    $material_solicitado = Models\materiales::where('ot', '=', $request->ot)->where('estatus', '=', 'RECIBIDA')->count();
    
    
    if($material == $material_solicitado)
{
    $registro_jets = new models\jets_registros();
        $registro_jets->ot = $request->ot;
        $registro_jets->movimiento = 'ALMACEN - PRODUCCION';
        $registro_jets->responsable = Auth::user()->name;
        $registro_jets->save();

        $ruta = models\jets_rutas::where('ot', '=', $request->ot)->first();
        $ruta->sistema_almacenr = 'DONE';
        $ruta->sistema_compras = 'DONE';
        $ruta->sistema_almacen = 'DONE';
        $ruta->save();
}


        $registro_material = new models\registros_almacen();
        $registro_material->id_material = $request->id;
        $registro_material->ot = $request->ot;
        $registro_material->descripcion = $request->descripcion;
        $registro_material->cantidad = $request->cantidad_recibida;
        $registro_material->tipo_recepcion = 'STOCK ALMACEN';
        $registro_material->tipo_entrega = $request->tipo_entrega;
        $registro_material->personal = $request->personal;
        $registro_material->fecha_recepcion = $date;
        $registro_material->save();

        if ($registro_material->tipo_entrega === 'PRODUCCION') {
            $produccion = models\production::where('ot', '=', $request->ot)->first();
            if ($produccion->estatus === 'REGISTRADA') {

                $produccion->estatus = "L.PRODUCCION";
                $produccion->save();
            }
        }
       

        return back()->with('mensaje-success', '¡Alta de material registrada!');
    }

    //Enviar a compras material
    public function material_compras(Request $request)
    {
        $date = Carbon::now();

        $recepcion_material = models\materiales::where('id', '=', $request->id)->first();
        $recepcion_material->estatus = 'SOLICITADA';
        $recepcion_material->save();



        $registro_material = new models\registros_almacen();
        $registro_material->id_material = $request->id;
        $registro_material->ot = $request->ot;
        $registro_material->descripcion = $request->descripcion;
        $registro_material->cantidad = $request->cantidad_recibida;
        $registro_material->tipo_recepcion = 'SOLCITADA ALMACEN';
        $registro_material->tipo_entrega = $request->tipo_entrega;
        $registro_material->personal = $request->personal;
        $registro_material->fecha_recepcion = $date;
        $registro_material->save();

        if ($registro_material->tipo_entrega === 'PRODUCCION') {
            $produccion = models\production::where('ot', '=', $request->ot)->first();
            if ($produccion->estatus === 'REGISTRADA') {

                $produccion->estatus = "L.PRODUCCION";
                $produccion->save();
            }
        }
        $registro_jets = new models\jets_registros();
        $registro_jets->ot = $request->ot;
        $registro_jets->movimiento = 'ALMACEN - COMPRAS';
        $registro_jets->responsable = Auth::user()->name;
        $registro_jets->save();
        
        

        $ruta = models\jets_rutas::where('ot', '=', $request->ot)->first();
        $ruta->sistema_almacenr = 'DONE';
        $ruta->save();

        return back()->with('mensaje-success', '¡Alta de material registrada!');
    }
}
