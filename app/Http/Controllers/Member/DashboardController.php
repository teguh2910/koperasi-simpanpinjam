<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Saving;
use App\Models\Loan;
use App\Models\SHUMember;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $savings = Saving::where('user_id', $user->id)->get();
        $loans = Loan::where('user_id', $user->id)->get();
        $shuRecords = SHUMember::where('user_id', $user->id)
            ->whereHas('period', fn($q) => $q->where('status', 'completed'))
            ->with('period')
            ->latest('shu_period_id')
            ->get();

        $totalBalance = $savings->sum('balance');
        $activeLoans = $loans->where('status', 'disbursed')->sum('outstanding_balance');
        $totalSHU = $shuRecords->sum('shu_amount');
        $latestSHU = $shuRecords->first();

        return view('member.dashboard', compact(
            'savings', 'loans', 'totalBalance', 'activeLoans',
            'shuRecords', 'totalSHU', 'latestSHU'
        ));
    }
}