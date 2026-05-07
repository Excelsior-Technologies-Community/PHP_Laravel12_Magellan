<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laravel Magellan Ports</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Poppins', sans-serif;
        }

        .main-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .top-header {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            padding: 30px;
            color: white;
        }

        .top-header h2 {
            font-weight: 700;
            margin: 0;
        }

        .custom-btn {
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 500;
        }

        .search-box {
            border-radius: 12px;
            height: 50px;
            border: 1px solid #dcdcdc;
            box-shadow: none !important;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead {
            background: #111827;
            color: white;
        }

        .table tbody tr:hover {
            background: #f1f5ff;
            transition: 0.3s;
        }

        .delete-btn {
            border-radius: 8px;
        }

        .badge-country {
            background: #eef2ff;
            color: #4338ca;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .pagination {
            justify-content: center;
            margin-top: 25px;
        }

        .page-link {
            border-radius: 10px !important;
            margin: 0 5px;
            border: none;
            color: #0d6efd;
            font-weight: 600;
            padding: 10px 16px;
        }

        .page-item.active .page-link {
            background: #0d6efd;
            color: white;
        }

        .page-link:hover {
            background: #0d6efd;
            color: white;
        }

        .empty-box {
            padding: 40px;
            text-align: center;
            color: gray;
            font-size: 18px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="card shadow-lg main-card">

            <!-- Header -->
            <div class="top-header d-flex justify-content-between align-items-center flex-wrap">

                <div>
                    <h2>🚢 Laravel Magellan Ports</h2>
                    <p class="mb-0 mt-2">
                        Spatial Port Management System
                    </p>
                </div>

                <div class="mt-3 mt-md-0 d-flex gap-2">

                    <a href="/create-port" class="btn btn-light custom-btn">
                        + Add Port
                    </a>

                    <a href="/nearby-ports" class="btn btn-dark custom-btn">
                        Nearby Ports
                    </a>

                </div>

            </div>

            <div class="card-body p-4">

                <!-- Success Alert -->
                @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show">

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                @endif

                <!-- Search -->
                <form method="GET" action="/" class="mb-4">

                    <input type="text" name="search" class="form-control search-box"
                        placeholder="🔍 Search by port name or country..." value="{{ request('search') }}">

                </form>

                <!-- Table -->
                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>Port Name</th>
                                <th>Country</th>
                                <th width="120">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($ports as $port)

                                <tr>

                                    <td>

                                        <strong>
                                            {{ $port->name }}
                                        </strong>

                                    </td>

                                    <td>

                                        <span class="badge-country">
                                            {{ $port->country }}
                                        </span>

                                    </td>

                                    <td>

                                        <form action="/delete-port/{{ $port->id }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm delete-btn"
                                                onclick="return confirm('Delete this port?')">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4">

                                        <div class="empty-box">

                                            🚫 No Ports Found

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">

                    {{ $ports->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>