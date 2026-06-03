<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Saving;
use App\Models\SavingTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavingController extends Controller
{
    public function index()
    {
        $savings = Saving::where('user_id', auth()->id())->get();
        return view('member.savings.index', compact('savings'));
    }

    public function create()
    {
        $types = ['wajib', 'manasuka', 'sukarela'];
        return view('member.savings.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:wajib,manasuka,sukarela',
            'amount' => 'required|numeric|min:1000',
        ]);

        DB::transaction(function () use ($validated) {
            $saving = Saving::firstOrCreate(
                ['user_id' => auth()->id(), 'type' => $validated['type']],
                ['amount' => 0, 'balance' => 0]
            );

            SavingTransaction::create([
                'saving_id' => $saving->id,
                'type' => 'deposit',
                'amount' => $validated['amount'],
                'description' => 'Setoran ' . ucfirst($validated['type']),
                'balance_before' => $saving->balance,
                'balance_after' => $saving->balance + $validated['amount'],
            ]);

            $saving->increment('balance', $validated['amount']);
        });

        return redirect()->route('member.savings.index')->with('success', 'Simpanan berhasil ditambahkan');
    }
}