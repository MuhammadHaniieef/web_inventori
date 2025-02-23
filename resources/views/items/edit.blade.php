@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Edit Item</h1>
        <form method="POST" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Nama</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="box_id">Box</label>
                <select name="box_id" id="box_id" class="form-control">
                    @foreach ($boxes as $box)
                        <option value="{{ $box->id }}" {{ old('box_id') == $box->id ? 'selected' : '' }}>
                            {{ $box->code }} - {{ $box->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description">Deskripsi (Opsional)</label>
                <textarea class="form-control" name="description">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="stock">Stok</label>
                <input type="number" class="form-control" name="stock" value="{{ old('stock', $item->stock) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="unit">Unit</label>
                <input type="text" class="form-control" name="unit" value="{{ old('unit', $item->unit) }}" required>
            </div>

            <div class="mb-3">
                <label for="image">Upload Gambar</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="mb-3">
                <label for="image_url">Atau Masukkan URL Gambar</label>
                <input type="url" name="image_url" id="image_url" class="form-control"
                    placeholder="https://example.com/image.jpg">
            </div>

            {{-- <div class="mb-3">
                <label for="requires_approval">Requires Approval</label>
                <select name="requires_approval" id="requires_approval" class="form-control">
                    <option value="1"
                        {{ old('requires_approval', $item->requires_approval ?? '') == '1' ? 'selected' : '' }}>Perlu
                    </option>
                    <option value="0"
                        {{ old('requires_approval', $item->requires_approval ?? '') == '0' ? 'selected' : '' }}>Tidak Perlu
                    </option>
                </select>
            </div> --}}

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
