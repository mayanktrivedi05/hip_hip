<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    /**
     * Display the system-wide master audit ledger for administrators.
     */
    public function index(Request $request): View
    {
        $query = Transaction::query()
            ->with(['user', 'wallet'])
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        // Filter by Transaction Type
        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->trim()->value());
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->trim()->value());
        }

        // Filter by Wallet Type
        if ($request->filled('wallet')) {
            $walletType = $request->string('wallet')->trim()->value();
            $query->whereHas('wallet', function ($wQuery) use ($walletType) {
                $wQuery->where('type', $walletType);
            });
        }

        // Search by Member Name, Email, TX Hash, or Description
        if ($request->filled('search')) {
            $search = '%'.$request->string('search')->trim()->value().'%';
            $query->where(function ($sub) use ($search) {
                $sub->where('tx_hash', 'like', $search)
                    ->orWhere('description', 'like', $search)
                    ->orWhereHas('user', function ($uQuery) use ($search) {
                        $uQuery->where('name', 'like', $search)
                            ->orWhere('email', 'like', $search);
                    });
            });
        }

        $transactions = $query->paginate(20)->withQueryString();

        // High-level statistics
        $stats = [
            'total_volume' => number_format((float) Transaction::where('status', 'completed')->sum('amount'), 2),
            'total_txns' => Transaction::count(),
            'deposits_count' => Transaction::where('type', Transaction::TYPE_DEPOSIT)->count(),
            'roi_count' => Transaction::where('type', Transaction::TYPE_ROI_PAYOUT)->count(),
        ];

        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'stats' => $stats,
            'currentType' => $request->input('type'),
            'currentStatus' => $request->input('status'),
            'currentWallet' => $request->input('wallet'),
            'search' => $request->input('search'),
        ]);
    }
}
