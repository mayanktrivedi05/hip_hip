<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the investor dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('user.dashboard', [
            'user' => $user,
            'mainBalance' => '0.00',
            'profitBalance' => '0.00',
            'referralBalance' => '0.00',
            'totalInvested' => '0.00',
            'totalEarned' => '0.00',
            'activePlansCount' => 0,
            'recentTransactions' => [],
        ]);
    }
}
