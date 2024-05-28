<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{



    public function descargaPdf(){
       $pendientes = session()->get('pendientes');
       ///dd($pendientes);
       session()->forget('pendientes');  // Limpia la variable de sesión después de obtenerla
       if (!$pendientes) {
        return abort(404);  // Asegúrate de que hay datos antes de proceder
        }

        $pdf = Pdf::loadView('livewire.pdf.pagados',['pendientes'=>$pendientes]);
         return $pdf->download('resumenpago.pdf');

    }


}
