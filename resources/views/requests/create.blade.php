<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">➕ ສ້າງຄຳຂໍໃໝ່</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4">

            @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">
                <form method="POST" action="{{ route('requests.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="department_id" value="ພາກສ່ວນ *" />
                        <select id="department_id" name="department_id" required
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">-- ເລືອກພາກສ່ວນ --</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ old('department_id', Auth::user()->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->department_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="request_date" value="ວັນທີ *" />
                        <x-text-input id="request_date" name="request_date" type="date"
                            class="block mt-1 w-full"
                            :value="old('request_date', today()->toDateString())" required />
                    </div>

                    <div>
                        <x-input-label for="description" value="ລາຍລະອຽດ *" />
                        <textarea id="description" name="description" rows="3" required
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm text-sm">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <x-input-label for="requested_amount" value="ຈຳນວນເງິນທີ່ຂໍ (ກີບ) *" />
                        <x-text-input id="requested_amount" name="requested_amount" type="number"
                            class="block mt-1 w-full" min="1" step="0.01"
                            :value="old('requested_amount')" required />
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>💾 ບັນທຶກ</x-primary-button>
                        <a href="{{ route('requests.index') }}"
                            style="background:#6b7280;color:white;padding:8px 16px;border-radius:6px;font-size:14px;text-decoration:none;">
                            ← ກັບຄືນ
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
