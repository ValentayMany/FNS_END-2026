<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">➕ ສ້າງຄຳຂໍເບີກເງິນ</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4">
            <form method="POST" action="{{ route('requests.store') }}"
                  class="bg-white rounded-xl shadow p-6 space-y-5">
                @csrf

                <div>
                    <x-input-label for="department_id" value="ພາກສ່ວນ *" />
                    <select name="department_id" id="department_id" required
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- ເລືອກພາກສ່ວນ --</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->department_name }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="requested_amount" value="ຈຳນວນເງິນ (ກີບ) *" />
                    <x-text-input id="requested_amount" name="requested_amount" type="number"
                        class="block mt-1 w-full" min="1" step="0.01"
                        :value="old('requested_amount')" required />
                    <x-input-error :messages="$errors->get('requested_amount')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="ລາຍລະອຽດ / ວັດຖຸປະສົງ *" />
                    <textarea id="description" name="description" rows="3" required
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="request_date" value="ວັນທີຄຳຂໍ *" />
                    <x-text-input id="request_date" name="request_date" type="date"
                        class="block mt-1 w-full"
                        :value="old('request_date', today()->toDateString())" required />
                    <x-input-error :messages="$errors->get('request_date')" class="mt-2" />
                </div>

                <div class="flex gap-3 pt-2">
                    <x-primary-button>ບັນທຶກ (ຮ່າງ)</x-primary-button>
                    <a href="{{ route('requests.index') }}"
                       class="inline-flex items-center px-4 py-2 border rounded-md text-sm text-gray-600 hover:bg-gray-50">
                        ຍົກເລີກ
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
