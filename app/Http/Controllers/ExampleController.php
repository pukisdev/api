<?php

namespace App\Http\Controllers;

use DB;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    public function index()
    {
        //
        $hasil = DB::table('tbl_user')->get();
        return $hasil;
    }

    //
}
