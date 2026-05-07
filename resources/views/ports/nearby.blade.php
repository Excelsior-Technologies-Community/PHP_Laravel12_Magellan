<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nearby Ports</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        body{
            background: #f4f7fb;
            font-family: 'Poppins', sans-serif;
        }

        .main-card{
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .header-section{
            background: linear-gradient(135deg,#198754,#0dcaf0);
            padding: 30px;
            color: white;
        }

        .header-section h2{
            margin: 0;
            font-weight: 700;
        }

        .back-btn{
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .table{
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead{
            background: #111827;
            color: white;
        }

        .table tbody tr:hover{
            background: #eef7ff;
            transition: 0.3s;
        }

        .distance-badge{
            background: #e0f2fe;
            color: #0369a1;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .country-badge{
            background: #eef2ff;
            color: #4338ca;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .pagination{
            justify-content: center;
            margin-top: 25px;
        }

        .page-link{
            border-radius: 10px !important;
            margin: 0 5px;
            border: none;
            color: #198754;
            font-weight: 600;
            padding: 10px 16px;
        }

        .page-item.active .page-link{
            background: #198754;
            color: white;
        }

        .page-link:hover{
            background: #198754;
            color: white;
        }

        .empty-box{
            text-align: center;
            padding: 40px;
            color: gray;
            font-size: 18px;
        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="card shadow-lg main-card">

        <!-- Header -->
        <div class="header-section d-flex justify-content-between align-items-center flex-wrap">

            <div>

                <h2>
                    📍 Nearby Ports
                </h2>

                <p class="mb-0 mt-2">
                    Distance calculation using Laravel Magellan + PostGIS
                </p>

            </div>

            <div class="mt-3 mt-md-0">

                <a href="/" class="btn btn-light back-btn">
                    ← Back
                </a>

            </div>

        </div>

        <div class="card-body p-4">

            <!-- Table -->
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Port Name</th>
                            <th>Country</th>
                            <th>Distance</th>

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

                                    <span class="country-badge">
                                        {{ $port->country }}
                                    </span>

                                </td>

                                <td>

                                    <span class="distance-badge">

                                        {{ round($port->distance / 1000, 2) }} KM

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3">

                                    <div class="empty-box">

                                        🚫 No Nearby Ports Found

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

</body>
</html>