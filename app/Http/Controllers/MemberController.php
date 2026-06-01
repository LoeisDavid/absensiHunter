<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.index');
    }

    public function peserta()
    {
        return view('member.peserta');
    }

    public function pengurus()
    {
        return view('member.pengurus');
    }

    public function show()
    {
        return view('member.show');
    }
}
