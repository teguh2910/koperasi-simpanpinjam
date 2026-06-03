<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user', 'loanType')->latest()->get();
        return view('admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load('user', 'loanType', 'loanPayments');

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

        return view('admin.loans.show', compact('loan', 'schedule'));
    }

    public function approve(Loan $loan)
    {
        $loan->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Pinjaman berhasil disetujui');
    }

    public function reject(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        return back()->with('success', 'Pinjaman berhasil ditolak');
    }

    public function disburse(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'disbursed_at' => 'required|date',
        ]);

        $loan->update([
            'status' => 'disbursed',
            'disbursed_at' => $validated['disbursed_at'],
        ]);

        return back()->with('success', 'Pinjaman berhasil dicairkan tanggal ' . date('d/m/Y', strtotime($validated['disbursed_at'])));
    }

    public function storePayment(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        if ($loan->outstanding_balance <= 0) {
            return back()->with('error', 'Pinjaman sudah lunas');
        }

        $paymentAmount = min($validated['amount'], $loan->outstanding_balance);
        $monthlyPrincipal = $loan->amount / $loan->tenure;
        $monthlyInterest = ($loan->total_payment - $loan->amount) / $loan->tenure;

        if ($paymentAmount >= $loan->monthly_payment) {
            $principalPortion = $monthlyPrincipal;
            $interestPortion = $monthlyInterest;
        } else {
            $principalPortion = $paymentAmount;
            $interestPortion = 0;
        }

        LoanPayment::create([
            'loan_id' => $loan->id,
            'amount' => $paymentAmount,
            'principal' => $principalPortion,
            'interest' => $interestPortion,
            'payment_date' => $validated['payment_date'],
        ]);

        $newOutstanding = $loan->outstanding_balance - $paymentAmount;
        $loan->update([
            'outstanding_balance' => max(0, $newOutstanding),
            'status' => $newOutstanding <= 0 ? 'completed' : 'disbursed',
        ]);

        return back()->with('success', 'Pembayaran Rp ' . number_format($paymentAmount, 0, ',', '.') . ' berhasil dicatat');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('admin.loans.index')->with('success', 'Pinjaman berhasil dihapus');
    }
}