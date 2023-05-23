<?php

namespace App\Http\Controllers\Pages\PeoplePartner;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PeoplePartnerPageController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        return view('pages.people-partner');
    }
}
