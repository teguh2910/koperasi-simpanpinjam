<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saving;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function index()
    {
        $savings = Saving::with('user')->latest()->get();
        return view('admin.savings.index', compact('savings'));
    }

    public function show(Saving $saving)
    {
        $transactions = $saving->savingTransactions()->latest()->paginate(20);
        return view('admin.savings.show', compact('saving', 'transactions'));
    }
}