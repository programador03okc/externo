<?php

namespace App\Http\Controllers;

use App\Helpers\Proformas\ProformaExport;
use App\Models\Proforma\ProformaExportarExternoView;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportarProformaController extends Controller
{
    public function index()
    {
        return view('proforma.exportar');
    }

    public function generarArchivo(Request $request)
    {
        $data = ProformaExportarExternoView::
            where('windows',$request->windows)
            ->where('office',$request->office)
            ->whereBetween('fecha_emision',[Carbon::createFromFormat('d-m-Y', $request->fechaEmisionDesde)->toDateString(),Carbon::createFromFormat('d-m-Y', $request->fechaEmisionHasta)->toDateString()]);
        
        $exportar = new ProformaExport();
        $exportar->exportar($data->orderBy('requerimiento', 'desc')->get());
    }
}
