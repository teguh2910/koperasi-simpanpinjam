<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanType;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('loanType')->where('user_id', auth()->id())->latest()->get();
        return view('member.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        $loan->load('loanPayments', 'loanType');

        $startDate = $loan->disbursed_at ?? $loan->created_at;
        $payments = $loan->loanPayments->sortBy('payment_date')->values();
        $schedule = [];

        for ($i = 1; $i <= $loan->tenure; $i++) {
            $dueDate = $startDate->copy()->addMonths($i);
            $payment = $payments->get($i - 1);

            $schedule[] = (object) [
                'month' => $i,
                'due_date' => $dueDate,
                'amount' => $payment ? $payment->amount : $loan->monthly_payment,
                'is_paid' => (bool) $payment,
                'paid_at' => $payment ? $payment->payment_date : null,
            ];
        }

        return view('member.loans.show', compact('loan', 'schedule'));
    }

    public function create()
    {
        $loanTypes = LoanType::where('status', 'active')->get();
        return view('member.loans.create', compact('loanTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_type_id' => 'required|exists:loan_types,id',
            'amount' => 'required|numeric|min:100000',
            'tenure' => 'required|integer|min:1',
        ]);

        $loanType = LoanType::findOrFail($validated['loan_type_id']);

        if ($validated['amount'] < $loanType->min_amount || $validated['amount'] > $loanType->max_amount) {
            return back()->withInput()->withErrors(['amount' => 'Jumlah pinjaman harus antara Rp ' . number_format($loanType->min_amount, 0, ',', '.') . ' - Rp ' . number_format($loanType->max_amount, 0, ',', '.')]);
        }

        if ($validated['tenure'] < $loanType->min_tenure || $validated['tenure'] > $loanType->max_tenure) {
            return back()->withInput()->withErrors(['tenure' => 'Tenor harus antara ' . $loanType->min_tenure . ' - ' . $loanType->max_tenure . ' bulan']);
        }

        $existingTotal = Loan::where('user_id', auth()->id())
            ->where('loan_type_id', $loanType->id)
            ->whereIn('status', ['pending', 'approved', 'disbursed'])
            ->sum('amount');

        if (($existingTotal + $validated['amount']) > $loanType->max_amount) {
            return back()->withInput()->withErrors(['amount' => 'Total pinjaman Anda untuk jenis ini sudah melebihi batas maksimal Rp ' . number_format($loanType->max_amount, 0, ',', '.')]);
        }

        $totalInterest = $validated['amount'] * ($loanType->interest_rate / 100) * ($validated['tenure'] / 12);
        $totalPayment = $validated['amount'] + $totalInterest;
        $monthlyPayment = round($totalPayment / $validated['tenure']);
        $totalPayment = $monthlyPayment * $validated['tenure'];

        Loan::create([
            'user_id' => auth()->id(),
            'loan_type_id' => $loanType->id,
            'amount' => $validated['amount'],
            'interest_rate' => $loanType->interest_rate,
            'tenure' => $validated['tenure'],
            'monthly_payment' => $monthlyPayment,
            'total_payment' => $totalPayment,
            'outstanding_balance' => $totalPayment,
        ]);

        return redirect()->route('member.loans.index')->with('success', 'Pengajuan pinjaman berhasil dikirim');
    }
}