<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; justify-content:space-between; width:100%;">
            <div>
                <h2 style="font-size:24px; font-weight:800; color:#111827; margin:0; line-height:1.2;">ແຜງຄວບຄຸມລາຍຮັບ</h2>
                <p style="font-size:14px; color:#6b7280; margin-top:4px; font-weight:500;">{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('revenue.index') }}" style="display:flex; align-items:center; gap:8px; background:linear-gradient(135deg, #4f46e5, #6366f1); color:#fff; padding:12px 24px; border-radius:16px; font-weight:700; font-size:14px; text-decoration:none; box-shadow:0 4px 14px rgba(79,70,229,0.35); transition:all 0.2s;">
                <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                ບັນທຶກລາຍຮັບ
            </a>
        </div>
    </x-slot>

    <style>
        /* Base Reset for Custom Components */
        * { box-sizing: border-box; }
        .noscroll::-webkit-scrollbar { display: none; }
        .noscroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Bento Box Core Styles */
        .bento-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .bento-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.05);
        }

        /* Filter Bar */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 20px;
            padding: 16px 24px;
        }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .filter-input {
            background: #f8fafc;
            border: 2px solid transparent;
            border-radius: 14px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            outline: none;
            transition: 0.2s;
            height: 44px;
            font-family: inherit;
        }
        .filter-input:focus { border-color: #38bdf8; background: #fff; box-shadow: 0 0 0 4px rgba(14,165,233,0.1); }
        
        .filter-presets {
            display: flex;
            gap: 6px;
            background: #f8fafc;
            padding: 6px;
            border-radius: 16px;
            height: 44px;
            align-items: center;
        }
        .preset-btn {
            padding: 6px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: 0.2s;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: inherit;
        }
        .preset-btn:hover { background: #e2e8f0; color: #1e293b; }
        .preset-btn.active { background: #4f46e5; color: #fff; box-shadow: 0 4px 12px rgba(79,70,229,0.3); }

        .btn-search {
            height: 44px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 0 24px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(79,70,229,0.35);
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-search:hover { opacity: 0.9; transform: translateY(-1px); }

        /* KPI Grids */
        .kpi-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 24px;
        }
        @media(min-width: 1024px) { .kpi-grid { grid-template-columns: repeat(3, 1fr); } }

        /* KPI Card Internals */
        .kpi-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .kpi-header-left { display: flex; align-items: center; gap: 14px; }
        .kpi-icon {
            width: 52px; height: 52px; border-radius: 18px; 
            display: flex; align-items: center; justify-content: center; 
            color: #fff; box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .kpi-title { font-size: 20px; font-weight: 800; color: #1e293b; margin:0; line-height:1.2; }
        .kpi-subtitle { font-size: 13px; font-weight: 800; color: #64748b; text-transform: uppercase; margin:0 0 4px 0; }
        .kpi-tag { padding: 6px 14px; border-radius: 99px; font-size: 12px; font-weight: 700; }

        .kpi-amount-label { font-size: 14px; font-weight: 800; color: #64748b; margin-bottom: 8px; display: block; }
        .kpi-amount { font-size: 32px; font-weight: 900; color: #0f172a; line-height: 1; margin:0 0 24px 0; }
        .kpi-amount span { font-size: 16px; color: #64748b; font-weight: 800; margin-left: 4px; }

        .kpi-breakdown { background: #f8fafc; border-radius: 20px; padding: 16px; }
        .kpi-progress { height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden; display: flex; margin-bottom: 14px; }
        .kpi-progress-bar { height: 100%; transition: width 1s ease; }
        .kpi-split { display: flex; justify-content: space-between; font-size: 14px; font-weight: 800; color: #475569; }
        .kpi-split-item { display: flex; align-items: center; gap: 6px; }
        .kpi-split-item strong { color: #1e293b; font-weight: 800; }
        .dot { width: 10px; height: 10px; border-radius: 50%; }

        /* Gradients & Colors */
        .grad-indigo { background: linear-gradient(135deg, #4f46e5, #6366f1); }
        .grad-cyan { background: linear-gradient(135deg, #4338ca, #6366f1); }
        .grad-violet { background: linear-gradient(135deg, #6366f1, #818cf8); }
        .grad-amber { background: linear-gradient(135deg, #f59e0b, #f97316); }

        .tag-indigo { background: #e0e7ff; color: #4338ca; }
        .tag-cyan { background: #e0e7ff; color: #3730a3; }
        .tag-violet { background: #eef2ff; color: #4f46e5; }

        /* Tabs */
        .tabs-container { display: flex; justify-content: center; margin: 32px 0; }
        .tabs-wrap { display: inline-flex; background: #fff; padding: 8px; border-radius: 99px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f3f4f6; gap: 4px; }
        .tab-btn { padding: 12px 28px; border-radius: 99px; font-size: 14px; font-weight: 700; color: #64748b; background: transparent; border: none; cursor: pointer; transition: 0.2s; font-family: inherit; }
        .tab-btn:hover { color: #1e293b; background: #f8fafc; }
        .tab-btn.active { background: linear-gradient(135deg, #4f46e5, #6366f1); color: #fff; box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4); }

        /* Overview Layout */
        .overview-grid { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media(min-width: 1024px) {
            .overview-grid { grid-template-columns: repeat(3, 1fr); }
            .col-span-2 { grid-column: span 2; }
        }

        .chart-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .chart-title { font-size: 18px; font-weight: 800; color: #1e293b; margin:0 0 4px 0;}
        .chart-subtitle { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin:0;}

        .big-total-card { display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
        .big-total-card::before {
            content: ''; position: absolute; right: -50px; top: -50px; width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%; pointer-events: none;
        }
        .big-total-label { font-size: 15px; font-weight: 800; color: rgba(255,255,255,0.95); margin-bottom: 12px; }
        .big-total-amount { font-size: 40px; font-weight: 900; color: #fff; line-height: 1; margin:0; }
        .big-total-amount span { font-size: 18px; font-weight: 700; margin-left: 8px; opacity: 0.9; }
        .big-total-date { font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.9); margin-top: 24px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.3); }

        .stat-list { display: flex; flex-direction: column; gap: 16px; }
        .stat-item { display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
        .stat-item:last-child { border-bottom: none; padding-bottom: 0; }
        .stat-label { font-size: 14px; font-weight: 700; color: #64748b; }
        .stat-value { font-size: 16px; font-weight: 900; color: #1e293b; }
        .stat-value.amber { color: #d97706; }
        .stat-value.cyan { color: #0891b2; }

        table.bento-table { width: 100%; border-collapse: collapse; }
        table.bento-table th { padding: 16px 20px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #f1f5f9; }
        table.bento-table td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #f8fafc; color: #334155; font-weight: 600; }
        table.bento-table tr:hover td { background: #f8fafc; }
        table.bento-table td.money { font-weight: 900; color: #0f172a; text-align: right; }
    </style>

    <div style="max-width: 1400px; margin: 0 auto; padding-bottom: 60px;">

        {{-- ─── 1. Filter Row ─────────────────────────────── --}}
        <div class="bento-card filter-bar">
            <form id="ffrm" method="GET" action="{{ route('revenue.dashboard') }}" style="display:flex; flex-wrap:wrap; align-items:flex-end; gap:20px; width:100%;">
                
                <div class="filter-group">
                    <label>ວັນທີເລີ່ມຕົ້ນ</label>
                    <input type="date" name="start_date" id="sd" value="{{ $startDate }}" class="filter-input">
                </div>
                
                <div class="filter-group">
                    <label>ວັນທີສິ້ນສຸດ</label>
                    <input type="date" name="end_date" id="ed" value="{{ $endDate }}" class="filter-input">
                </div>

                <div class="filter-presets">
                    @foreach([['today','ມື້ນີ້'],['month','ເດືອນນີ້'],['year','ປີນີ້']] as [$k,$l])
                    <button type="button" id="pr-{{$k}}" onclick="doPreset('{{$k}}')" class="preset-btn">{{$l}}</button>
                    @endforeach
                </div>

                <button type="submit" class="btn-search" style="margin-left:auto;">
                    <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    ຄົ້ນຫາ
                </button>
            </form>
        </div>

        {{-- ─── 2. KPI Cards ───────────────────────────── --}}
        @php
            $cards = [
                ['ປຕ','ປະລິນຍາຕີ','tag-cyan','grad-cyan',
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                ['ປທ','ປະລິນຍາໂທ','tag-indigo','grad-indigo',
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                ['ປອ','ປະລິນຍາເອກ','tag-violet','grad-violet',
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
            ];
        @endphp

        <div class="kpi-grid">
            @foreach($cards as [$dept,$lbl,$tagClass,$gradClass,$icon])
            @php
                $tot  = $dailyStats[$dept]['total']    ?? 0;
                $cash = $dailyStats[$dept]['cash']     ?? 0;
                $txf  = $dailyStats[$dept]['transfer'] ?? 0;
                $all  = $overallStats[$dept]['total']  ?? 0;
                $cp   = $tot > 0 ? round($cash/$tot*100) : 0;
            @endphp
            <div class="bento-card">
                <div class="kpi-header">
                    <div class="kpi-header-left">
                        <div class="kpi-icon {{ $gradClass }}">
                            <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                        </div>
                        <div>
                            <p class="kpi-subtitle">ພາກສ່ວນ</p>
                            <p class="kpi-title">{{ $dept }}</p>
                        </div>
                    </div>
                    <span class="kpi-tag {{ $tagClass }}">{{ $lbl }}</span>
                </div>

                <span class="kpi-amount-label">ຍອດລວມຊ່ວງນີ້</span>
                <div class="kpi-amount">{{ number_format($tot, 0) }}<span>₭</span></div>

                @if($tot > 0)
                <div class="kpi-breakdown">
                    <div class="kpi-progress">
                        <div class="kpi-progress-bar grad-amber" style="width:{{$cp}}%"></div>
                        <div class="kpi-progress-bar {{ $gradClass }}" style="width:{{100-$cp}}%"></div>
                    </div>
                    <div class="kpi-split">
                        <div class="kpi-split-item">
                            <div class="dot grad-amber"></div>
                            ສົດ: <strong>{{ number_format($cash,0) }}</strong>
                        </div>
                        <div class="kpi-split-item">
                            <div class="dot {{ $gradClass }}"></div>
                            ໂອນ: <strong>{{ number_format($txf,0) }}</strong>
                        </div>
                    </div>
                </div>
                @else
                <div class="kpi-breakdown" style="display:flex; align-items:center; justify-content:center; height:80px; background:#f1f5f9;">
                    <span style="font-size:13px; font-weight:800; color:#94a3b8;">ຍັງບໍ່ມີຂໍ້ມູນການຮັບເງິນ</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- ─── 3. Tabs ───────────────────────── --}}
        <div class="tabs-container">
            <div class="tabs-wrap">
                <button class="tab-btn active" onclick="switchTab('overview', this)">ພາບລວມ (Overview)</button>
                <button class="tab-btn" onclick="switchTab('trend', this)">ແນວໂນ້ມ (Trend)</button>
                <button class="tab-btn" onclick="switchTab('compare', this)">ປຽບທຽບ (Compare)</button>
                <button class="tab-btn" onclick="switchTab('txns', this)">ທຸລະກຳ (Transactions)</button>
            </div>
        </div>

        {{-- ─── 4. Tab Contents ───────────────────────── --}}
        
        {{-- OVERVIEW TAB --}}
        <div id="tab-overview" class="overview-grid">
            {{-- Big Total Card --}}
            @php $sumTotal = array_sum(array_column($dailyStats, 'total')); @endphp
            <div class="bento-card grad-indigo big-total-card" style="border:none;">
                <div class="big-total-label">ລາຍຮັບທັງໝົດຊ່ວງນີ້</div>
                <div class="big-total-amount">{{ number_format($sumTotal,0) }}<span>₭</span></div>
                <div class="big-total-date">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
            </div>

            {{-- Main Line Chart --}}
            <div class="bento-card col-span-2" style="display:flex; flex-direction:column;">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ແນວໂນ້ມ</p>
                        <h3 class="chart-title">ຍອດລາຍຮັບລາຍວັນ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:280px; position:relative;"><canvas id="c1"></canvas></div>
            </div>

            {{-- Donut Chart --}}
            <div class="bento-card" style="display:flex; flex-direction:column;">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ສັດສ່ວນ</p>
                        <h3 class="chart-title">ຊ່ອງທາງຮັບເງິນ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:180px; position:relative; display:flex; align-items:center; justify-content:center;"><canvas id="c2"></canvas></div>
                <div style="display:flex; justify-content:center; gap:24px; margin-top:16px; padding-top:16px; border-top:1px solid #f1f5f9;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:#f59e0b;"></span>
                        <span style="font-size:12px; font-weight:700; color:#64748b;">ເງິນສົດ</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:#6366f1;"></span>
                        <span style="font-size:12px; font-weight:700; color:#64748b;">ໂອນເຂົ້າ</span>
                    </div>
                </div>
            </div>

            {{-- Bar Chart --}}
            <div class="bento-card col-span-2" style="display:flex; flex-direction:column;">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ປຽບທຽບ</p>
                        <h3 class="chart-title">ຍອດລາຍຮັບ ແຕ່ລະພາກສ່ວນ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:220px; position:relative;"><canvas id="c3"></canvas></div>
            </div>
        </div>

        {{-- TREND TAB --}}
        <div id="tab-trend" class="overview-grid" style="display:none;">
            <div class="bento-card col-span-2" style="display:flex; flex-direction:column;">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ແຍກປະເພດ</p>
                        <h3 class="chart-title">ເງິນສົດ vs ໂອນເຂົ້າ ລາຍວັນ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:320px; position:relative;"><canvas id="c4"></canvas></div>
            </div>
            
            <div style="display:flex; flex-direction:column; gap:24px;">
                <div class="bento-card" style="flex:1; display:flex; flex-direction:column;">
                    <div class="chart-header">
                        <h3 class="chart-title">ສັດສ່ວນ (ສົດ/ໂອນ)</h3>
                    </div>
                    <div style="flex:1; min-height:180px; position:relative; display:flex; align-items:center; justify-content:center;"><canvas id="c5"></canvas></div>
                </div>
                
                @php $cnt=$recentTransactions->count();$mx=$recentTransactions->max('amount')??0;$av=$recentTransactions->avg('amount')??0; @endphp
                <div class="bento-card">
                    <p class="chart-subtitle" style="margin-bottom:16px;">ສະຖິຕິການຮັບເງິນ</p>
                    <div class="stat-list">
                        <div class="stat-item">
                            <span class="stat-label">ຈຳນວນທຸລະກຳ</span>
                            <span class="stat-value">{{ $cnt }} ລາຍການ</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">ຍອດສູງສຸດ / ບິນ</span>
                            <span class="stat-value amber">{{ number_format($mx,0) }} ₭</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">ຍອດສະເລ່ຍ / ບິນ</span>
                            <span class="stat-value cyan">{{ number_format($av,0) }} ₭</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COMPARE TAB --}}
        <div id="tab-compare" class="overview-grid" style="display:none;">
            <div class="bento-card col-span-2" style="display:flex; flex-direction:column;">
                <div class="chart-header">
                    <div>
                        <p class="chart-subtitle">ລາຍລະອຽດ</p>
                        <h3 class="chart-title">ຍອດລວມແຕ່ລະພາກສ່ວນ</h3>
                    </div>
                </div>
                <div style="flex:1; min-height:320px; position:relative;"><canvas id="c6"></canvas></div>
            </div>
            <div class="bento-card">
                <div class="chart-header"><h3 class="chart-title">ສັດສ່ວນ (%)</h3></div>
                @php
                    $sa = array_sum(array_column($dailyStats,'total'));
                    $dc = ['ປທ'=>['grad-indigo','#4f46e5'],'ປຕ'=>['grad-cyan','#0891b2'],'ປອ'=>['grad-violet','#7c3aed']];
                @endphp
                <div style="display:flex; flex-direction:column; gap:24px; margin-top:24px;">
                    @foreach($dc as $dn=>[$bg,$tc])
                    @php $dv=$dailyStats[$dn]['total']??0;$p=$sa>0?round($dv/$sa*100,1):0; @endphp
                    <div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px; font-weight:800;">
                            <span style="color:#334155;">{{ $dn }}</span>
                            <span style="color:{{$tc}};">{{ $p }}%</span>
                        </div>
                        <div style="height:10px; background:#f1f5f9; border-radius:99px; overflow:hidden;">
                            <div class="{{ $bg }}" style="height:100%; width:{{ $p }}%; border-radius:99px;"></div>
                        </div>
                        <div style="font-size:12px; font-weight:700; color:#94a3b8; margin-top:8px;">{{ number_format($dv,0) }} ₭</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TRANSACTIONS TAB --}}
        <div id="tab-txns" style="display:none;">
            <div class="bento-card" style="padding:0; overflow:hidden;">
                <div style="padding:24px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:16px;">
                    <div class="grad-indigo" style="width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff;">
                        <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </div>
                    <div>
                        <h3 class="chart-title">ທຸລະກຳຫຼ້າສຸດ</h3>
                        <p class="chart-subtitle">10 ລາຍການລ່າສຸດໃນລະບົບ</p>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table class="bento-table">
                        <thead>
                            <tr>
                                <th>ວັນທີ</th>
                                <th>ພາກສ່ວນ</th>
                                <th>ປະເພດ</th>
                                <th style="text-align:center;">ຊ່ອງທາງ</th>
                                <th style="text-align:right;">ຍອດ (₭)</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentTransactions as $tx)
                            <tr>
                                <td style="font-family:monospace; color:#64748b;">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="tag-indigo" style="padding:6px 12px; border-radius:8px; font-size:11px; font-weight:800;">{{ $tx->department?->department_name }}</span>
                                </td>
                                <td>
                                    <div style="font-weight:800; color:#1e293b;">{{ $tx->category }}</div>
                                    @if($tx->description)<div style="font-size:11px; color:#94a3b8; margin-top:4px;">{{ $tx->description }}</div>@endif
                                </td>
                                <td style="text-align:center;">
                                    @if($tx->payment_method==='cash')
                                        <span class="tag-cyan" style="background:#fffbeb; color:#d97706; padding:6px 12px; border-radius:8px; font-size:11px; font-weight:800;">ເງິນສົດ</span>
                                    @else
                                        <span class="tag-cyan" style="background:#ecfeff; color:#0891b2; padding:6px 12px; border-radius:8px; font-size:11px; font-weight:800;">ໂອນເຂົ້າ</span>
                                    @endif
                                </td>
                                <td class="money">{{ number_format($tx->amount,0) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding:48px; color:#94a3b8;">ບໍ່ພົບລາຍການ</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    /* Presets */
    function doPreset(p){
        const t=new Date(), f=d=>d.toISOString().split('T')[0], td=f(t);
        const map = {today:td, month:f(new Date(t.getFullYear(),t.getMonth(),1)), year:f(new Date(t.getFullYear(),0,1))};
        document.getElementById('sd').value = map[p];
        document.getElementById('ed').value = td;
        document.getElementById('ffrm').submit();
    }

    /* Highlight active preset */
    document.addEventListener('DOMContentLoaded', () => {
        const s=document.getElementById('sd').value, e=document.getElementById('ed').value;
        const t=new Date(), f=d=>d.toISOString().split('T')[0];
        const td=f(t), mo=f(new Date(t.getFullYear(),t.getMonth(),1)), yr=f(new Date(t.getFullYear(),0,1));
        const hi=id=>{const el=document.getElementById(id);if(el)el.classList.add('active');};
        if(s===td&&e===td) hi('pr-today');
        else if(s===mo&&e===td) hi('pr-month');
        else if(s===yr&&e===td) hi('pr-year');
    });

    /* Tab Switcher */
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('[id^="tab-"]').forEach(t => t.style.display = 'none');
        document.getElementById('tab-' + tabId).style.display = 'grid';
        if(tabId === 'txns') document.getElementById('tab-' + tabId).style.display = 'block';
    }

    /* Chart Data */
    const DT=@json($dailyTrends), DS=@json($dailyStats), PB=@json($paymentBreakdown);
    const LBL=DT.map(i=>{const p=(i.transaction_date||'').split('T')[0].split('-');return p.length===3?`${p[2]}/${p[1]}`:i.transaction_date;});
    const TOT=DT.map(i=>+i.total), CSH=DT.map(i=>+i.cash), TXF=DT.map(i=>+i.transfer);
    const hasPay=+PB.cash>0||+PB.transfer>0;
    const DVALS=['ປທ','ປຕ','ປອ'].map(d=>+(DS[d]?.total||0));

    Chart.defaults.font.family = "inherit";
    Chart.defaults.color = '#64748b';

    const TIP = {
        backgroundColor:'#1e293b', padding:16, cornerRadius:16, usePointStyle:true,
        titleFont:{size:14,weight:'800'}, bodyFont:{size:14,weight:'700'}, boxWidth:8, boxHeight:8,
        callbacks:{label:c=>` ${c.dataset.label||c.label}: ${(+c.raw).toLocaleString()} ₭`}
    };
    const XAX = {grid:{display:false}, ticks:{font:{size:12,weight:'700'}, color:'#475569'}};
    const YAX = {grid:{color:'#f1f5f9', drawBorder:false}, ticks:{font:{size:12,weight:'700'}, callback:v=>v>=1000?(v/1000).toFixed(v%1000===0?0:1)+'K':v}};

    function mkGrad(ctx,c1,c2){const g=ctx.createLinearGradient(0,0,0,300);g.addColorStop(0,c1);g.addColorStop(1,c2);return g;}

    window.addEventListener('load',()=>{
        /* c1 */
        (()=>{const el=document.getElementById('c1');if(!el)return;const ctx=el.getContext('2d');
            new Chart(ctx,{type:'line',data:{labels:LBL,datasets:[{label:'ລາຍຮັບ',data:TOT,backgroundColor:mkGrad(ctx,'rgba(2,132,199,0.8)','rgba(2,132,199,0.1)'),fill:true,borderWidth:0,tension:.4,pointRadius:0,pointHoverRadius:0}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:TIP},scales:{x:XAX,y:YAX},interaction:{mode:'index',intersect:false}}});
        })();
        /* c2 */
        (()=>{const el=document.getElementById('c2');if(!el)return;
            new Chart(el.getContext('2d'),{type:'doughnut',data:{labels:['ເງິນສົດ','ໂອນເຂົ້າ'],datasets:[{data:hasPay?[+PB.cash,+PB.transfer]:[1,1],backgroundColor:hasPay?['#f59e0b','#0284c7']:['#f1f5f9','#f8fafc'],borderWidth:0,hoverOffset:6}]},options:{responsive:true,maintainAspectRatio:false,cutout:'75%',plugins:{legend:{display:false},tooltip:{enabled:hasPay,...TIP}}}});
        })();
        /* c3 */
        (()=>{const el=document.getElementById('c3');if(!el)return;
            new Chart(el.getContext('2d'),{type:'bar',data:{labels:['ປທ','ປຕ','ປອ'],datasets:[{data:DVALS,backgroundColor:['#0284c7','#06b6d4','#6366f1'],borderRadius:8,barThickness:40}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:TIP},scales:{x:XAX,y:YAX}}});
        })();
        /* c4 */
        (()=>{const el=document.getElementById('c4');if(!el)return;const ctx=el.getContext('2d');
            new Chart(ctx,{type:'line',data:{labels:LBL,datasets:[{label:'ເງິນສົດ',data:CSH,backgroundColor:mkGrad(ctx,'rgba(245,158,11,0.7)','rgba(245,158,11,0.1)'),fill:true,borderWidth:0,tension:.4,pointRadius:0,pointHoverRadius:0},{label:'ໂອນເຂົ້າ',data:TXF,backgroundColor:mkGrad(ctx,'rgba(2,132,199,0.7)','rgba(2,132,199,0.1)'),fill:true,borderWidth:0,tension:.4,pointRadius:0,pointHoverRadius:0}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'top',labels:{font:{weight:'bold'},usePointStyle:true,color:'#475569'}},tooltip:TIP},scales:{x:XAX,y:{...YAX,stacked:true}},interaction:{mode:'index',intersect:false}}});
        })();
        /* c5 */
        (()=>{const el=document.getElementById('c5');if(!el)return;
            new Chart(el.getContext('2d'),{type:'doughnut',data:{labels:['ເງິນສົດ','ໂອນເຂົ້າ'],datasets:[{data:hasPay?[+PB.cash,+PB.transfer]:[1,1],backgroundColor:hasPay?['#f59e0b','#0284c7']:['#f1f5f9','#f8fafc'],borderWidth:0,hoverOffset:6}]},options:{responsive:true,maintainAspectRatio:false,cutout:'75%',plugins:{legend:{position:'bottom',labels:{font:{weight:'bold'},usePointStyle:true,color:'#475569'}},tooltip:{enabled:hasPay,...TIP}}}});
        })();
        /* c6 */
        (()=>{const el=document.getElementById('c6');if(!el)return;
            new Chart(el.getContext('2d'),{type:'bar',data:{labels:['ປທ','ປຕ','ປອ'],datasets:[{data:DVALS,backgroundColor:['#0284c7','#06b6d4','#6366f1'],borderRadius:12,barThickness:50}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:TIP},scales:{x:XAX,y:YAX}}});
        })();
    });
    </script>
</x-app-layout>
