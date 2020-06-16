<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index()
    {
        return [
            [
                'id' => 10001,
                'title' => 'iphone'
            ],
            [
                'id' => 10002,
                'title' => '华为'
            ]
        ];
    }
}
