<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $options = array();

        return view('vendor.backpack.base.options', ['options' => $options]);
    }
}
