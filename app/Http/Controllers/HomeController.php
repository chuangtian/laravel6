<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //发送的消息获取
        $messageModel=new Message();
        $messahe=$messageModel->getMessage();
        dd($messahe);
        return view('home');
    }
}
