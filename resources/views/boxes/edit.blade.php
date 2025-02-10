@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header"></div>
            <form action="{{ route('boxes.update', $box->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="code" value="{{ old('code', $box->code) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description">{{ old('description', $box->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Posisi</label>
                        <input type="text" class="form-control" name="position"
                            value="{{ old('position', $box->position) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="detail_position" class="form-label">Detail Posisi</label>
                        <textarea type="text" class="form-control" name="detail_position" required> {{ old('detail_position', $box->detail_position) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis</label>
                        <select class="form-control" name="type">
                            <option value="plastic" {{ old('plastic', $box->type) == 'plastic' ? 'selected' : '' }}>Plastic
                            </option>
                            <option value="alumunium" {{ old('alumunium', $box->type) == 'alumunium' ? 'selected' : '' }}>
                                Aluminium
                            </option>
                            <option value="iron" {{ old('iron', $box->type) == 'iron' ? 'selected' : '' }}>
                                Besi
                            </option>
                            <option value="cardboard" {{ old('cardboard', $box->type) == 'cardboard' ? 'selected' : '' }}>
                                Cardboard
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label">Ukuran</label>
                        <select class="form-control" name="size">
                            <option value="large" {{ old('large', $box->size) == 'large' ? 'selected' : '' }}>Large
                            </option>
                            <option value="medium" {{ old('medium', $box->size) == 'medium' ? 'selected' : '' }}>Medium
                            </option>
                            <option value="small" {{ old('small', $box->size) == 'small' ? 'selected' : '' }}>Small
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('boxes.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
