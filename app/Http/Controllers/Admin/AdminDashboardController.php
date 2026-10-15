<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use App\Models\UserInvestment;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin control center dashboard with live platform metrics.
     */
    public function index(Request $request): View
    {
        $totalInvestors = User::where('role', 'user')->count();

        $totalDeposits = Deposit::where('status', Deposit::STATUS_APPROVED)->sum('final_amount');
        $totalWithdrawals = Withdrawal::where('status', Withdrawal::STATUS_APPROVED)->sum('final_amount');
        $totalInvested = UserInvestment::where('status', UserInvestment::STATUS_ACTIVE)->sum('invested_amount');

        $pendingDepositsCount = Deposit::where('status', Deposit::STATUS_PENDING)->count();
        $pendingWithdrawalsCount = Withdrawal::where('status', Withdrawal::STATUS_PENDING)->count();

        return view('admin.dashboard', [
            'totalInvestors' => $totalInvestors,
            'totalDeposits' => number_format((float) $totalDeposits, 2),
            'totalWithdrawals' => number_format((float) $totalWithdrawals, 2),
            'totalInvested' => number_format((float) $totalInvested, 2),
            'pendingDepositsCount' => $pendingDepositsCount,
            'pendingWithdrawalsCount' => $pendingWithdrawalsCount,
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }
}
