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

            @if(session('error'))
                <div class="fns-alert fns-alert-error fns-animate mb-5">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="fns-card fns-animate">
                <div class="fns-card-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#f5f3ff; color:#7c3aed;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 002.625.372" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.875 6.75a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19.5a6 6 0 0112 0v.75H3v-.75z" /></svg>
                        </div>
                        <div>
                            <h3 class="fns-card-title">ລາຍຊື່ຜູ້ໃຊ້ທັງໝົດ</h3>
                        </div>
                    </div>
                    <div>
                        <button onclick="openCreateModal()" class="fns-btn fns-btn-primary flex items-center gap-1.5" style="padding: 8px 16px; font-size: 0.8rem; background: #4f46e5; border-color:#4f46e5; color:#fff; cursor:pointer;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            ເພີ່ມຜູ້ໃຊ້ໃໝ່
                        </button>
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
                                <th style="width:120px; text-align:center;">ຈັດການ</th>
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
                                    <form method="POST" action="{{ route('admin.toggleActive', $user->id) }}" style="display:inline;">
                                        @csrf
                                        @if($user->is_active)
                                            <button type="submit" class="fns-badge fns-badge-approved" style="cursor:pointer; border:none; background:none; padding:0;"
                                                onclick="return confirm('ต้องการปิดใช้งานผู้ใช้นี้ບໍ?')">
                                                ✅ ໃຊ້ງານ
                                            </button>
                                        @else
                                            <button type="submit" class="fns-badge fns-badge-rejected" style="cursor:pointer; border:none; background:none; padding:0;">
                                                ❌ ປິດ
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td style="text-align:center;">
                                    <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->full_name) }}', '{{ addslashes($user->username) }}', {{ $user->role_id }}, {{ $user->department_id ?? 'null' }})" 
                                            class="fns-btn" 
                                            style="padding: 6px 12px; font-size: 0.75rem; color: #4f46e5; border-color: #e0e7ff; background: #f5f7ff; cursor: pointer; border-radius: 8px;">
                                        ແກ້ໄຂ
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100">{{ $users->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);" onclick="closeCreateModal()"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
            <div class="bg-white rounded-2xl shadow-2xl w-full" style="max-width:28rem; padding:1.5rem; position:relative; z-index:1;">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="text-base font-extrabold text-gray-800">ເພີ່ມຜູ້ໃຊ້ໃໝ່</h3>
                    <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.storeUser') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ຊື່ເຕັມ (Full Name)</label>
                        <input type="text" name="full_name" required class="ui-input w-full bg-white text-sm" placeholder="ປ້ອນຊື່ ແລະ ນາມສະກຸນ">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ຊື່ອີເມລ/ເຂົ້າລະບົບ (Username)</label>
                        <input type="text" name="username" required class="ui-input w-full bg-white text-sm" placeholder="ຕົວຢ່າງ: user01 ຫຼື email@example.com">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ລະຫັດຜ່ານ (Password)</label>
                        <input type="password" name="password" required minlength="6" class="ui-input w-full bg-white text-sm" placeholder="ລະຫັດຜ່ານຢ່າງໜ້ອຍ 6 ຕົວອັກສອນ">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ບົດບາດ (Role)</label>
                        <select name="role_id" required class="fns-select w-full bg-white text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ພាកສ່ວນ (Department)</label>
                        <select name="department_id" class="fns-select w-full bg-white text-sm">
                            <option value="">-- ບໍ່ມີພາກສ່ວນ (None) --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->displayName() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-50">
                        <button type="button" onclick="closeCreateModal()" class="fns-btn" style="border-color:#e5e7eb; background:#f9fafb; color:#374151; cursor:pointer;">ຍົກເລີກ</button>
                        <button type="submit" class="fns-btn fns-btn-primary" style="background:#4f46e5; border-color:#4f46e5; color:#fff; cursor:pointer;">ບັນທຶກ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:99999;" aria-modal="true" role="dialog">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);" onclick="closeEditModal()"></div>
        <div style="position:relative; display:flex; align-items:center; justify-content:center; width:100%; height:100%; padding:1rem;">
            <div class="bg-white rounded-2xl shadow-2xl w-full" style="max-width:28rem; padding:1.5rem; position:relative; z-index:1;">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="text-base font-extrabold text-gray-800">ແກ້ໄຂຂໍ້ມູນຜູ້ໃຊ້</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <form id="editForm" method="POST" action="" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ຊື່ເຕັມ (Full Name)</label>
                        <input type="text" id="edit_full_name" name="full_name" required class="ui-input w-full bg-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ຊື່ອີເມລ/ເຂົ້າລະບົບ (Username)</label>
                        <input type="text" id="edit_username" name="username" required class="ui-input w-full bg-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ປ່ຽນລະຫັດຜ່ານ (ປ້ອນເມື່ອຕ້ອງການປ່ຽນເທົ່ານັ້ນ)</label>
                        <input type="password" name="password" minlength="6" class="ui-input w-full bg-white text-sm" placeholder="ລະຫັດຜ່ານໃໝ່ຢ່າງໜ້ອຍ 6 ຕົວອັກສອນ (ຫວ່າງໄວ້ຫາກບໍ່ປ່ຽນ)">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ບົດບາດ (Role)</label>
                        <select id="edit_role_id" name="role_id" required class="fns-select w-full bg-white text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">ພາກສ່ວນ (Department)</label>
                        <select id="edit_department_id" name="department_id" class="fns-select w-full bg-white text-sm">
                            <option value="">-- ບໍ່ມີພາກສ່ວນ (None) --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->displayName() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-50">
                        <button type="button" onclick="closeEditModal()" class="fns-btn" style="border-color:#e5e7eb; background:#f9fafb; color:#374151; cursor:pointer;">ຍົກເລີກ</button>
                        <button type="submit" class="fns-btn fns-btn-primary" style="background:#4f46e5; border-color:#4f46e5; color:#fff; cursor:pointer;">ອັບເດດ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal JavaScript -->
    <script>
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        function openEditModal(id, fullName, username, roleId, departmentId) {
            const form = document.getElementById('editForm');
            form.action = '/admin/users/' + id;
            
            document.getElementById('edit_full_name').value = fullName;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_role_id').value = roleId;
            document.getElementById('edit_department_id').value = departmentId !== null ? departmentId : '';
            
            document.getElementById('editModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
            }
        });
    </script>
</x-app-layout>
