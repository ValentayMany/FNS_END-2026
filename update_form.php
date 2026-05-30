<?php
$expenseFile = "d:/FNS/FNS_END-2026/resources/views/expense/expense.blade.php";
$editFile = "d:/FNS/FNS_END-2026/resources/views/expense/edit.blade.php";

function generateFormContent($isEdit) {
    $route = $isEdit ? "{{ route('expense.update', \$expense->id) }}" : "{{ route('expense.store') }}";
    $method = $isEdit ? "@method('PUT')" : "";
    $paymentCodeVal = $isEdit ? "{{ old('payment_code', \$expense->payment_code) }}" : "{{ old('payment_code', \$nextPaymentCode) }}";
    $transactionDateVal = $isEdit ? "{{ old('transaction_date', \$expense->transaction_date ? \Carbon\Carbon::parse(\$expense->transaction_date)->format('Y-m-d') : '') }}" : "{{ old('transaction_date', date('Y-m-d')) }}";
    $budYearVal = $isEdit ? "{{ old('budget_year', \$expense->budget_year) }}" : "{{ old('budget_year', date('Y')) }}";
    $itemNameVal = $isEdit ? "{{ old('item_name', \$expense->item_name) }}" : "{{ old('item_name') }}";
    $amountVal = $isEdit ? "{{ old('amount', \$expense->amount) }}" : "{{ old('amount') }}";
    
    // Select values
    $accOld = $isEdit ? "old('account_id', \$expense->account_id)" : "old('account_id')";
    $deptOld = $isEdit ? "old('department_id', \$expense->department_id)" : "old('department_id')";
    $catOld = $isEdit ? "old('category', \$expense->category)" : "old('category')";
    $typeOld = $isEdit ? "old('expense_type', \$expense->expense_type)" : "old('expense_type')";
    $chanOld = $isEdit ? "old('channel_type', \$expense->channel_type)" : "old('channel_type')";
    
    $descVal = $isEdit ? "{{ old('description', \$expense->description) }}" : "{{ old('description') }}";
    $btnText = $isEdit ? "ອັບເດດລາຍຈ່າຍ" : "ບັນທຶກລາຍຈ່າຍວິຊາການ";

    return <<<HTML
                        <div class="fns-card-body bg-gray-50/30 relative z-10 p-5 sm:p-6">
                            <form method="POST" action="{$route}" class="space-y-4">
                                @csrf
                                {$method}

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Row 1 -->
                                    <div>
                                        <label for="payment_code" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລະຫັດລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="payment_code" name="payment_code" type="text"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{$paymentCodeVal}" required readonly />
                                    </div>
                                    <div>
                                        <label for="transaction_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ວັນທີຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="transaction_date" name="transaction_date" type="date"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{$transactionDateVal}" required />
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="sm:col-span-2">
                                        <label for="item_name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊື່ລາຍການຈ່າຍ <span class="text-red-500">*</span></label>
                                        <input id="item_name" name="item_name" type="text"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{$itemNameVal}" placeholder="ເຊັ່ນ: ຄ່າອຸປະກອນ, ຄ່າບໍລິການ..." required />
                                    </div>

                                    <!-- Row 3 -->
                                    <div>
                                        <label for="budget_year" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປີງົບປະມານ</label>
                                        <input id="budget_year" name="budget_year" type="text"
                                            class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full"
                                            value="{$budYearVal}" />
                                    </div>
                                    <div>
                                        <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຈໍານວນເງິນຈ່າຍ (ກີບ) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 font-bold sm:text-sm">₭</span>
                                            </div>
                                            <input id="amount" name="amount" type="number" min="1" step="0.01"
                                                class="ui-input bg-white pl-8 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all font-bold text-rose-700 w-full"
                                                value="{$amountVal}" placeholder="0.00" required />
                                        </div>
                                    </div>

                                    <!-- Row 4 -->
                                    <div class="sm:col-span-2">
                                        <label for="account_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ເລກບັນຊີ <span class="text-red-500">*</span></label>
                                        <select id="account_id" name="account_id" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                            <option value="">-- ເລືອກເລກບັນຊີ --</option>
                                            @foreach (\$accounts as \$acc)
                                                <option value="{{ \$acc->id }}" {{ {$accOld} == \$acc->id ? 'selected' : '' }}>
                                                    {{ \$acc->account_code }} - {{ \$acc->account_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Row 5 -->
                                    <div>
                                        <label for="department_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ພາກສ່ວນຈ່າຍ <span class="text-red-500">*</span></label>
                                        <select id="department_id" name="department_id" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                            <option value="">-- ເລືອກພາກສ່ວນຈ່າຍ --</option>
                                            @foreach (\$departments as \$dept)
                                                <option value="{{ \$dept->id }}" {{ {$deptOld} == \$dept->id ? 'selected' : '' }}>
                                                    {{ \$dept->displayName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="category" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊ່ອງລາຍຈ່າຍ <span class="text-red-500">*</span></label>
                                        <select id="category" name="category" required class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                            <option value="ງົບປະມານສົ່ງເສີມວິຊາການ" {{ {$catOld} == 'ງົບປະມານສົ່ງເສີມວິຊາການ' ? 'selected' : '' }}>ງົບປະມານສົ່ງເສີມວິຊາການ</option>
                                            <option value="ຮັບໃຊ້ການທົດລອງ" {{ {$catOld} == 'ຮັບໃຊ້ການທົດລອງ' ? 'selected' : '' }}>ຮັບໃຊ້ການທົດລອງ</option>
                                            <option value="ການເຄື່ອນໄຫວນອກຫຼັກສູດ" {{ {$catOld} == 'ການເຄື່ອນໄຫວນອກຫຼັກສູດ' ? 'selected' : '' }}>ການເຄື່ອນໄຫວນອກຫຼັກສູດ</option>
                                        </select>
                                    </div>

                                    <!-- Row 6 -->
                                    <div>
                                        <label for="expense_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ປະເພດລາຍຈ່າຍ</label>
                                        <select id="expense_type" name="expense_type" class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                            <option value="ງົບປະມານວິຊາການ" {{ {$typeOld} == 'ງົບປະມານວິຊາການ' ? 'selected' : '' }}>ງົບປະມານວິຊາການ</option>
                                            <option value="ງົບປະມານບໍລິຫານ" {{ {$typeOld} == 'ງົບປະມານບໍລິຫານ' ? 'selected' : '' }}>ງົບປະມານບໍລິຫານ</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="channel_type" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ຊ່ອງ ປຕ/ປທ</label>
                                        <select id="channel_type" name="channel_type" class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full cursor-pointer">
                                            <option value="ເງິນບໍລິຫານທົ່ວໄປ" {{ {$chanOld} == 'ເງິນບໍລິຫານທົ່ວໄປ' ? 'selected' : '' }}>ເງິນບໍລິຫານທົ່ວໄປ</option>
                                            <option value="ເງິນຕ່າງປະເທດ" {{ {$chanOld} == 'ເງິນຕ່າງປະເທດ' ? 'selected' : '' }}>ເງິນຕ່າງປະເທດ</option>
                                        </select>
                                    </div>

                                    <!-- Row 7 -->
                                    <div class="sm:col-span-2">
                                        <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">ລາຍລະອຽດ <span class="text-gray-400 font-normal lowercase">(ບໍ່ຈຳເປັນ)</span></label>
                                        <textarea id="description" name="description" rows="2" class="ui-input bg-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all text-sm w-full resize-none placeholder-gray-300" placeholder="ອະທິບາຍເພິ່ມເຕີມ...">{$descVal}</textarea>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full ui-btn bg-indigo-500 text-white hover:bg-indigo-600 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 text-sm py-2.5 outline-none focus:ring-2 focus:ring-indigo-500 ring-offset-1 flex justify-center items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        {$btnText}
                                    </button>
                                </div>
                            </form>
                        </div>
HTML;
}

function processFile($filePath, $isEdit) {
    $content = file_get_contents($filePath);
    if ($isEdit) {
        $startPattern = '<div class="fns-card-body relative z-10 p-6 sm:p-8 bg-white/50 backdrop-blur-sm">';
    } else {
        $startPattern = '<div class="fns-card-body bg-white relative z-10 p-6 sm:p-8">';
    }
    $startPos = strpos($content, $startPattern);
    
    if ($startPos !== false) {
        $formEndPos = strpos($content, '</form>', $startPos);
        if ($formEndPos !== false) {
            $divEndPos = strpos($content, '</div>', $formEndPos);
            
            if ($divEndPos !== false) {
                $before = substr($content, 0, $startPos);
                $after = substr($content, $divEndPos + 6);
                
                $newForm = generateFormContent($isEdit);
                $newContent = $before . $newForm . $after;
                file_put_contents($filePath, $newContent);
                echo "Processed " . basename($filePath) . "\n";
            }
        }
    }
}

processFile($expenseFile, false);
processFile($editFile, true);
?>
