<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserInvestment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the investor dashboard with real wallet balances.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('user.dashboard', [
            'user' => $user,
            'mainBalance' => $user->mainBalance(),
            'profitBalance' => $user->profitBalance(),
            'referralBalance' => $user->referralBalance(),
            'totalInvested' => $user->totalInvested(),
            'totalEarned' => number_format((float) $user->investments()->sum('total_returned'), 2),
            'activePlansCount' => $user->investments()->where('status', UserInvestment::STATUS_ACTIVE)->count(),
            'recentTransactions' => $user->transactions()->with('wallet')->latest()->take(5)->get(),
        ]);
    }
}
