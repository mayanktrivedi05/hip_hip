<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin control center dashboard.
     */
    public function index(Request $request): View
    {
        $totalInvestors = User::where('role', 'user')->count();

        return view('admin.dashboard', [
            'totalInvestors' => $totalInvestors,
            'totalDeposits' => '0.00',
            'totalWithdrawals' => '0.00',
            'totalInvested' => '0.00',
            'pendingDepositsCount' => 0,
            'pendingWithdrawalsCount' => 0,
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }
}
