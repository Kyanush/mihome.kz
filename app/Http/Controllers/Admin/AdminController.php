<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:admin');
    }

    public function index(){
        return view('admin.index');
    }

    public function sendResponse($data, $status = 200)
    {
        return response()->json($data, $status);
    }

}