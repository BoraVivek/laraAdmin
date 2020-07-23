<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $stats = $this->fetchStats();

        return view('admin.dashboard', [
            'stats' => $stats
        ]);
    }

    public function fetchStats()
    {
        $usersStat = Cache::remember('users_count', 1 * 60, function () {
            return User::count();
        });

        $stats = ['usersStat' => $usersStat];

        return $stats;
    }
}
