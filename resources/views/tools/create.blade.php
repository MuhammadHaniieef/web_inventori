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

        .container-fluid h2 {
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
            /* Sembunyikan input file standar */
        }

        .container-fluid .form-group input[type="url"] {
            padding: 0.75rem;
        }

        .container-fluid .form-control:hover {
            border-color: var(--primary-color);
        }

        /* Gaya untuk ikon kamera */
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
        <h2>Tambah Alat</h2>
        <form action="{{ route('tools.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row">
                <!-- Nama dan Kategori -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="tool_category_id" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Deskripsi dan Stock -->
            <div class="mb-3 row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control"></textarea>
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
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="text-center form-group">
                <button type="submit" class="mt-2 btn btn-success w-75">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Script untuk Preview Gambar -->
    <script>
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
