@extends('layouts.app')

@section('content')
    <div class="px-5 container-fluid">
        <div class="row">
            <div class="col-md-6 col-12">
                <h1 class="mb-4">Barang-barang Micro</h1>
            </div>
            <div class="col-md-6 col-12 d-flex align-items-center justify-content-end">
                <a href="{{ route('items.create') }}" class="mb-3 btn btn-primary">
                    <i class="fas fa-plus"></i> Barang
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Box - Posisi</th>
                        <th>Stock</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->box->code ?? '-' }} - {{ $item->box->position ?? '-' }}</td>
                            <td>{{ $item->stock }} {{ $item->unit }}</td>
                            <td>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fas fa-pencil"></i></a>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmDelete(itemId) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("delete-form-" + itemId).submit();
                }
            });
        }
    </script>
@endsection
