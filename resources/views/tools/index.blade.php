@extends('layouts.app')

@section('content')
    <div class="px-5 container-fluid">
        <div class="row">
            <div class="col-md-6 col-12">
                <h1 class="mb-4">Tools Micro</h1>
            </div>
            <div class="col-md-3 col-12 d-flex align-tools-center">
                <input type="search" name="stools" id="stools" class="form-control w-100 mb-3" placeholder="Search...">
            </div>
            <div class="col-md-3 col-12 d-flex align-items-center">
                <a href="{{ route('tools.create') }}" class="mb-3 btn btn-primary w-100">
                    <i class="fas fa-plus"></i> Tools
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
            <table id="toolsTable" class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Image</th>
                        <th>Kategori</th>
                        <th>Stock</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tools as $tool)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $tool->name }}</td>
                            <td>
                                @if (filter_var($tool->image_path, FILTER_VALIDATE_URL))
                                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                                        data-bs-target="#imageModal{{ $tool->id }}">
                                        <img src="{{ $tool->image_path }}" alt="{{ $tool->name }}" class="img-thumbnail"
                                            style="width: 50px; height: 50px;">
                                    @else
                                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                                            data-bs-target="#imageModal{{ $tool->id }}">
                                            <img src="{{ asset('storage/' . $tool->image_path) }}"
                                                alt="{{ $tool->name }}" class="img-thumbnail"
                                                style="width: 50px; height: 50px;">
                                @endif
                            </td>
                            <td>{{ $tool->tool_category->name }}</td>
                            <td>{{ $tool->stock }}</td>
                            <td>{{ $tool->created_at->format('d-M-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('tools.edit', $tool->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fas fa-pencil"></i></a>

                                <form id="delete-form-{{ $tool->id }}"
                                    action="{{ route('tools.destroy', $tool->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $tool->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal untuk gambar -->
                        <div class="modal fade" id="imageModal{{ $tool->id }}" tabindex="-1"
                            aria-labelledby="imageModalLabel{{ $tool->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel{{ $tool->id }}">Gambar
                                            {{ $tool->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        @if (filter_var($tool->image_path, FILTER_VALIDATE_URL))
                                            <img src="{{ $tool->image_path }}" alt="{{ $tool->name }}"
                                                class="img-fluid">
                                        @else
                                            <img src="{{ asset('storage/' . $tool->image_path) }}"
                                                alt="{{ $tool->name }}" class="img-fluid">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("stools");
            const table = document.getElementById("toolsTable");
            const rows = table.getElementsByTagName("tr");

            searchInput.addEventListener("input", function() {
                const searchTerm = searchInput.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName("td");
                    let match = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent.toLowerCase();
                        if (cellText.includes(searchTerm)) {
                            match = true;
                            break;
                        }
                    }

                    if (match) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            });
        });

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
