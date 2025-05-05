@extends('layouts.app')

@section('content')
    <style>
        .manual-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .manual-container h1 {
            color: var(--sec-color);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .upload-section {
            background-color: var(--acc-color);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .upload-section h2 {
            color: var(--sec-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .upload-section input[type="file"] {
            display: none;
        }

        .upload-section .upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 2px dashed var(--sec-color);
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-section .upload-label:hover {
            background-color: rgba(30, 55, 69, 0.1);
        }

        .upload-section .upload-label i {
            font-size: 1.5rem;
            color: var(--sec-color);
            margin-right: 0.5rem;
        }

        .upload-section .upload-label span {
            color: var(--sec-color);
            font-size: 1rem;
        }

        .file-preview {
            margin-top: 1rem;
            text-align: center;
        }

        .file-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .file-preview a {
            display: block;
            margin-top: 1rem;
            color: var(--sec-color);
            text-decoration: none;
            font-weight: bold;
        }

        .manual-list {
            background-color: var(--acc-color);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .manual-list h2 {
            color: var(--sec-color);
            margin-bottom: 1rem;
        }

        .manual-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s ease;
        }

        .manual-item:last-child {
            border-bottom: none;
        }

        .manual-item:hover {
            background-color: rgba(30, 55, 69, 0.05);
        }

        .manual-item .file-name {
            color: var(--sec-color);
            font-size: 1rem;
        }

        .manual-item .actions {
            display: flex;
            gap: 0.5rem;
        }

        .manual-item .actions a {
            text-decoration: none;
            color: var(--acc-color);
            background-color: var(--sec-color);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .manual-item .actions a:hover {
            background-color: #265166;
        }
    </style>

    <div class="manual-container">
        <!-- Judul Halaman -->
        <h1>Panduan Pengguna</h1>

        <!-- Form Upload -->
        <div class="upload-section">
            <h2>Upload Panduan Baru</h2>
            <form action="{{ route('manual.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="manual-file" class="upload-label">
                    <i class="fas fa-upload"></i>
                    <span>Klik untuk upload file PDF</span>
                </label>
                <input type="file" name="user_guide" id="manual-file" accept="application/pdf" required>
                <div class="file-preview" id="file-preview">
                    <!-- Preview file akan ditampilkan di sini -->
                </div>
                <button type="submit" class="mt-3 btn btn-primary w-100">Upload</button>
            </form>
        </div>

        <!-- Daftar Panduan -->
        <div class="manual-list">
            <h2>Daftar Panduan</h2>
            @foreach ($uGuides as $uG)
                <div class="manual-item">
                    <span class="file-name">{{ $uG->name }}</span>
                    <div class="actions">
                        <a href="{{ route('manual.download', $uG->id) }}"><i class="fas fa-download"></i></a>
                        <a href="{{ route('manual.view', $uG->id) }}" target="_blank"><i
                                class="fas fa-arrow-up-right-from-square"></i></a>
                        {{-- <form action="{{ route('manual.delete', $uG->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById('manual-file');
            const filePreview = document.getElementById('file-preview');

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const fileType = file.type;
                    const fileURL = URL.createObjectURL(file);

                    if (fileType === 'application/pdf') {
                        filePreview.innerHTML = `
                            <p>File terpilih: <strong>${file.name}</strong></p>
                            <a href="${fileURL}" target="_blank">Lihat Preview PDF</a>
                        `;
                    } else {
                        filePreview.innerHTML = `<p>File terpilih: <strong>${file.name}</strong></p>`;
                    }
                } else {
                    filePreview.innerHTML = '';
                }
            });
        });
    </script>
@endsection
