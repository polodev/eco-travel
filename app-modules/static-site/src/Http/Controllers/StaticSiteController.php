<?php

namespace Modules\StaticSite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StaticSiteController extends Controller
{
    public function homepage()
    {
        return view('static-site::homepage.homepage');
    }

    public function about()
    {
        return view('static-site::about.about');
    }

    public function flight()
    {
        return view('static-site::flight.flight');
    }

    public function hotel()
    {
        return view('static-site::hotel.hotel');
    }

    public function holidayPackage()
    {
        return view('static-site::holiday-package.holiday-package');
    }

    public function hajjPackage()
    {
        return view('static-site::hajj-package.hajj-package');
    }
}