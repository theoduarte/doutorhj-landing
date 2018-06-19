<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultaCheckup()
    {
        return view('checkup.index');
    }
    
}
