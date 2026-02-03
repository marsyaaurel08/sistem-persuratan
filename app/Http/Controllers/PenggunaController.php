<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::latest()->get();

        return view('manajemen-pengguna.index', compact('pengguna'));
    }
}
