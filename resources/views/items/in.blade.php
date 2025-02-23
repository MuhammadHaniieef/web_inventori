@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- @dd($items, $boxes) --}}
    <div class="container-fluid">
        <div class="justify-between row">
            <div class="col-6">
                <h1>Barang Datang (Waiting List)</h1>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a href="{{ route('cBrgDtg') }} "class="btn btn-primary"><i class="fas fa-plus"></i>Add barang</a>
            </div>
        </div>
        <form action="{{ route('pAToBox') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Nama Barang</th>
                            <th>Deskripsi</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td><input type="checkbox" name="item_ids[]" value="{{ $item->id }}"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-3">
                <label for="box_id" class="form-label">Pilih Box:</label>
                <select name="box_id" id="box_id" class="form-select select2" required>
                    <option value="">Pilih Box</option>
                    @foreach ($boxes as $box)
                        <option value="{{ $box->id }}">{{ $box->code }} - {{ $box->position }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tetapkan ke Box</button>
        </form>
        <!-- Pagination -->
        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>

    <script>
        // Script untuk select all checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="item_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
