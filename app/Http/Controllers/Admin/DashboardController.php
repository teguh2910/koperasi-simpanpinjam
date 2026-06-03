<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;
use App\Models\Saving;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = User::where('role', 'member')->count();
        $totalSavings = Saving::sum('balance');
        $totalLoans = Loan::where('status', 'disbursed')->sum('outstanding_balance');
        $pendingLoans = Loan::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalMembers', 'totalSavings', 'totalLoans', 'pendingLoans'));
    }
}