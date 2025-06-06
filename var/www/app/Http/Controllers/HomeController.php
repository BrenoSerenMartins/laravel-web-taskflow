<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const HOME_VIEW = 'home.show';

    public function show(): Factory|Application|View
    {
        $title = 'Home';
        return view(self::HOME_VIEW, compact('title'));
    }
}
