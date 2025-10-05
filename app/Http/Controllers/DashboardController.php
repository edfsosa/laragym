<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $cards = [
            [
                'title' => 'Routines completed',
                'description' => 'You have completed 5 routines this week.',
                'value' => 5,
            ],
            [
                'title' => 'Calories burned',
                'description' => 'You have burned 300 calories today.',
                'value' => 300,
            ],
            [
                'title' => 'Active minutes',
                'description' => 'You have been active for 45 minutes today.',
                'value' => 45,
            ]
        ];

        $progress = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'values' => [200, 250, 180, 300, 350, 400, 320],
        ];

        return view('dashboard', compact('cards', 'progress'));
    }
}
