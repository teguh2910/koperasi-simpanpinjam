<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Saving;
use App\Models\SavingTransaction;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Expense;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function members(Request $request)
    {
        $members = User::where('role', 'member')
            ->with(['savings', 'loans'])
            ->when($request->search, fn($q, $v) => $q->where('name', 'like', "%{$v}%"))
            ->get()
            ->map(fn($m) => (object) [
                'id' => $m->id,
                'name' => $m->name,
                'email' => $m->email,
                'phone' => $m->phone,
                'total_savings' => $m->savings->sum('balance'),
                'active_loans' => $m->loans->whereIn('status', ['approved', 'disbursed'])->sum('outstanding_balance'),
                'loan_count' => $m->loans->whereIn('status', ['approved', 'disbursed'])->count(),
            ]);

        $totals = (object) [
            'members' => $members->count(),
            'savings' => $members->sum('total_savings'),
            'loans' => $members->sum('active_loans'),
        ];

        return view('admin.reports.members', compact('members', 'totals'));
    }

    public function savings(Request $request)
    {
        $query = SavingTransaction::with('savingAccount.user');

        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->member_id) {
            $query->whereHas('savingAccount', fn($q) => $q->where('user_id', $request->member_id));
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->get();

        $members = User::where('role', 'member')->orderBy('name')->get();
        $totals = (object) [
            'deposits' => $transactions->where('type', 'deposit')->sum('amount'),
            'withdrawals' => $transactions->where('type', 'withdrawal')->sum('amount'),
            'count' => $transactions->count(),
        ];

        return view('admin.reports.savings', compact('transactions', 'members', 'totals'));
    }

    public function loans(Request $request)
    {
        $query = Loan::with('user', 'loanType', 'loanPayments');

        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->member_id) {
            $query->where('user_id', $request->member_id);
        }

        $loans = $query->latest()->get()->map(fn($l) => (object) [
            'id' => $l->id,
            'member' => $l->user->name,
            'type' => optional($l->loanType)->name ?? '-',
            'amount' => $l->amount,
            'interest_rate' => $l->interest_rate,
            'tenure' => $l->tenure,
            'monthly_payment' => $l->monthly_payment,
            'total_payment' => $l->total_payment,
            'paid' => $l->loanPayments->sum('amount'),
            'outstanding' => $l->outstanding_balance,
            'status' => $l->status,
            'created_at' => $l->created_at,
            'disbursed_at' => $l->disbursed_at,
        ]);

        $members = User::where('role', 'member')->orderBy('name')->get();
        $totals = (object) [
            'disbursed' => $loans->sum('amount'),
            'paid' => $loans->sum('paid'),
            'outstanding' => $loans->sum('outstanding'),
            'count' => $loans->count(),
        ];

        return view('admin.reports.loans', compact('loans', 'members', 'totals'));
    }

    public function financial(Request $request)
    {
        $savingQuery = SavingTransaction::query();
        $loanQuery = LoanPayment::whereHas('loan');

        if ($request->from) {
            $savingQuery->whereDate('created_at', '>=', $request->from);
            $loanQuery->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $savingQuery->whereDate('created_at', '<=', $request->to);
            $loanQuery->whereDate('created_at', '<=', $request->to);
        }

        $totalDeposits = (clone $savingQuery)->where('type', 'deposit')->sum('amount');
        $totalWithdrawals = (clone $savingQuery)->where('type', 'withdrawal')->sum('amount');
        $totalLoanDisbursed = Loan::when($request->from, fn($q) => $q->whereDate('disbursed_at', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('disbursed_at', '<=', $request->to))
            ->sum('amount');
        $totalPaymentsCollected = (clone $loanQuery)->sum('amount');

        $recap = (object) [
            'total_deposits' => $totalDeposits,
            'total_withdrawals' => $totalWithdrawals,
            'net_savings' => $totalDeposits - $totalWithdrawals,
            'total_loan_disbursed' => $totalLoanDisbursed,
            'total_payments_collected' => $totalPaymentsCollected,
            'total_members' => User::where('role', 'member')->count(),
            'active_loans' => Loan::whereIn('status', ['approved', 'disbursed'])->count(),
            'total_outstanding' => Loan::whereIn('status', ['approved', 'disbursed'])->sum('outstanding_balance'),
        ];

        return view('admin.reports.financial', compact('recap'));
    }

    public function pnl(Request $request)
    {
        $paymentQuery = LoanPayment::whereHas('loan');
        $expenseQuery = Expense::query();

        if ($request->from) {
            $paymentQuery->whereDate('payment_date', '>=', $request->from);
            $expenseQuery->whereDate('expense_date', '>=', $request->from);
        }
        if ($request->to) {
            $paymentQuery->whereDate('payment_date', '<=', $request->to);
            $expenseQuery->whereDate('expense_date', '<=', $request->to);
        }

        $totalInterest = (clone $paymentQuery)->sum('interest');
        $totalPrincipal = (clone $paymentQuery)->sum('principal');
        $totalExpenses = (clone $expenseQuery)->sum('amount');

        $report = (object) [
            'total_interest' => $totalInterest,
            'total_principal' => $totalPrincipal,
            'total_revenue' => $totalInterest + $totalPrincipal,
            'expenses' => $totalExpenses,
            'net_profit' => $totalInterest - $totalExpenses,
        ];

        $daily = LoanPayment::whereHas('loan')
            ->when($request->from, fn($q) => $q->whereDate('payment_date', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('payment_date', '<=', $request->to))
            ->selectRaw("DATE(payment_date) as date, SUM(interest) as interest, SUM(principal) as principal, SUM(interest + principal) as total")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $expenses = (clone $expenseQuery)->latest()->get();

        return view('admin.reports.pnl', compact('report', 'daily', 'expenses'));
    }

    public function profitData(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $paymentQuery = LoanPayment::whereHas('loan');
        $expenseQuery = Expense::query();

        if ($from) {
            $paymentQuery->whereDate('payment_date', '>=', $from);
            $expenseQuery->whereDate('expense_date', '>=', $from);
        }
        if ($to) {
            $paymentQuery->whereDate('payment_date', '<=', $to);
            $expenseQuery->whereDate('expense_date', '<=', $to);
        }

        $totalInterest = (clone $paymentQuery)->sum('interest');
        $totalExpenses = (clone $expenseQuery)->sum('amount');

        return response()->json([
            'total_interest' => (float) $totalInterest,
            'total_expenses' => (float) $totalExpenses,
            'net_profit' => (float) ($totalInterest - $totalExpenses),
        ]);
    }
}
