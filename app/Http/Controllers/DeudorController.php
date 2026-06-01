<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class DeudorController extends Controller
{
    public function index()
    {
        $deudores  = Alumno::with(['carrera', 'prestamos' => function($q) {
            $q->where('estado', 'Vencido');
        }])->where('estado', 'Deudor')->get();

        $rezagados = Alumno::with(['carrera', 'prestamos' => function($q) {
            $q->where('estado', 'Vencido');
        }])->where('estado', 'Rezagado')->get();

        return view('deudores.index', compact('deudores', 'rezagados'));
    }
}