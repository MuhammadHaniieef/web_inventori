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

        .container-fluid .btn-secondary {
            background-color: var(--meramera);
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .container-fluid .btn-secondary:hover {
            background-color: var(--pungki);
            transform: translateY(-2px);
        }

        .container-fluid .btn-secondary:active {
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

        .container-fluid .form-control:hover {
            border-color: var(--primary-color);
        }

        .btn-success i.fa-regular {
            display: inline;
            transition: all 0.3s ease-in-out;
        }

        .btn-success i.fa-solid {
            display: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-success:hover i.fa-regular {
            display: none;
        }

        .btn-success:hover i.fa-solid {
            display: inline;
        }

        @media(max-width:768px) {
            .btn-success span {
                display: none !important;
            }
        }
    </style>
    <div class="container-fluid">
        <h2>Edit Box</h2>
        <form action="{{ route('boxes.update', $box->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="code" value="{{ old('code', $box->code) }}"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="position" class="form-label">Posisi</label>
                        <input type="text" class="form-control" name="position"
                            value="{{ old('position', $box->position) }}" required>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description">{{ old('description', $box->description) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="detail_position" class="form-label">Detail Posisi</label>
                        <textarea class="form-control" name="detail_position" required>{{ old('detail_position', $box->detail_position) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="size" class="form-label">Ukuran</label>
                        <select class="form-control" name="size">
                            <option value="large" {{ old('size', $box->size) == 'large' ? 'selected' : '' }}>Large</option>
                            <option value="medium" {{ old('size', $box->size) == 'medium' ? 'selected' : '' }}>Medium
                            </option>
                            <option value="small" {{ old('size', $box->size) == 'small' ? 'selected' : '' }}>Small</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                {{-- <a href="{{ route('boxes.index') }}" class="btn btn-secondary w-25 text-center">Batal</a> --}}
                <button type="submit" class="btn btn-success w-75 text-center"><span>Update</span> <i
                        class="fa-regular fa-bookmark"></i><i class="fa-solid fa-bookmark"></i></button>
            </div>
        </form>
    </div>
@endsection
