<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanType;
use Illuminate\Http\Request;

class LoanTypeController extends Controller
{
    public function index()
    {
        $loanTypes = LoanType::latest()->get();
        return view('admin.loan-types.index', compact('loanTypes'));
    }

    public function create()
    {
        return view('admin.loan-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0|gte:min_amount',
            'min_tenure' => 'required|integer|min:1',
            'max_tenure' => 'required|integer|min:1|gte:min_tenure',
            'status' => 'required|in:active,inactive',
        ]);

        LoanType::create($validated);

        return redirect()->route('admin.loan-types.index')
            ->with('success', 'Jenis pinjaman berhasil ditambahkan');
    }

    public function edit(LoanType $loanType)
    {
        return view('admin.loan-types.edit', compact('loanType'));
    }

    public function update(Request $request, LoanType $loanType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0|gte:min_amount',
            'min_tenure' => 'required|integer|min:1',
            'max_tenure' => 'required|integer|min:1|gte:min_tenure',
            'status' => 'required|in:active,inactive',
        ]);

        $loanType->update($validated);

        return redirect()->route('admin.loan-types.index')
            ->with('success', 'Jenis pinjaman berhasil diupdate');
    }

    public function destroy(LoanType $loanType)
    {
        $loanType->update(['status' => 'inactive']);
        return redirect()->route('admin.loan-types.index')
            ->with('success', 'Jenis pinjaman dinonaktifkan');
    }
}