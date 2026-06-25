<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Ports · Port Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root[data-theme="light"] {
            --bg:             #f0f4f8;
            --surface:        #ffffff;
            --surface2:       #f8fafc;
            --border:         #e2e8f0;
            --text:           #0f172a;
            --text-muted:     #64748b;
            --accent:         #10b981;
            --badge-dist-bg:  #ecfdf5;
            --badge-dist-txt: #065f46;
            --badge-ctry-bg:  #eff6ff;
            --badge-ctry-txt: #1d4ed8;
            --shadow:         0 4px 24px rgba(0,0,0,0.07);
            --thead:          #1e293b;
            --thead-txt:      #f8fafc;
            --row-hover:      #f0fdf4;
            --toggle-bg:      #cbd5e1;
            --page-btn:       #ffffff;
            --page-txt:       #64748b;
        }
        :root[data-theme="dark"] {
            --bg:             #0b1120;
            --surface:        #131c2e;
            --surface2:       #1a2540;
            --border:         #1e2d45;
            --text:           #e2e8f0;
            --text-muted:     #64748b;
            --accent:         #34d399;
            --badge-dist-bg:  #064e3b;
            --badge-dist-txt: #6ee7b7;
            --badge-ctry-bg:  #1e3a5f;
            --badge-ctry-txt: #93c5fd;
            --shadow:         0 4px 24px rgba(0,0,0,0.4);
            --thead:          #0d1526;
            --thead-txt:      #94a3b8;
            --row-hover:      #1a2e1f;
            --toggle-bg:      #34d399;
            --page-btn:       #1a2540;
            --page-txt:       #94a3b8;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--text);
            min-height: 100vh;
            transition: background 0.3s, color 0.3s;
        }

        .wrapper { max-width: 900px; margin: 0 auto; padding: 36px 20px; }

        .top-bar {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 28px;
            flex-wrap: wrap; gap: 14px;
        }

        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--accent), #06b6d4);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .brand-text h1 { font-size: 20px; font-weight: 700; line-height: 1.2; }
        .brand-text p  { font-size: 12px; color: var(--text-muted); margin-top: 1px; }

        .top-actions { display: flex; gap: 10px; align-items: center; }

        .toggle-theme {
            width: 48px; height: 26px;
            background: var(--toggle-bg);
            border-radius: 999px; border: none; cursor: pointer;
            position: relative; transition: background 0.3s;
            flex-shrink: 0;
        }
        .toggle-theme::after {
            content: ''; position: absolute;
            top: 3px; left: 3px;
            width: 20px; height: 20px;
            background: white; border-radius: 50%;
            transition: transform 0.3s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.25);
        }
        [data-theme="dark"] .toggle-theme { background: var(--accent); }
        [data-theme="dark"] .toggle-theme::after { transform: translateX(22px); }

        .btn {
            padding: 10px 20px; border-radius: 10px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            border: none; text-decoration: none;
            display: inline-flex; align-items: center; gap: 7px;
            transition: opacity 0.2s, transform 0.1s;
            white-space: nowrap;
        }
        .btn:hover  { opacity: 0.85; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-back { background: var(--surface); color: var(--text); border: 1.5px solid var(--border); }

        .info-banner {
            background: color-mix(in srgb, var(--accent) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--accent) 30%, transparent);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--text-muted);
            display: flex; gap: 10px; align-items: center;
        }
        .info-banner strong { color: var(--text); }

        .card {
            background: var(--surface);
            border-radius: 18px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .card-body { padding: 24px; }

        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead tr { background: var(--thead); }
        thead th {
            padding: 13px 18px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            color: var(--thead-txt);
            text-align: left;
        }

        tbody td {
            padding: 15px 18px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            text-align: left;
            vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: var(--row-hover); }

        .rank {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px; font-weight: 600;
            color: var(--text-muted);
            width: 34px; height: 34px;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .rank.top {
            background: var(--accent); color: white;
            border-color: var(--accent); font-size: 16px;
        }

        .badge-dist {
            background: var(--badge-dist-bg);
            color: var(--badge-dist-txt);
            padding: 5px 13px; border-radius: 999px;
            font-size: 12px; font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
        }
        .badge-ctry {
            background: var(--badge-ctry-bg);
            color: var(--badge-ctry-txt);
            padding: 5px 13px; border-radius: 999px;
            font-size: 12px; font-weight: 600;
        }

        .empty-box {
            text-align: center; padding: 52px; color: var(--text-muted);
        }
        .empty-icon { font-size: 40px; margin-bottom: 12px; }

        /* CUSTOM PAGINATION - no Bootstrap needed */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-top: 26px;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
        }
        .pagination-wrap li { display: inline-flex; }
        .pagination-wrap li a,
        .pagination-wrap li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid var(--border);
            color: var(--page-txt);
            text-decoration: none;
            background: var(--page-btn);
            transition: all 0.2s;
            white-space: nowrap;
        }
        .pagination-wrap li a:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: color-mix(in srgb, var(--accent) 8%, transparent);
        }
        .pagination-wrap li.active span {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        .pagination-wrap li.disabled span {
            opacity: 0.4;
            cursor: not-allowed;
        }

        @media (max-width: 600px) {
            .top-bar { flex-direction: column; align-items: flex-start; }
            thead th, tbody td { padding: 11px 12px; font-size: 12px; }
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="top-bar">
        <div class="brand">
            <div class="brand-icon">📍</div>
            <div class="brand-text">
                <h1>Nearby Ports</h1>
                <p>Sorted by distance · PostGIS ST_DistanceSphere</p>
            </div>
        </div>
        <div class="top-actions">
            <button class="toggle-theme" id="themeToggle" title="Toggle dark/light mode"></button>
            <a href="/" class="btn btn-back">← All Ports</a>
        </div>
    </div>

    <div class="info-banner">
        📡 <span><strong>Your location:</strong> Mumbai, India (19.0760°N, 72.8777°E) · Showing nearest ports first</span>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Port Name</th>
                            <th>Country</th>
                            <th>Distance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ports as $port)
                            @php $rank = $ports->firstItem() + $loop->index; @endphp
                            <tr>
                                <td>
                                    <span class="rank {{ $rank <= 3 ? 'top' : '' }}">
                                        @if($rank == 1) 🥇
                                        @elseif($rank == 2) 🥈
                                        @elseif($rank == 3) 🥉
                                        @else {{ $rank }}
                                        @endif
                                    </span>
                                </td>
                                <td><strong>{{ $port->name }}</strong></td>
                                <td><span class="badge-ctry">{{ $port->country }}</span></td>
                                <td>
                                    <span class="badge-dist">
                                        {{ number_format($port->distance / 1000, 2) }} km
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-box">
                                        <div class="empty-icon">🚫</div>
                                        <p>No nearby ports found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Custom pagination - Bootstrap CSS dependency nathi --}}
            @if($ports->hasPages())
            <ul class="pagination-wrap">
                {{-- Previous button --}}
                @if($ports->onFirstPage())
                    <li class="disabled"><span>«</span></li>
                @else
                    <li><a href="{{ $ports->previousPageUrl() }}">«</a></li>
                @endif

                {{-- Page numbers --}}
                @foreach($ports->getUrlRange(1, $ports->lastPage()) as $page => $url)
                    @if($page == $ports->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next button --}}
                @if($ports->hasMorePages())
                    <li><a href="{{ $ports->nextPageUrl() }}">»</a></li>
                @else
                    <li class="disabled"><span>»</span></li>
                @endif
            </ul>
            @endif

        </div>
    </div>

</div>

<script>
    const html      = document.documentElement;
    const THEME_KEY = 'port_theme';

    function applyTheme(t) {
        html.setAttribute('data-theme', t);
        localStorage.setItem(THEME_KEY, t);
    }
    applyTheme(localStorage.getItem(THEME_KEY) || 'dark');

    document.getElementById('themeToggle').addEventListener('click', () => {
        applyTheme(html.getAttribute('data-theme') === 'light' ? 'dark' : 'light');
    });
</script>

</body>
</html>