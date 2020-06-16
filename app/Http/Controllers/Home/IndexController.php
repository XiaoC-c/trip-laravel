<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //

    public function index()
    {
        // select * from

        // ORM    
        $goods = Goods::select(['id', 'title', 'price'])->where('status', 1)->orderBy('price', 'asc')->limit(2)->get();
        return view('home.index', ['message' => 'hello world aaaaa' , 'goods' => $goods]);
    }

    public function show(Request $request)
    {
        echo $request->input('id');
//        return view('home.show', ['id' => $request->input('id')]);
    }
}
