<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RevenueController extends Controller
{
    private array $incomeCategories = [
        'ຄ່າລົງທະບຽນ',
        'ຄ່າໜ່ວຍກິດ',
        'ຄ່າໜ່ວຍກິດເທີມ 3',
        'ຄ່າບໍລິການວິຊາການ',
    ];

    public function index()
    {
        $transactions = Transaction::with('department', 'chartOfAccount')
            ->where('type', 'income')
            ->latest('transaction_date')
            ->paginate(15);

        $departments = Department::all();
        $categories = $this->incomeCategories;

        return view('revenue.revenue', compact('transactions', 'departments', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => 'required|string',
            'custom_category'  => 'required_if:category,__custom__|nullable|string|max:100',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
        ]);

        $category = $request->input('category');
        if ($category === '__custom__') {
            $category = $request->input('custom_category');
        }

        Transaction::create([
            'transaction_date' => $request->input('transaction_date'),
            'category'         => $category,
            'description'      => $request->input('description'),
            'amount'           => $request->input('amount'),
            'department_id'    => $request->input('department_id'),
            'type'             => 'income',
        ]);

        return back()->with('success', 'ບັນທຶກລາຍຮັບສຳເລັດ');
    }

    public function edit(Transaction $transaction)
    {
        abort_if($transaction->type !== 'income', 403);

        $departments = Department::all();
        $categories = $this->incomeCategories;

        return view('revenue.edit', compact('transaction', 'departments', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_if($transaction->type !== 'income', 403);

        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => 'required|string',
            'custom_category'  => 'required_if:category,__custom__|nullable|string|max:100',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
        ]);

        $category = $request->input('category');
        if ($category === '__custom__') {
            $category = $request->input('custom_category');
        }

        $transaction->update([
            'transaction_date' => $request->input('transaction_date'),
            'category'         => $category,
            'description'      => $request->input('description'),
            'amount'           => $request->input('amount'),
            'department_id'    => $request->input('department_id'),
        ]);

        return redirect()->route('revenue.index')->with('success', 'ແກ້ໄຂລາຍຮັບສຳເລັດ');
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->type !== 'income', 403);

        $transaction->delete();

        return back()->with('success', 'ລຶບລາຍຮັບສຳເລັດ');
    }
}
