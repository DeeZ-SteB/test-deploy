<?php

namespace App\Http\Controllers\Dev\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DevPageController extends Controller
{
    /**
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): View | RedirectResponse
    {
        if (config('app.debug')) {
            return view('_dev.pages.index');
        }

        return redirect()->route('page.main');
    }
}
