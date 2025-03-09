<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

class SecureFileController extends Controller
{
    public function index($path)
    {
        // decrypt
        $path = storage_path('app/public/'.Helper::decrypt($path));
        return response()->file($path);
    }
}
