<?php

namespace App\Http\Controllers\Pages\Recruiting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RecruitingPageController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        return view('pages.recruiting');
    }
}
