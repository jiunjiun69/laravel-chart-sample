<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function chart()
    {
        // 連線到資料庫
        DB::connection('mysql');

        // 取值
        $value = DB::table('chart')->orderBy('time', 'desc')->limit(1)->value('value');
        
        return view('chart')->with('value',$value);
    }
}
