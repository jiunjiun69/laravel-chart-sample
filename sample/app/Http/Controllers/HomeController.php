<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $value = DB::table('chart')->orderBy('id', 'desc')->limit(1)->value('value');
        
        return view('chart')->with('value',$value);
    }

    public function chartEventStream()
    {
        // 連線到資料庫
        DB::connection('mysql');

        $data = [
            $t = strtotime('+8 hours'),
            'time' => date('Y-m-d H:i:s', $t),
            
            // 取值
            'value' => DB::table('chart')->orderBy('id', 'desc')->limit(1)->value('value')
        ];

        $response = new StreamedResponse();
        $response->setCallback(function () use ($data){
             echo 'data: ' . json_encode($data) . "\n\n";
             echo "retry: 1000\n";
             ob_flush();
             flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        $response->send();
    }
}
