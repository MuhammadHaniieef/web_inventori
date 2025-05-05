@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 24px;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
            border-radius: 24px;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            backdrop-filter: blur(10px);
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .image-container:hover .overlay {
            opacity: 1;
        }

        .img-fluid {
            border-radius: 16px;
            border: 1px var(--primary-color) solid;
        }

        .thumbnail-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .overlay-baru {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            backdrop-filter: blur(10px);
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            transition: bottom 0.3s ease-in-out;
        }

        .kartu-baru {
            overflow: hidden;
        }

        .kartu-baru:hover .overlay-baru {
            bottom: 0;
        }

        .table-container {
            min-height: 400px;
            max-height: 400px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .overlay {
                opacity: 1;
            }
        }
    </style>
    <div class="px-3 container-fluid">
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Barang Masuk -->
        <div class="row mb-4">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="text-white card-header bg-success">
                        <h5>Barang Masuk</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-container">
                            <table class="table table-striped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Barang/Alat</th>
                                        <th>CB</th>
                                        <th>Sebelum</th>
                                        <th>Jumlah</th>
                                        <th>Sesudah</th>
                                        <th>Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sInHistories as $history)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $history->item->name ?? $history->tool->name }}</td>
                                            <td>{{ $history->item->box->code ?? '-' }} -
                                                {{ $history->item->box->position ?? '-' }}</td>
                                            <td>{{ $history->previous_stock }}</td>
                                            <td>{{ $history->qty }}</td>
                                            <td>{{ $history->new_stock }}</td>
                                            <td>
                                                @if ($history->type == 'new')
                                                    <span class="badge bg-success">Baru</span>
                                                @elseif ($history->type == 'update')
                                                    <span class="badge bg-warning">Update</span>
                                                @else
                                                    <span class="badge bg-danger">Kembalian</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barang Keluar -->
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="text-white card-header bg-danger">
                        <h5>Barang Diambil</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-container">
                            <table class="table table-striped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Barang/Alat</th>
                                        <th>Nama - Div</th>
                                        <th>Sebelum</th>
                                        <th>Jumlah</th>
                                        <th>Sesudah</th>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($takes) --}}
                                    @foreach ($takes as $take)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $take->item->name }}</td>
                                            <td>{{ $take->name }} - {{ $take->division }}</td>
                                            <td>{{ $take->previous_stock }}</td>
                                            <td>{{ $take->qty }}</td>
                                            <td>{{ $take->new_stock }}</td>
                                            <td>
                                                <span class="badge bg-danger">Ambil</span>
                                            </td>
                                            <td>{{ $take->created_at->format('d/m/y, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Datang -->
        <div class="row mb-4">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="text-white card-header bg-success">
                        <h5>Barang Datang</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-container">
                            <table class="table table-striped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Barang</th>
                                        <th>CB</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inItems as $iItem)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $iItem->name }}</td>
                                            <td>{{ 'Box untuk barang ini belum dipilih' }}</td>
                                            <td>{{ $iItem->category->name }}</td>
                                            <td>{{ $iItem->stock }} - {{ $iItem->unit }}</td>
                                            <td>
                                                @if (optional($iItem)->image_path)
                                                    @if (filter_var($iItem->image_path, FILTER_VALIDATE_URL))
                                                        <img src="{{ $iItem->image_path }}" alt="{{ $iItem->name }}"
                                                            class="thumbnail-img">
                                                    @else
                                                        <img src="{{ asset('storage/' . $iItem->image_path) }}"
                                                            alt="{{ $iItem->name }}" class="thumbnail-img">
                                                    @endif
                                                @else
                                                    <p>Tidak ada gambar.</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="text-white card-header bg-danger">
                        <h5>Tools Dipinjam</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-container">
                            <table class="table table-striped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Barang/Alat</th>
                                        <th>Nama - Div</th>
                                        <th>Sebelum</th>
                                        <th>Jumlah</th>
                                        <th>Sesudah</th>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $loan->tool->name }}</td>
                                            <td>{{ $loan->name }} - {{ $loan->division }}</td>
                                            <td>{{ $loan->previous_stock }}</td>
                                            <td>{{ $loan->qty }}</td>
                                            <td>{{ $loan->new_stock }}</td>
                                            <td>
                                                <span class="badge bg-warning">Pinjam</span>
                                            </td>
                                            <td>{{ $loan->created_at->format('d/m/y, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang/Tool Baru -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-3">Barang/Tool Baru</h4>
                <div class="row">
                    @foreach ($newlyAdded as $item)
                        <div class="mb-4 col-md-3 col-12">
                            <div class="kartu-baru flex-row card h-100 d-flex" style="height: 150px;">
                                <!-- Gambar -->
                                <div class="w-25 p-2">
                                    @if ($item->item_id && $item->item->image_path)
                                        @if (filter_var($item->item->image_path, FILTER_VALIDATE_URL))
                                            <img src="{{ $item->item->image_path }}" alt="{{ $item->item->name }}"
                                                class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('storage/' . $item->item->image_path) }}"
                                                alt="{{ $item->item->name }}" class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @endif
                                    @elseif ($item->tool_id && $item->tool->image_path)
                                        @if (filter_var($item->tool->image_path, FILTER_VALIDATE_URL))
                                            <img src="{{ $item->tool->image_path }}" alt="{{ $item->tool->name }}"
                                                class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('storage/' . $item->tool->image_path) }}"
                                                alt="{{ $item->tool->name }}" class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @endif
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                            <p class="mb-0 text-muted">Tidak ada gambar</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Informasi Barang -->
                                <div class="p-3 w-75">
                                    <h5 class="card-title">
                                        @if ($item->item_id)
                                            {{ $item->item->name ?? 'Item tidak ditemukan' }}
                                        @elseif ($item->tool_id)
                                            {{ $item->tool->name ?? 'Tool tidak ditemukan' }}
                                        @endif
                                    </h5>
                                    <p class="card-text">
                                        <strong>Tanggal:</strong> {{ $item->created_at->format('d/m/Y H:i') }}<br>
                                        <strong>Jumlah:</strong> {{ $item->qty }}
                                    </p>
                                </div>

                                <div class="overlay-baru">
                                    <h5 class="text-white text-center">
                                        @if ($item->item_id)
                                            {{ $item->item->name ?? 'Item tidak ditemukan' }}
                                        @elseif ($item->tool_id)
                                            {{ $item->tool->name ?? 'Tool tidak ditemukan' }}
                                        @endif
                                    </h5>
                                    <p class="text-white text-center">
                                        @if ($item->item_id)
                                            <strong>Kategori:</strong>{{ $item->item->category->name }} |
                                            <strong>Box: </strong>{{ $item->item->box->code ?? '-' }} -
                                            {{ $item->item->box->position ?? '-' }}<br>
                                            <strong>Stock:</strong> {{ $item->item->stock }}
                                        @elseif ($item->tool_id)
                                            <strong>Kategori:</strong>{{ $item->tool->tool_category->name }} |
                                            <strong>Stock:</strong> {{ $item->tool->stock }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Barang/Tool Sering Dipinjam/Ambil -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-3">Barang/Tool Sering Dipinjam/Ambil</h4>
                <div class="row">
                    @foreach ($frequentlyOut as $item)
                        <div class="mb-4 col-md-3 col-12">
                            <div class="card d-flex position-relative overflow-hidden">
                                <!-- Gambar -->
                                <div class="image-container">
                                    @if ($item->item_id && $item->item->image_path)
                                        @if (filter_var($item->item->image_path, FILTER_VALIDATE_URL))
                                            <img src="{{ $item->item->image_path }}" alt="{{ $item->item->name }}"
                                                class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('storage/' . $item->item->image_path) }}"
                                                alt="{{ $item->item->name }}" class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @endif
                                    @elseif ($item->tool_id && $item->tool->image_path)
                                        @if (filter_var($item->tool->image_path, FILTER_VALIDATE_URL))
                                            <img src="{{ $item->tool->image_path }}" alt="{{ $item->tool->name }}"
                                                class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('storage/' . $item->tool->image_path) }}"
                                                alt="{{ $item->tool->name }}" class="img-fluid h-100 w-100"
                                                style="object-fit: cover; object-position: center;">
                                        @endif
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                            <p class="mb-0 text-muted">Tidak ada gambar</p>
                                        </div>
                                    @endif

                                    <!-- Overlay -->
                                    <div class="overlay">
                                        <h5 class="text-white text-center">
                                            @if ($item->item_id)
                                                {{ $item->item->name ?? 'Item tidak ditemukan' }}
                                            @elseif ($item->tool_id)
                                                {{ $item->tool->name ?? 'Tool tidak ditemukan' }}
                                            @endif
                                        </h5>
                                        <p class="text-white text-center">
                                            <strong>Jumlah Keluar:</strong> {{ $item->total }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
