@extends('layouts.app')

@section('content')
    <style>
        .upload-photo {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border: 2px dashed var(--birupemula);
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-photo:hover {
            background-color: rgba(186, 207, 218, 0.1);
        }

        .upload-photo i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .upload-photo span {
            color: var(--birusepuh);
            font-size: 0.9rem;
        }

        .upload-photo img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 1rem;
        }
    </style>
    <div class="mx-auto container-fluid">
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

        <select class="form-select activity-dropdown w-50">
            <option value="">Pilih</option>
            <option value="tambah">Tambah Barang</option>
            <option value="update">Update Name/Stock</option>
        </select>


        {{-- update nama / stock barang --}}
        <div id="update" class="mt-3 card d-none">
            <div class="card-header">
                <h5>Update Barang</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('items.stock.update') }}">
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

        {{-- tambah barang --}}
        <div id="tambah" class="mt-3 card d-none">
            <div class="card-header">
                <h5>Tambah Barang</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <!-- Nama dan Box -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    required>
                                <input type="hidden" name="box_id" id="box_id" value="{{ $box->id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
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
                        </div>
                    </div>

                    <!-- Category dan Deskripsi -->
                    <div class="mb-3 row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Deskripsi (Opsional)</label>
                                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Stok dan Unit -->
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <input type="number" class="form-control" name="stock" value="{{ old('stock') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" name="unit" value="{{ old('unit') }}"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Upload Gambar</label>
                                <div class="upload-photo" onclick="document.getElementById('image').click()">
                                    <i class="fas fa-camera"></i>
                                    <span>Klik untuk upload gambar</span>
                                    <img id="preview-image" src="#" alt="Preview" style="display: none;">
                                </div>
                                <input type="file" name="image" id="image" class="form-control"
                                    style="display: none;" onchange="previewImage(event)">
                                <button type="button" class="mt-2 btn btn-danger" id="remove-image" style="display: none;"
                                    onclick="removeImage()"><i class="fas fa-circle-xmark"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image_url">Atau Masukkan URL Gambar</label>
                                <input type="url" name="image_url" id="image_url" class="form-control"
                                    placeholder="https://example.com/image.jpg">
                                <p class="text-muted fst-italic">*Cari gambar di internet, klik kanan lalu <strong>'Copy
                                        Image
                                        Address'</strong> </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="text-center form-group">
                        <button type="submit" class="mt-3 btn btn-success w-75">Simpan</button>
                    </div>
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

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-image');
            const removeButton = document.getElementById('remove-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    removeButton.style.display = 'inline-block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('preview-image');
            const removeButton = document.getElementById('remove-image');

            input.value = ''; // Reset input file
            preview.src = '#';
            preview.style.display = 'none';
            removeButton.style.display = 'none';
        }
    </script>
@endsection
