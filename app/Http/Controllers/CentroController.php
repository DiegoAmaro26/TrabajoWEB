<?php

namespace App\Http\Controllers;


class CentroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\Models\User::all();
        return view('centros', compact('users'));
    }
}