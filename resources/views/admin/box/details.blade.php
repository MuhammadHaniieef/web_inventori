@extends('layouts.app')

@section('content')
    <div class="container-fluid mx-auto">
        <h2 class="mb-4 text-center">Halaman Admin | Barang - Box: {{ $box->code }}</h2>
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                <span id="stock-{{ $item->id }}">{{ $item->stock }} {{ $item->unit }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @foreach ($items as $item)
            <select class="form-select activity-dropdown w-50" data-id="{{ $item->id }}">
                <option value="">Pilih</option>
                <option value="tambah">Tambah Barang</option>
                <option value="update">Update Name/Stock</option>
            </select>
        @endforeach


        {{-- update nama / stock barang --}}
        <div id="update" class="mt-3 card d-none">
            <div class="card-header">
                <h5>Update Barang</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('barangs.update') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <input type="text" name="items[{{ $item->id }}][name]"
                                                class="form-control" value="{{ $item->name }}">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $item->id }}][stock]"
                                                class="form-control" value="{{ $item->stock }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-info">OK</button>
                </form>
            </div>
        </div>

        {{-- ambil barang
        <div id="ambil-barang" class="d-none">
            <form method="POST" action="{{ route('barangs.ambil') }}">
                @csrf
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="division" value="{{ $division }}">

                <label class="form-label">Pilih Barang:</label>
                <div class="table-responsive"> <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="items[{{ $item->id }}][id]"
                                        value="{{ $item->id }}">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td><span id="stock-{{ $item->id }}">{{ $item->stock }}
                                        {{ $item->unit }}</span></td>
                                <td>
                                    <input type="number" name="items[{{ $item->id }}][qty]" class="form-control"
                                        min="1" disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> </div>

                <button type="submit" class="mt-3 btn btn-primary">Ambil Barang</button>
            </form>
        </div> --}}

        {{-- tambah barang --}}
        <div id="tambah-barang" class="mt-3 card d-none">
            <div class="card-header">
                <h5>Tambah Barang</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('barangs.tambah') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="box_id">Box</label>
                        <select name="box_id" id="box_id" class="form-control">
                            @foreach ($boxesList as $box)
                                <option value="{{ $box->id }}" {{ old('box_id') == $box->id ? 'selected' : '' }}>
                                    {{ $box->code }} - {{ $box->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description">Deskripsi (Opsional)</label>
                        <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="stock">Stok</label>
                        <input type="number" class="form-control" name="stock" value="{{ old('stock') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="unit">Unit</label>
                        <input type="text" class="form-control" name="unit" value="{{ old('unit') }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.activity-dropdown').forEach(select => {
            select.addEventListener('change', function() {
                let selectedValue = this.value;
                let updateSection = document.getElementById('update');
                let tambahSection = document.getElementById('tambah');

                if (selectedValue === 'update') {
                    updateSection.classList.remove('d-none');
                    tambahSection.classList.add('d-none');
                } else if (selectedValue === 'tambah') {
                    tambahSection.classList.remove('d-none');
                    updateSection.classList.add('d-none');
                } else {
                    updateSection.classList.add('d-none');
                    tambahSection.classList.add('d-none');
                }
            });
        });

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let qtyInput = this.closest('tr').querySelector('input[type="number"]');
                qtyInput.disabled = !this.checked;
            });
        });
    </script>
@endsection
