@extends('layouts.app')

@section('content')
    <style>
        .card-chart {
            background: var(--acc-color);
            border: 2px solid var(--abusepuh);
            border-radius: 10px;
            color: var(--birusepuh);
            box-shadow: 0 0 10px rgba(30, 55, 69, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-chart .card-header {
            background-color: var(--acc-color);
            color: var(--sec-color);
            border-bottom: 0 solid var(--abusepuh);
        }

        .card {
            background-color: var(--birusepuh);
            border: 2px solid var(--abusepuh);
            border-radius: 10px;
            color: var(--acc-color);
            box-shadow: 0 0 10px rgba(30, 55, 69, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(30, 55, 69, 0.5);
        }

        .frequently-out-list {
            list-style: none;
            padding: 0;
        }

        .frequently-out-list li {
            padding: 10px;
            margin: 5px 0;
            background-color: var(--sec-color);
            border-radius: 5px;
            color: var(--acc-color);
            transition: background-color 0.3s ease;
        }

        .frequently-out-list li:hover {
            background-color: var(--primary-color);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--birupemula);
        }

        .table th {
            background-color: var(--sec-color);
            color: var(--acc-color);
        }

        .table tbody tr:hover {
            background-color: rgba(30, 55, 69, 0.1);
        }

        .card-header {
            background-color: var(--sec-color);
            color: var(--acc-color);
            border-bottom: 2px solid var(--abusepuh);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--sec-color);
            border-color: var(--sec-color);
        }
    </style>

    <div id="anjay" class="p-5 container-fluid">
        @if (session('success'))
            <div class="mt-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-3 alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Cards Section -->
        <div class="row">
            <div class="col-md-8">
                <div class="mb-4 row">
                    <div class="col-md-4">
                        <div class="mb-4 card dash-card">
                            <div class="card-body">
                                <div class="gap-3 mb-4 kepala-kartu d-flex align-items-center">
                                    <div class="icons-cont">
                                        <i class="fas fa-user card-icons" style="font-size: 1.4rem;"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('users.index') }}"
                                            class="text-decoration-none fs-3 fw-bold text-light">Total
                                            Pengguna</a>
                                        <hr class="border-3 w-100" style="margin-top: -0.2rem;">
                                    </div>
                                </div>
                                <small class="card-text fs-4">Total ada: <strong>{{ $userCount }}</strong> Users</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4 card dash-card">
                            <div class="card-body">
                                <div class="gap-3 mb-4 kepala-kartu d-flex align-items-center">
                                    <div class="icons-cont">
                                        <i class="fas fa-box card-icons" style="font-size:1.4rem;"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('items.index') }}"
                                            class="text-decoration-none fs-3 fw-bold text-light">Total
                                            Barang</a>
                                        <hr class="border-3 w-100" style="margin-top: -0.2rem;">
                                    </div>
                                </div>
                                <small class="card-text fs-4">Total ada: <strong>{{ $itemCount }}</strong> Barang</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4 card dash-card">
                            <div class="card-body">
                                <div class="gap-3 mb-4 kepala-kartu d-flex align-items-center">
                                    <div class="icons-cont">
                                        <i class="fas fa-screwdriver-wrench card-icons" style="font-size:1.4rem;"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('tools.index') }}"
                                            class="text-decoration-none fs-3 fw-bold text-light">Total
                                            Tools</a>
                                        <hr class="border-3 w-100" style="margin-top: -0.2rem;">
                                    </div>
                                </div>
                                <small class="card-text fs-4">Total ada: <strong>{{ $toolCount }}</strong> Tools</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="mb-4 row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Items</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->category->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $items->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Tools</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tools as $tool)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $tool->name }}</td>
                                                    <td>{{ $tool->tool_category->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $tools->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Barang yang Sering Keluar -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Barang yang Sering Keluar</h5>
                    </div>
                    <div class="card-body">
                        @if ($frequentlyOut && !$frequentlyOut->isEmpty())
                            <ul class="frequently-out-list">
                                @foreach ($frequentlyOut as $fO)
                                    <li>{{ $fO->item->name ?? $fO->tool->name }} - {{ $fO->total }}x</li>
                                @endforeach
                            </ul>
                        @else
                            <h4 class="text-light fst-italic">-- Tidak ada data</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Section -->
        <div class="mb-4 row">
            <div class="col-md-12">
                <div class="p-4 card-chart">
                    <div class="card-header">
                        <h5 class="card-title">Perbandingan Barang Masuk dan Keluar (Bulan
                            {{ date('F Y', strtotime($selectedMonth)) }})</h5>
                        <form method="GET" action="{{ route('dashboard') }}" id="form-tgl">
                            <div class="form-group">
                                <label for="selected_month" class="mr-2">Pilih Bulan:</label>
                                <input type="month" name="selected_month" id="slMonth" class="form-control"
                                    value="{{ $selectedMonth }}">
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="itemChart"></div>
                        <div id="toolChart" class="mt-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.querySelector("#form-tgl").onchange = function(e) {
            document.querySelector("#frm").submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const stockInItems = @json($stockInItems);
            const stockOutItems = @json($stockOutItems);
            const stockInTools = @json($stockInTools);
            const stockOutTools = @json($stockOutTools);

            const labels = Array.from({
                length: 4
            }, (_, i) => `Minggu ${i + 1}`);

            // Data untuk Item
            const itemInQuantities = Array.from({
                length: 4
            }, (_, i) => {
                const weekData = stockInItems.find(data => data.period === i + 1);
                return weekData ? weekData.total : 0;
            });
            const itemOutQuantities = Array.from({
                length: 4
            }, (_, i) => {
                const weekData = stockOutItems.find(data => data.period === i + 1);
                return weekData ? weekData.total : 0;
            });

            // Data untuk Tool
            const toolInQuantities = Array.from({
                length: 4
            }, (_, i) => {
                const weekData = stockInTools.find(data => data.period === i + 1);
                return weekData ? weekData.total : 0;
            });
            const toolOutQuantities = Array.from({
                length: 4
            }, (_, i) => {
                const weekData = stockOutTools.find(data => data.period === i + 1);
                return weekData ? weekData.total : 0;
            });

            // Konfigurasi ApexCharts untuk Item
            const itemChartOptions = {
                chart: {
                    type: 'line',
                    height: 350,
                },
                series: [{
                        name: 'Barang Masuk',
                        data: itemInQuantities,
                    },
                    {
                        name: 'Barang Keluar',
                        data: itemOutQuantities,
                    },
                ],
                xaxis: {
                    categories: labels,
                    title: {
                        text: 'Minggu',
                    },
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Barang',
                    },
                },
                stroke: {
                    curve: 'smooth', // Line curve
                },
                colors: ['#4CAF50', '#F44336'],
            };

            // Konfigurasi ApexCharts untuk Tool
            const toolChartOptions = {
                chart: {
                    type: 'line',
                    height: 350,
                },
                series: [{
                        name: 'Tool Masuk',
                        data: toolInQuantities,
                    },
                    {
                        name: 'Tool Keluar',
                        data: toolOutQuantities,
                    },
                ],
                xaxis: {
                    categories: labels,
                    title: {
                        text: 'Minggu',
                    },
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Barang',
                    },
                },
                stroke: {
                    curve: 'smooth', // Line curve
                },
                colors: ['#2196F3', '#FF9800'],
            };

            // Render grafik untuk Item
            const itemChart = new ApexCharts(document.querySelector("#itemChart"), itemChartOptions);
            itemChart.render();

            // Render grafik untuk Tool
            const toolChart = new ApexCharts(document.querySelector("#toolChart"), toolChartOptions);
            toolChart.render();
        });
    </script>
@endsection
