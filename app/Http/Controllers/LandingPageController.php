<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Membership;
use App\Models\Service;
use App\Models\Testimony;
use App\Settings\LandingPageSettings;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function __invoke(LandingPageSettings $settings)
    {
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $services   = Service::where('is_active', true)->orderBy('sort_order')->take(3)->get();
        $testimonies = Testimony::all();
        $memberships = Membership::where('is_active', true)->take(3)->get();

        return view('welcome', compact('settings', 'facilities', 'services', 'testimonies', 'memberships'));
    }
}
