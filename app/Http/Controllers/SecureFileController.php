<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;

class SecureFileController extends Controller
{
    /**
     * direct download file yang di enkripsi
     * @param $path
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index($path)
    {
        // decrypt
        $newPath = storage_path('app/public/'.Helper::decrypt($path));
        return response()->download($newPath);
    }

    /**
     * menampilkan file yang di enkripsi
     * @param $path
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($path)
    {
        // decrypt
        $newPath = storage_path('app/public/'.Helper::decrypt($path));
        return response()->file($newPath);
    }
}
