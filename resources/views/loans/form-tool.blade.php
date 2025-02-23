@extends('layouts.app')

@section('content')
    <div class="container-fluid mx-auto">
        <h2 class="mb-4 text-center">Peminjaman Tool / Alat Micro</h2>
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row mb-3">
            <div class="col-md-4 col-12 d-flex justify-content-center align-items-center">
                <h5><strong>Nama</strong>: {{ $name }}</h5>
            </div>
            <div class="col-md-4 col-12 d-flex justify-content-center align-items-center">
                <h5><strong>Divisi</strong>: {{ $division }}</h5>
            </div>
            <div class="col-md-4 col-12 d-flex justify-content-center align-items-center">
                <h5><strong>No. Telp</strong>: {{ maskPhoneNumber($phone) }}</h5>
            </div>
        </div>

        <!-- Form untuk pinjam tool -->
        <div id="pinjam-tool">
            <form method="POST" action="{{ route('loans.store') }}">
                @csrf
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="division" value="{{ $division }}">

                <!-- Tampilkan tools berdasarkan kategori -->
                {{-- @dd($tools) --}}
                @foreach ($tools as $toolcategory => $items)
                    <div class="card mb-4">
                        <div class="card-header" style="background: var(--primary-color); color: var(--acc-color);">
                            <h3 class="fw-bold">{{ $toolcategory }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Gambar</th>
                                            <th>Nama tool</th>
                                            <th>Stok</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $tool)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="tools[{{ $tool->id }}][tool_id]"
                                                        value="{{ $tool->id }}">
                                                </td>
                                                <td>
                                                    @if ($tool->image_path)
                                                        @if (filter_var($tool->image_path, FILTER_VALIDATE_URL))
                                                            <img src="{{ $tool->image_path }}" alt="{{ $tool->name }}"
                                                                class="thumbnail-img" style="width: 50px; height: 50px;">
                                                        @else
                                                            <img src="{{ asset('storage/' . $tool->image_path) }}"
                                                                alt="{{ $tool->name }}" class="thumbnail-img"
                                                                style="width: 50px; height: 50px;">
                                                        @endif
                                                    @else
                                                        <p>Tidak ada gambar.</p>
                                                    @endif
                                                </td>
                                                <td>{{ $tool->name }}</td>
                                                <td>
                                                    <span id="stock-{{ $tool->id }}">{{ $tool->stock }}
                                                        {{ $tool->unit }}</span>
                                                </td>
                                                <td>
                                                    <input type="number" name="tools[{{ $tool->id }}][qty]"
                                                        class="form-control" min="1" disabled
                                                        value="{{ old('tools[' . $tool->id . '][qty]') }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="mt-3 btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let qtyInput = this.closest('tr').querySelector('input[type="number"]');
                qtyInput.disabled = !this.checked;
            });
        });
    </script>
@endsection
