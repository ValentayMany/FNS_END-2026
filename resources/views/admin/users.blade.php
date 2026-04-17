<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">👥 ຈັດການຜູ້ໃຊ້</h2>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6">

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">✅ {{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto touch-pan-x -mx-px">
                <table class="w-full text-sm min-w-[44rem]">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">ຊື່</th>
                            <th class="px-4 py-3 text-left">USERNAME</th>
                            <th class="px-4 py-3 text-left">ROLE</th>
                            <th class="px-4 py-3 text-left">ພາກສ່ວນ</th>
                            <th class="px-4 py-3 text-left">ສະຖານະ</th>
                            <th class="px-4 py-3 text-left">ແກ້ໄຂ ROLE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">#{{ $user->id }}</td>
                            <td class="px-4 py-3 font-medium">{{ $user->full_name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                <span style="background:#e0e7ff;color:#4f46e5;padding:2px 8px;border-radius:999px;font-size:12px;">
                                    {{ $user->role?->role_name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->department?->displayName() ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($user->is_active)
                                    <span style="background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:999px;font-size:12px;">ໃຊ້ງານ</span>
                                @else
                                    <span style="background:#fee2e2;color:#dc2626;padding:2px 8px;border-radius:999px;font-size:12px;">ປິດ</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.users.role', $user->id) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role_id"
                                        class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->role_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        style="background:#4f46e5;color:white;padding:4px 12px;border-radius:6px;font-size:12px;border:none;cursor:pointer;">
                                        ✅ ຢືນຢັນ
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
