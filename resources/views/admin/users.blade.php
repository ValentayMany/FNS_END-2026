<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-medium text-indigo-400 uppercase tracking-widest">ແອດມິນ</p>
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">ຈັດການຜູ້ໃຊ້</h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 w-full min-w-0">
        <div class="max-w-6xl mx-auto w-full min-w-0 px-3 sm:px-4 lg:px-6">

            @if(session('success'))
                <div class="fns-alert fns-alert-success fns-animate mb-5">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="fns-card fns-animate">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#f5f3ff; color:#7c3aed;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.956" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.875 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19.5a6 6 0 0112 0v.75H3v-.75z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ລາຍຊື່ຜູ້ໃຊ້ທັງໝົດ</h3>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto touch-pan-x">
                    <table class="fns-table" style="min-width:44rem;">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>ຊື່</th>
                                <th>USERNAME</th>
                                <th>ROLE</th>
                                <th>ພາກສ່ວນ</th>
                                <th>ສະຖານະ</th>
                                <th>ແກ້ໄຂ ROLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><span class="fns-cell-id">#{{ $user->id }}</span></td>
                                <td><span class="fns-cell-name">{{ $user->full_name }}</span></td>
                                <td class="text-gray-500 text-sm">{{ $user->username }}</td>
                                <td>
                                    <span class="fns-badge fns-badge-deputy">{{ $user->role?->role_name ?? '-' }}</span>
                                </td>
                                <td class="text-gray-500 text-sm">{{ $user->department?->displayName() ?? '-' }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="fns-badge fns-badge-approved">ໃຊ້ງານ</span>
                                    @else
                                        <span class="fns-badge fns-badge-rejected">ປິດ</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.updateRole', $user->id) }}" class="flex items-center gap-2">
                                        @csrf
                                        <select name="role_id" class="fns-select" style="width: auto; min-width: 140px; padding: 6px 10px; font-size: 0.75rem;">
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->role_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="fns-btn fns-btn-primary" style="padding:6px 12px; font-size:0.7rem;">
                                            ຢືນຢັນ
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
