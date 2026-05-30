<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Transaction;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    private const ADVANCE_PAYMENT_MSG = 'ບໍ່ສາມາດແກ້ໄຂລາຍຈ່າຍເບີກລ່ວງໜ້າໄດ້';

    private array $expenseCategories = [
        'ສົ່ງເສີມຊີວາການ',
        'ງົບປະມານສົ່ງເສີມວິຊາການ',
        'ຮັບໃຊ້ການທົດລອງ',
        'ການເຄື່ອນໄຫວນອກຫຼັກສູດ',
    ];

    public function index()
    {
        $transactions = Transaction::with(['department', 'chartOfAccount'])
            ->where('type', 'expense')
            ->whereDoesntHave('advanceRequest')
            ->latest('transaction_date')
            ->paginate(15);

        $departments = Department::orderedForSelect();
        $accounts = ChartOfAccount::orderBy('account_code')->get();

        $defaultYear = (int) date('Y');
        $nextPaymentCode = $this->calculateNextPaymentCode($defaultYear);

        return view('expense.expense', compact('transactions', 'departments', 'accounts', 'nextPaymentCode'));
    }

    public function getNextCode(Request $request)
    {
        $year = $request->query('year', date('Y'));
        
        if (!preg_match('/^\d{4}$/', $year)) {
            return response()->json(['error' => 'Invalid year format'], 400);
        }

        $nextCode = $this->calculateNextPaymentCode((int)$year);

        return response()->json(['payment_code' => $nextCode]);
    }

    private function calculateNextPaymentCode(int $year): string
    {
        $latest = Transaction::where('type', 'expense')
            ->where('payment_code', 'like', "%.$year")
            ->orderBy('payment_code', 'desc')
            ->first();

        $nextSeq = 1;
        if ($latest && preg_match('/^(\d{5})\.(\d{4})$/', $latest->payment_code, $matches)) {
            $nextSeq = ((int) $matches[1]) + 1;
        }

        return sprintf('%05d.%d', $nextSeq, $year);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => ['required', Rule::in($this->expenseCategories)],
            'payment_code'     => 'required|string|max:50',
            'item_name'        => 'required|string|max:255',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
            'account_id'       => 'required|exists:chart_of_accounts,id',
            'expense_type'     => 'nullable|string|max:100',
            'channel_type'     => 'nullable|string|max:100',
        ]);

        $expenseType = $request->input('expense_type', 'ງົບປະມານວິຊາການ');
        $channelType = $request->input('channel_type', 'ເງິນບໍລິຫານທົ່ວໄປ');
        $userDesc = $request->input('description');

        $metadata = "[ປະເພດລາຍຈ່າຍ: {$expenseType}] [ຊ່ອງ ປຕ/ປທ: {$channelType}]";
        $finalDescription = $userDesc ? "{$metadata} {$userDesc}" : $metadata;

        Transaction::create([
            ...$request->only(['transaction_date', 'category', 'payment_code', 'item_name', 'amount', 'department_id', 'account_id']),
            'description' => $finalDescription,
            'type'        => 'expense',
        ]);

        return back()->with('success', 'ບັນທຶກລາຍຈ່າຍສຳເລັດ');
    }

    public function edit(Transaction $transaction)
    {
        $this->ensureEditableExpense($transaction);

        $departments = Department::orderedForSelect();
        $accounts = ChartOfAccount::orderBy('account_code')->get();

        // Parse metadata from description
        $desc = $transaction->getRawOriginal('description') ?? '';
        $expenseType = 'ງົບປະມານວິຊາການ';
        $channelType = 'ເງິນບໍລິຫານທົ່ວໄປ';
        
        if (preg_match('/\[ປະເພດລາຍຈ່າຍ:\s*(.*?)\]/', $desc, $matches)) {
            $expenseType = $matches[1];
            $desc = str_replace($matches[0], '', $desc);
        }
        if (preg_match('/\[ຊ່ອງ ປຕ\/ປທ:\s*(.*?)\]/', $desc, $matches)) {
            $channelType = $matches[1];
            $desc = str_replace($matches[0], '', $desc);
        }
        $userDesc = trim($desc);

        return view('expense.edit', compact('transaction', 'departments', 'accounts', 'expenseType', 'channelType', 'userDesc'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->ensureEditableExpense($transaction);

        $request->validate([
            'transaction_date' => 'required|date',
            'category'         => ['required', Rule::in($this->expenseCategories)],
            'payment_code'     => 'required|string|max:50',
            'item_name'        => 'required|string|max:255',
            'description'      => 'nullable|string|max:500',
            'amount'           => 'required|numeric|min:1',
            'department_id'    => 'required|exists:departments,id',
            'account_id'       => 'required|exists:chart_of_accounts,id',
            'expense_type'     => 'nullable|string|max:100',
            'channel_type'     => 'nullable|string|max:100',
        ]);

        $expenseType = $request->input('expense_type', 'ງົບປະມານວິຊາການ');
        $channelType = $request->input('channel_type', 'ເງິນບໍລິຫານທົ່ວໄປ');
        $userDesc = $request->input('description');

        $metadata = "[ປະເພດລາຍຈ່າຍ: {$expenseType}] [ຊ່ອງ ປຕ/ປທ: {$channelType}]";
        $finalDescription = $userDesc ? "{$metadata} {$userDesc}" : $metadata;

        $transaction->update([
            ...$request->only(['transaction_date', 'category', 'payment_code', 'item_name', 'amount', 'department_id', 'account_id']),
            'description' => $finalDescription,
        ]);

        return redirect()->route('expense.index')->with('success', 'ແກ້ໄຂລາຍຈ່າຍສຳເລັດ');
    }

    public function destroy(Transaction $transaction)
    {
        $this->ensureEditableExpense($transaction);

        $transaction->delete();

        return back()->with('success', 'ລຶບລາຍຈ່າຍສຳເລັດ');
    }

    private function ensureEditableExpense(Transaction $transaction): void
    {
        abort_if($transaction->type !== 'expense', 403);
        abort_if($transaction->advanceRequest()->exists(), 403, self::ADVANCE_PAYMENT_MSG);
    }
}
