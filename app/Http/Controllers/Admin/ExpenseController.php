<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->get();
        $total = $expenses->sum("amount");
        return view("admin.expenses.index", compact("expenses", "total"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "description" => "required|string|max:255",
            "amount" => "required|numeric|min:1",
            "expense_date" => "required|date",
        ]);

        Expense::create($validated);

        return back()->with("success", "Beban berhasil dicatat");
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with("success", "Beban berhasil dihapus");
    }
}
