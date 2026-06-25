<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Port Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root[data-theme="light"] {
            --bg:           #f0f4f8;
            --surface:      #ffffff;
            --surface2:     #f8fafc;
            --border:       #e2e8f0;
            --text:         #0f172a;
            --text-muted:   #64748b;
            --accent:       #0ea5e9;
            --danger:       #ef4444;
            --badge-bg:     #eff6ff;
            --badge-txt:    #1d4ed8;
            --shadow:       0 4px 24px rgba(0,0,0,0.07);
            --thead:        #1e293b;
            --thead-txt:    #f8fafc;
            --row-hover:    #f1f5ff;
            --input-bg:     #ffffff;
            --toggle-bg:    #e2e8f0;
            --page-btn:     #ffffff;
            --page-txt:     #64748b;
        }
        :root[data-theme="dark"] {
            --bg:           #0b1120;
            --surface:      #131c2e;
            --surface2:     #1a2540;
            --border:       #1e2d45;
            --text:         #e2e8f0;
            --text-muted:   #64748b;
            --accent:       #38bdf8;
            --danger:       #f87171;
            --badge-bg:     #1e3a5f;
            --badge-txt:    #93c5fd;
            --shadow:       0 4px 24px rgba(0,0,0,0.4);
            --thead:        #0d1526;
            --thead-txt:    #94a3b8;
            --row-hover:    #1a2540;
            --input-bg:     #1a2540;
            --toggle-bg:    #38bdf8;
            --page-btn:     #1a2540;
            --page-txt:     #94a3b8;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--text);
            min-height: 100vh;
            transition: background 0.3s, color 0.3s;
        }

        .wrapper { max-width: 1050px; margin: 0 auto; padding: 36px 20px; }

        /* TOP BAR */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 14px;
        }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--accent), #6366f1);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .brand-text h1 { font-size: 20px; font-weight: 700; line-height: 1.2; }
        .brand-text p  { font-size: 12px; color: var(--text-muted); margin-top: 1px; }

        .top-actions { display: flex; gap: 10px; align-items: center; }

        /* THEME TOGGLE */
        .toggle-theme {
            width: 48px; height: 26px;
            background: var(--toggle-bg);
            border-radius: 999px;
            border: none; cursor: pointer;
            position: relative;
            transition: background 0.3s;
            flex-shrink: 0;
        }
        .toggle-theme::after {
            content: '';
            position: absolute;
            top: 3px; left: 3px;
            width: 20px; height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.25);
        }
        [data-theme="light"] .toggle-theme { background: #cbd5e1; }
        [data-theme="dark"]  .toggle-theme { background: var(--accent); }
        [data-theme="dark"]  .toggle-theme::after { transform: translateX(22px); }

        /* BUTTONS */
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: opacity 0.2s, transform 0.1s;
            white-space: nowrap;
        }
        .btn:hover  { opacity: 0.85; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-nearby  { background: var(--surface2); color: var(--text); border: 1.5px solid var(--border); }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-danger  {
            background: var(--danger); color: white;
            font-size: 12px; padding: 7px 14px;
            border-radius: 8px;
        }

        /* CARD */
        .card {
            background: var(--surface);
            border-radius: 18px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .card-body { padding: 24px; }

        /* ALERT */
        .alert-success {
            background: color-mix(in srgb, #22c55e 12%, transparent);
            color: #22c55e;
            border: 1px solid color-mix(in srgb, #22c55e 25%, transparent);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        /* SEARCH */
        .search-wrapper { position: relative; margin-bottom: 22px; }
        .search-icon {
            position: absolute;
            left: 15px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            pointer-events: none;
            color: var(--text-muted);
        }
        .search-input {
            width: 100%;
            padding: 13px 18px 13px 44px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: var(--input-bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 18%, transparent);
        }

        /* SUGGESTIONS */
        .suggestions-box {
            position: absolute;
            top: calc(100% + 6px); left: 0; right: 0;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
            z-index: 200;
            overflow: hidden;
            display: none;
        }
        .suggestions-box.show { display: block; }
        .sug-label {
            font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: var(--text-muted);
            padding: 10px 14px 4px;
        }
        .sug-item {
            padding: 10px 14px;
            font-size: 13px; cursor: pointer;
            display: flex; align-items: center; gap: 9px;
            color: var(--text); transition: background 0.15s;
        }
        .sug-item:hover  { background: var(--row-hover); }
        .sug-icon        { color: var(--text-muted); font-size: 13px; }
        .sug-match       { color: var(--accent); font-weight: 600; }
        .sug-divider     { height: 1px; background: var(--border); margin: 4px 0; }
        .sug-clear {
            padding: 8px 14px; font-size: 11px;
            color: var(--danger); cursor: pointer;
            text-align: right; font-weight: 600;
        }
        .sug-clear:hover { background: var(--row-hover); }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
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

        .port-name { font-weight: 600; }

        .badge {
            display: inline-block;
            padding: 5px 13px;
            border-radius: 999px;
            font-size: 12px; font-weight: 600;
            background: var(--badge-bg);
            color: var(--badge-txt);
            font-family: 'JetBrains Mono', monospace;
        }

        .empty-box {
            text-align: center; padding: 52px;
            color: var(--text-muted);
        }
        .empty-icon { font-size: 40px; margin-bottom: 12px; }
        .empty-box p { font-size: 15px; }
        .empty-box a { color: var(--accent); text-decoration: none; font-weight: 600; }

        /* PAGINATION - custom, no Bootstrap needed */
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
            thead th, tbody td { padding: 11px 12px; }
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="top-bar">
        <div class="brand">
            <div class="brand-icon">🚢</div>
            <div class="brand-text">
                <h1>Port Manager</h1>
                <p>Spatial Port Management · Magellan</p>
            </div>
        </div>
        <div class="top-actions">
            <button class="toggle-theme" id="themeToggle" title="Toggle dark/light mode"></button>
            <a href="/nearby-ports" class="btn btn-nearby">📍 Nearby Ports</a>
            <a href="/create-port"  class="btn btn-primary">+ Add Port</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            @if(session('success'))
                <div class="alert-success">✓ {{ session('success') }}</div>
            @endif

            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <form method="GET" action="/" id="searchForm">
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        class="search-input"
                        placeholder="Search port name or country..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >
                </form>
                <div class="suggestions-box" id="suggestionsBox"></div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Port Name</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ports as $port)
                            <tr>
                                <td><span class="port-name">{{ $port->name }}</span></td>
                                <td><span class="badge">{{ $port->country }}</span></td>
                                <td>
                                    <form action="/delete-port/{{ $port->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" onclick="return confirm('Delete this port?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-box">
                                        <div class="empty-icon">🚫</div>
                                        <p>No ports found. <a href="/create-port">Add your first port →</a></p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Custom pagination - Bootstrap bullet fix --}}
            @if($ports->hasPages())
            <ul class="pagination-wrap">
                {{-- Previous --}}
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

                {{-- Next --}}
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
    const HIST_KEY  = 'port_search_history';

    function applyTheme(t) {
        html.setAttribute('data-theme', t);
        localStorage.setItem(THEME_KEY, t);
    }
    applyTheme(localStorage.getItem(THEME_KEY) || 'dark');

    document.getElementById('themeToggle').addEventListener('click', () => {
        applyTheme(html.getAttribute('data-theme') === 'light' ? 'dark' : 'light');
    });

    const searchInput    = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestionsBox');
    const searchForm     = document.getElementById('searchForm');

    function getHistory() {
        try { return JSON.parse(localStorage.getItem(HIST_KEY)) || []; }
        catch { return []; }
    }
    function saveHistory(val) {
        if (!val.trim()) return;
        let h = getHistory().filter(x => x.toLowerCase() !== val.toLowerCase());
        h.unshift(val.trim());
        localStorage.setItem(HIST_KEY, JSON.stringify(h.slice(0, 8)));
    }
    function clearHistory() {
        localStorage.removeItem(HIST_KEY);
        hideSug();
    }
    function hideSug() { suggestionsBox.classList.remove('show'); }

    function hl(text, q) {
        if (!q) return text;
        const i = text.toLowerCase().indexOf(q.toLowerCase());
        if (i === -1) return text;
        return text.slice(0, i)
            + '<span class="sug-match">' + text.slice(i, i + q.length) + '</span>'
            + text.slice(i + q.length);
    }

    function makeItem(icon, label, q, onClick) {
        const el = document.createElement('div');
        el.className = 'sug-item';
        el.innerHTML = `<span class="sug-icon">${icon}</span><span>${hl(label, q)}</span>`;
        el.addEventListener('mousedown', e => { e.preventDefault(); onClick(); });
        return el;
    }

    function renderSuggestions(live, q) {
        const box     = suggestionsBox;
        const history = getHistory();
        box.innerHTML = '';
        let any = false;

        const filtHist = q
            ? history.filter(h => h.toLowerCase().includes(q.toLowerCase())).slice(0, 3)
            : history.slice(0, 5);

        if (filtHist.length) {
            const lbl = document.createElement('div');
            lbl.className = 'sug-label';
            lbl.textContent = 'Recent Searches';
            box.appendChild(lbl);

            filtHist.forEach(h => {
                box.appendChild(makeItem('🕐', h, q, () => {
                    searchInput.value = h; saveHistory(h); searchForm.submit();
                }));
            });

            const clr = document.createElement('div');
            clr.className = 'sug-clear';
            clr.textContent = 'Clear history';
            clr.addEventListener('mousedown', e => { e.preventDefault(); clearHistory(); });
            box.appendChild(clr);
            any = true;
        }

        if (live && live.length) {
            if (any) {
                const d = document.createElement('div');
                d.className = 'sug-divider';
                box.appendChild(d);
            }
            const lbl2 = document.createElement('div');
            lbl2.className = 'sug-label';
            lbl2.textContent = 'Suggestions';
            box.appendChild(lbl2);

            live.forEach(item => {
                box.appendChild(makeItem('🚢', item, q, () => {
                    searchInput.value = item; saveHistory(item); searchForm.submit();
                }));
            });
            any = true;
        }

        box.classList.toggle('show', any);
    }

    let timer;
    searchInput.addEventListener('input', function () {
        const q = this.value.trim();
        clearTimeout(timer);
        if (!q) { renderSuggestions([], ''); return; }
        if (q.length >= 2) {
            timer = setTimeout(() => {
                fetch('/search-suggestions?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(d => renderSuggestions(d.suggestions, q))
                    .catch(()  => renderSuggestions([], q));
            }, 250);
        } else {
            renderSuggestions([], q);
        }
    });

    searchInput.addEventListener('focus', function () {
        if (!this.value.trim()) renderSuggestions([], '');
    });
    searchInput.addEventListener('blur', () => setTimeout(hideSug, 150));
    searchForm.addEventListener('submit', () => saveHistory(searchInput.value.trim()));
</script>

</body>
</html>