@extends('layouts.app')

@section('content')
    <style>
        .container-fluid {
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--acc-color);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container-fluid h1 {
            color: var(--birusepuh);
            text-align: center;
            margin-bottom: 2rem;
        }

        .container-fluid .form-control {
            border: 2px solid var(--birupemula);
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .container-fluid .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(84, 124, 144, 0.2);
        }

        .container-fluid label {
            font-weight: 600;
            color: var(--birusepuh);
            margin-bottom: 0.5rem;
        }

        .container-fluid .btn-success {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .container-fluid .btn-success:hover {
            background-color: var(--sec-color);
            transform: translateY(-2px);
        }

        .container-fluid .btn-success:active {
            transform: translateY(0);
        }

        .container-fluid .form-group {
            margin-bottom: 1.5rem;
        }

        .container-fluid .form-group:last-child {
            margin-bottom: 0;
        }

        .container-fluid .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .container-fluid .form-group input[type="file"] {
            display: none;
        }

        .container-fluid .form-group input[type="url"] {
            padding: 0.75rem;
        }

        .container-fluid .form-control:hover {
            border-color: var(--primary-color);
        }

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

    <div class="container-fluid">
        <h1>Tambah Item</h1>
        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row">
                <!-- Nama dan Box -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="box_id">Box</label>
                        <select name="box_id" id="box_id" class="form-control">
                            @foreach ($boxes as $box)
                                <option value="{{ $box->id }}" {{ old('box_id') == $box->id ? 'selected' : '' }}>
                                    {{ $box->code }} - {{ $box->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
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
                        <input type="number" class="form-control" name="stock" value="{{ old('stock') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select name="unit" id="unit"
                            class="form-control pilih-unit @error('unit') is-invalid @enderror">
                            <option value="" {{ old('unit') == '' ? 'selected' : '' }}>--Pilih unit--</option>
                            <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="Pack" {{ old('unit') == 'Pack' ? 'selected' : '' }}>Pack</option>
                            <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box
                            </option>
                            <option value="Meter" {{ old('unit') == 'Meter' ? 'selected' : '' }}>Meter
                            </option>
                            <option value="Liter" {{ old('unit') == 'Liter' ? 'selected' : '' }}>Liter
                            </option>
                            <option value="Lain" {{ old('unit') == 'Lain' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <input type="text" name="unit" id="unitlain"
                            class="form-control d-none mt-3 @error('unit') is-invalid @enderror"
                            value="{{ old('unit') }}">
                        @error('unit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                            onchange="previewImage(event)">
                        <button type="button" class="mt-2 btn btn-danger" id="remove-image" style="display: none;"
                            onclick="removeImage()"><i class="fas fa-circle-xmark"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image_url">Atau Masukkan URL Gambar</label>
                        <input type="url" name="image_url" id="image_url" class="form-control"
                            placeholder="https://example.com/image.jpg">
                        <p class="text-muted fst-italic">*Cari gambar di internet, klik kanan lalu <strong>'Copy Image
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

    <!-- Script untuk Preview Gambar -->
    <script>
        document.querySelectorAll('.pilih-unit').forEach(select => {
            select.addEventListener('change', function() {
                let selectedValue = this.value;
                let unitlain = document.getElementById('unitlain');

                if (selectedValue === 'Lain') {
                    unitlain.classList.remove('d-none');
                    unitlain.setAttribute('required', true);
                    unitlain.disabled = false;
                } else {
                    unitlain.classList.add('d-none');
                    unitlain.removeAttribute('required');
                    unitlain.disabled = true;
                }
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

    <!-- FontAwesome untuk Ikon Kamera -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
