<?php

namespace App\Http\Controllers;

use App\Services\TestLetter\TestLetterService;
use Illuminate\Http\Request;

class TestLetterController extends Controller
{
    protected $testLetterService;
    public function __construct(TestLetterService $testLetterService)
    {
        $this->testLetterService = $testLetterService;
    }

    public function index()
    {
        return view('apps.test-letter.index');
    }
}
