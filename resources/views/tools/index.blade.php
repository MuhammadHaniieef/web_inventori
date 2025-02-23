@extends('layouts.app')

@section('content')
    <div class="px-5 container-fluid">
        <div class="row">
            <div class="col-md-6 col-12">
                <h1 class="mb-4">Tools Micro</h1>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-end align-items-center">
                <a href="{{ route('tools.create') }}" class="mb-3 btn btn-primary">
                    Tambah tool
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
                        <th>Stock</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tools as $tool)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $tool->name }}</td>
                            <td>{{ $tool->description }}</td>
                            <td>{{ $tool->tool_category->name }}</td>
                            <td>{{ $tool->stock }}</td>
                            <td>
                                <a href="{{ route('tools.edit', $tool->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fas fa-pencil"></i></a>

                                <form id="delete-form-{{ $tool->id }}" action="{{ route('tools.destroy', $tool->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $tool->id }})">
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
        function confirmDelete(toolId) {
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
                    document.getElementById("delete-form-" + toolId).submit();
                }
            });
        }
    </script>
@endsection
