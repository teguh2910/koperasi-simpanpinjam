<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SHUPeriod;
use App\Models\SHUMember;
use App\Models\User;
use App\Models\Saving;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Expense;
use Illuminate\Http\Request;

class SHUController extends Controller
{
    public function index()
    {
        $periods = SHUPeriod::withCount("members")->latest()->get();
        return view("admin.shu.index", compact("periods"));
    }

    public function create()
    {
        return view("admin.shu.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "period_start" => "required|date",
            "period_end" => "required|date|after_or_equal:period_start",
            "total_profit" => "required|numeric|min:1",
            "member_share_percent" => "required|numeric|min:0|max:100",
            "savings_weight" => "required|numeric|min:0|max:100",
            "loan_weight" => "required|numeric|min:0|max:100",
        ]);

        if ($validated["savings_weight"] + $validated["loan_weight"] != 100) {
            return back()->withInput()->withErrors(["savings_weight" => "Total bobot simpanan + pinjaman harus 100%"]);
        }

        $period = SHUPeriod::create([
            "name" => $validated["name"],
            "period_start" => $validated["period_start"],
            "period_end" => $validated["period_end"],
            "total_profit" => $validated["total_profit"],
            "member_share_percent" => $validated["member_share_percent"],
            "savings_weight" => $validated["savings_weight"],
            "loan_weight" => $validated["loan_weight"],
            "total_shu" => $validated["total_profit"] * $validated["member_share_percent"] / 100,
        ]);

        return redirect()->route("admin.shu.calculate", $period)
            ->with("success", "Periode SHU berhasil dibuat. Silakan hitung SHU anggota.");
    }

    public function calculate(SHUPeriod $shuPeriod)
    {
        $members = User::where("role", "member")->get();
        $totalSavings = Saving::whereHas("user", fn($q) => $q->where("role", "member"))
            ->where("status", "active")->sum("balance");
        $totalInterest = LoanPayment::whereHas("loan", fn($q) => $q->whereHas("user", fn($q2) => $q2->where("role", "member")))
            ->whereBetween("payment_date", [$shuPeriod->period_start, $shuPeriod->period_end])
            ->sum("interest");

        $shuPeriod->members()->delete();
        $totalSHU = $shuPeriod->total_shu;

        foreach ($members as $member) {
            $savingsBalance = Saving::where("user_id", $member->id)
                ->where("status", "active")->sum("balance");
            $interestPaid = LoanPayment::whereHas("loan", fn($q) => $q->where("user_id", $member->id))
                ->whereBetween("payment_date", [$shuPeriod->period_start, $shuPeriod->period_end])
                ->sum("interest");

            $savingsPercent = $totalSavings > 0 ? ($savingsBalance / $totalSavings) * 100 : 0;
            $loanPercent = $totalInterest > 0 ? ($interestPaid / $totalInterest) * 100 : 0;

            $shuFromSavings = $totalSHU * ($shuPeriod->savings_weight / 100) * ($savingsPercent / 100);
            $shuFromLoans = $totalSHU * ($shuPeriod->loan_weight / 100) * ($loanPercent / 100);
            $shuAmount = $shuFromSavings + $shuFromLoans;

            if ($shuAmount > 0 || $savingsBalance > 0) {
                SHUMember::create([
                    "shu_period_id" => $shuPeriod->id,
                    "user_id" => $member->id,
                    "savings_balance" => $savingsBalance,
                    "loan_interest_paid" => $interestPaid,
                    "savings_percent" => $savingsPercent,
                    "loan_percent" => $loanPercent,
                    "shu_amount" => $shuAmount,
                ]);
            }
        }

        $shuPeriod->update(["status" => "completed"]);

        return redirect()->route("admin.shu.show", $shuPeriod)
            ->with("success", "SHU berhasil dihitung untuk " . $members->count() . " anggota");
    }

    public function show(SHUPeriod $shuPeriod)
    {
        $shuPeriod->load("members.user");

        $totalDistributed = $shuPeriod->members->sum("shu_amount");
        $retainedEarnings = $shuPeriod->total_profit - $shuPeriod->total_shu;

        $interestIncome = LoanPayment::whereHas("loan", fn($q) => $q->whereHas("user", fn($q2) => $q2->where("role", "member")))
            ->whereBetween("payment_date", [$shuPeriod->period_start, $shuPeriod->period_end])
            ->sum("interest");

        $totalExpenses = Expense::whereBetween("expense_date", [$shuPeriod->period_start, $shuPeriod->period_end])
            ->sum("amount");

        $totalSavings = Saving::whereHas("user", fn($q) => $q->where("role", "member"))
            ->where("status", "active")
            ->whereBetween("created_at", [$shuPeriod->period_start, $shuPeriod->period_end])
            ->sum("balance");

        $loanDisbursed = Loan::whereHas("user", fn($q) => $q->where("role", "member"))
            ->whereBetween("disbursed_at", [$shuPeriod->period_start, $shuPeriod->period_end])
            ->sum("amount");

        $membersCount = User::where("role", "member")->count();
        $shuMembersCount = $shuPeriod->members->count();

        return view("admin.shu.show", compact(
            "shuPeriod", "totalDistributed", "retainedEarnings",
            "interestIncome", "totalExpenses", "totalSavings",
            "loanDisbursed", "membersCount", "shuMembersCount"
        ));
    }

    public function destroy(SHUPeriod $shuPeriod)
    {
        $shuPeriod->delete();
        return redirect()->route("admin.shu.index")->with("success", "Periode SHU berhasil dihapus");
    }
}
