<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a paginated, filterable audit ledger of investor transactions.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $query = $user->transactions()
            ->with('wallet')
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        // Filter by Transaction Type
        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->trim()->value());
        }

        // Filter by Wallet Type
        if ($request->filled('wallet')) {
            $walletType = $request->string('wallet')->trim()->value();
            $query->whereHas('wallet', function ($wQuery) use ($walletType) {
                $wQuery->where('type', $walletType);
            });
        }

        // Search by Transaction Hash or Description
        if ($request->filled('search')) {
            $search = '%'.$request->string('search')->trim()->value().'%';
            $query->where(function ($sub) use ($search) {
                $sub->where('tx_hash', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        $transactions = $query->paginate(15)->withQueryString();

        return view('user.transactions.index', [
            'transactions' => $transactions,
            'currentType' => $request->input('type'),
            'currentWallet' => $request->input('wallet'),
            'search' => $request->input('search'),
        ]);
    }
}
