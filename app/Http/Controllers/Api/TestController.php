<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function a()
    {
        echo __METHOD__;
    }

    public function b()
    {
        echo __METHOD__;
    }

    public function c()
    {
        echo __METHOD__;
    }

    public function x()
    {
        echo __METHOD__;
    }

    public function y()
    {
        echo __METHOD__;
    }

    public function z()
    {
        echo __METHOD__;
    }
}
