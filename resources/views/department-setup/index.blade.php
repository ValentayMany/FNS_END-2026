<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5">
            <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest">ການຈັດການ</p>
            <h2 class="text-xl font-bold text-slate-800">ຈັດການຂໍ້ມູນພາກ/ສ່ວນ ແລະ ງົບປະມານ</h2>
        </div>
    </x-slot>

    <div class="fns-animate space-y-5">

        {{-- ── Two-column layout ── --}}
        <div style="display:grid; grid-template-columns:1fr; gap:1.25rem;">
            @media-placeholder

            {{-- ──────────────────────────────────────────────
                 LEFT — Add Form
            ────────────────────────────────────────────────── --}}
            <div style="display:contents" id="col-left">
            </div>

        </div>

        {{-- Real layout via inline grid (Blade doesn't support responsive CSS in markup) --}}
    </div>

    <style>
        .ds-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            align-items: start;
        }
        @media (min-width: 900px) {
            .ds-grid { grid-template-columns: 380px 1fr; }
        }

        /* inline-edit row styling */
        .edit-row-form { background: #fafbff !important; }
        .edit-row-form input {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 7px;
            padding: 5px 9px;
            font-size: 0.8rem;
            font-family: inherit;
            outline: none;
            background: #fff;
            transition: border-color 0.15s;
        }
        .edit-row-form input:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.12); }

        /* code badge — indigo style matching theme */
        .dept-code-badge {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            letter-spacing: 0.04em;
            border: 1px solid #c7d2fe;
        }
        /* budget badge */
        .budget-badge {
            display: inline-block;
            background: #ecfdf5;
            color: #047857;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 8px;
            border: 1px solid #a7f3d0;
            white-space: nowrap;
        }
        /* type pill */
        .type-pill {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 9px;
            border-radius: 20px;
        }
    </style>

    <div class="ds-grid fns-animate">

        {{-- ── LEFT: Add Form ── --}}
        <div>
            <div class="fns-card">
                {{-- Card Header --}}
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fns-card-title">ເພີ່ມພາກ/ສ່ວນໃໝ່</div>
                            <div class="fns-card-subtitle">ສ້າງລາຍການ ພາກວິຊາ ຫຼື ສ່ວນ/ອົງການ</div>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="fns-card-body">

                    @if(session('success'))
                        <div class="fns-alert fns-alert-success mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="fns-alert fns-alert-error mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="fns-alert fns-alert-error mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('department-setup.store') }}" class="space-y-4">
                        @csrf

                        {{-- Code + Name --}}
                        <div style="display:grid; grid-template-columns:90px 1fr; gap:12px;">
                            <div>
                                <label class="fns-label" for="dept_code">ລະຫັດ</label>
                                <input id="dept_code" name="dept_code" type="text" class="fns-input"
                                    maxlength="20" placeholder="01" value="{{ old('dept_code') }}">
                            </div>
                            <div>
                                <label class="fns-label" for="department_name">ຊື່ *</label>
                                <input id="department_name" name="department_name" type="text" required
                                    class="fns-input" placeholder="ພາກເຄມີ, ແມ່ຍິງ…"
                                    value="{{ old('department_name') }}">
                            </div>
                        </div>

                        <div>
                            <label class="fns-label" for="department_type">
                                ປະເພດ <span style="color:#94a3b8;font-weight:400;text-transform:none">(ທາງເລືອກ)</span>
                            </label>
                            <input id="department_type" name="department_type" type="text" class="fns-input"
                                placeholder="Faculty, Organization, Section…"
                                value="{{ old('department_type') }}">
                        </div>

                        <div>
                            <label class="fns-label" for="budget_amount">ງົບປະມານ (ກີບ)</label>
                            <input id="budget_amount" name="budget_amount" type="number" class="fns-input"
                                min="0" step="0.01" placeholder="0.00"
                                value="{{ old('budget_amount') }}">
                        </div>

                        <div style="border-top:1px solid #f1f5f9; padding-top:16px; margin-top:4px;">
                            <button type="submit" class="fns-btn fns-btn-primary w-full" style="min-height:42px;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                ເພີ່ມພາກ/ສ່ວນ
                            </button>
                        </div>
                    </form>

                    {{-- Info tip --}}
                    <div style="margin-top:16px; background:#eef2ff; border:1px solid #c7d2fe; border-radius:10px;
                                padding:12px 14px; font-size:0.78rem; color:#4f46e5;
                                display:flex; gap:9px; align-items:flex-start;">
                        <svg style="width:16px;height:16px;flex-shrink:0;margin-top:1px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>ລະຫັດ ແລະ ງົບ ຂອງພາກ/ສ່ວນ ຈະຖືກດຶງໄປ <strong>ສະແດງໃນລາຍງານ</strong> ເວລາ print</span>
                    </div>
                </div>
            </div>

            {{-- Example card --}}
            <div class="fns-card fns-animate-delay-1" style="margin-top:1.1rem;">
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon" style="background:#ecfdf5;color:#059669;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fns-card-title">ຕົວຢ່າງໂຄງສ້າງ</div>
                            <div class="fns-card-subtitle">ວິທີໃສ່ຂໍ້ມູນ</div>
                        </div>
                    </div>
                </div>
                <div class="fns-card-body" style="padding:16px 20px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;font-size:0.8rem;color:#334155;">
                        <div>
                            <div style="font-weight:700;color:#1e293b;margin-bottom:8px;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">ພາກວິຊາ</div>
                            <div style="display:flex;flex-direction:column;gap:6px;">
                                <div><span class="dept-code-badge">01</span> <span style="margin-left:6px;">ພາກເຄມີ</span></div>
                                <div><span class="dept-code-badge">02</span> <span style="margin-left:6px;">ພາກຄອມ</span></div>
                                <div><span class="dept-code-badge">03</span> <span style="margin-left:6px;">ພາກຟີສິກ</span></div>
                            </div>
                        </div>
                        <div>
                            <div style="font-weight:700;color:#1e293b;margin-bottom:8px;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;">ພາກ/ສ່ວນ</div>
                            <div style="display:flex;flex-direction:column;gap:6px;">
                                <div><span class="type-pill">ອົງການ</span> <span style="margin-left:6px;">ສ່ວນແມ່ຍິງ</span></div>
                                <div><span class="type-pill">ອົງການ</span> <span style="margin-left:6px;">ສ່ວນຊາວໜຸ່ມ</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Departments Table ── --}}
        <div>
            <div class="fns-card fns-animate-delay-1">
                {{-- Card Header --}}
                <div class="fns-card-header">
                    <div class="flex items-center gap-3">
                        <div class="fns-card-header-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="fns-card-title">ລາຍຊື່ພາກ/ສ່ວນທັງໝົດ</div>
                            <div class="fns-card-subtitle">{{ $departments->count() }} ລາຍການ</div>
                        </div>
                    </div>
                    <span class="fns-badge-count">{{ $departments->count() }}</span>
                </div>

                {{-- Table --}}
                <div style="overflow-x:auto;">
                    <table class="fns-table">
                        <thead>
                            <tr>
                                <th style="width:70px;">ລະຫັດ</th>
                                <th>ຊື່ພາກ/ສ່ວນ</th>
                                <th>ປະເພດ</th>
                                <th class="text-right">ງົບ (ກີບ)</th>
                                <th class="th-center" style="width:140px;">ຈັດການ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $dept)
                                {{-- View Row --}}
                                <tr id="row-view-{{ $dept->id }}">
                                    <td>
                                        @if($dept->dept_code)
                                            <span class="dept-code-badge">{{ $dept->dept_code }}</span>
                                        @else
                                            <span style="color:#cbd5e0;">—</span>
                                        @endif
                                    </td>
                                    <td class="fns-cell-name">{{ $dept->displayName() }}</td>
                                    <td>
                                        @if($dept->department_type)
                                            <span class="type-pill">{{ $dept->department_type }}</span>
                                        @else
                                            <span style="color:#cbd5e0;">—</span>
                                        @endif
                                    </td>
                                    <td style="text-align:right;">
                                        <span class="budget-badge">{{ number_format($dept->budget_amount ?? 0, 2) }}</span>
                                    </td>
                                    <td style="text-align:center;white-space:nowrap;">
                                        <button type="button" onclick="showEditRow({{ $dept->id }})"
                                            class="fns-btn fns-btn-secondary" style="padding:5px 12px;font-size:0.72rem;gap:4px;">
                                            <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            ແກ້ໄຂ
                                        </button>
                                        <form method="POST"
                                            action="{{ route('department-setup.destroy', $dept) }}"
                                            style="display:inline-block;margin-left:4px;"
                                            onsubmit="return confirm('ລຶບ {{ addslashes($dept->displayName()) }} ອອກ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="fns-btn fns-btn-danger" style="padding:5px 12px;font-size:0.72rem;gap:4px;">
                                                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                ລຶບ
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Inline Edit Row --}}
                                <tr id="row-edit-{{ $dept->id }}" class="edit-row-form" style="display:none;">
                                    <form method="POST" action="{{ route('department-setup.update', $dept) }}">
                                        @csrf @method('PUT')
                                        <td><input name="dept_code" type="text" maxlength="20" value="{{ $dept->dept_code }}" placeholder="01"></td>
                                        <td><input name="department_name" type="text" required value="{{ $dept->department_name }}"></td>
                                        <td><input name="department_type" type="text" value="{{ $dept->department_type }}"></td>
                                        <td><input name="budget_amount" type="number" min="0" step="0.01" value="{{ $dept->budget_amount }}" style="text-align:right;"></td>
                                        <td style="text-align:center;white-space:nowrap;">
                                            <button type="submit" class="fns-btn fns-btn-success" style="padding:5px 12px;font-size:0.72rem;gap:4px;">
                                                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                ບັນທຶກ
                                            </button>
                                            <button type="button" onclick="hideEditRow({{ $dept->id }})"
                                                class="fns-btn fns-btn-ghost" style="padding:5px 12px;font-size:0.72rem;margin-left:4px;">
                                                ຍົກເລີກ
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="fns-empty">
                                            <div class="fns-empty-icon">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                                                </svg>
                                            </div>
                                            <p class="fns-empty-text">ຍັງບໍ່ມີຂໍ້ມູນ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if($departments->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="3" style="font-size:0.75rem;color:#64748b;font-weight:600;">ງົບລວມທັງໝົດ</td>
                                <td style="text-align:right;">
                                    <span style="font-size:0.9rem;font-weight:800;color:#4f46e5;">
                                        {{ number_format($departments->sum('budget_amount'), 2) }}
                                    </span>
                                    <span style="font-size:0.72rem;color:#94a3b8;margin-left:4px;">ກີບ</span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        function showEditRow(id) {
            document.getElementById('row-view-' + id).style.display = 'none';
            document.getElementById('row-edit-' + id).style.display = '';
        }
        function hideEditRow(id) {
            document.getElementById('row-edit-' + id).style.display = 'none';
            document.getElementById('row-view-' + id).style.display = '';
        }
    </script>
</x-app-layout>
