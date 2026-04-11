<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('department', 'chartOfAccount')
            ->where('type', 'expense')
            ->latest('transaction_date')
            ->paginate(15);

        $accounts = ChartOfAccount::orderBy('account_code')->get();
        $departments = Department::all();

        return view('expense.expense', compact('transactions', 'accounts', 'departments'));
    }

    public function store(Request $request)
    {
        $expenseCategories = [
            'ເງິນອຸດໜູນ ແລະ ນະໂຍບາຍ',
            'ການຊື້ ແລະ ການຊົມໃຊ້',
            'ການບໍລິການຈາກທາງນອກ',
            'ລາຍຈ່າຍກອງປະຊຸມ ສຳມະນາ ແລະ ຝຶກອົບຮົມ',
            'ດັດສົມ ແລະ ສົ່ງເສີມວັດທະນະທຳ - ສັງຄົມ',
            'ລາຍຈ່າຍບໍລິຫານປົກກະຕິອື່ນໆ',
            'ຊື້ຊັບສົມບັດຄົງທີ່',
        ];

        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => ['required', Rule::in($expenseCategories)],
            'description'      => 'required|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'account_id'       => 'required|exists:chart_of_accounts,id',
            'department_id'    => 'required|exists:departments,id',
        ]);

        Transaction::create([
            ...$request->only(['transaction_date', 'category', 'description', 'amount', 'account_id', 'department_id']),
            'type' => 'expense',
        ]);

        return back()->with('success', 'ບັນທຶກລາຍຈ່າຍສຳເລັດ');
    }
}
