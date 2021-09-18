<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function viewLandingPage() {
        $apiUrl = config('app.apiUrl');
        return view('welcome', compact('apiUrl'));
    }
}
