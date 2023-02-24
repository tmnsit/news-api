<?php

namespace App\Http\Controllers;

use App\Actions\NewsParserAction;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(NewsParserAction $parser)
    {
        $parser->handle();


        return view('welcome');
    }
}
