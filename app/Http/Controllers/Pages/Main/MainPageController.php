<?php

namespace App\Http\Controllers\Pages\Main;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MainPageController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        return view('pages.main');
    }
}
