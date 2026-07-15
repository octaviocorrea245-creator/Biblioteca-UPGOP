<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class DeudorController extends Controller
{
   public function index()
    {
        $deudores = Alumno::deudores()->with(['carrera', 'prestamos' => function($q) {
            $q->vencidos();
        }])->get();

        $rezagados = Alumno::rezagados()->with(['carrera', 'prestamos' => function($q) {
            $q->vencidos();
        }])->get();

        return view('deudores.index', compact('deudores', 'rezagados'));
    }
}