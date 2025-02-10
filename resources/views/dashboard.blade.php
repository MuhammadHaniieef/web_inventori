@extends('layouts.app')

@section('content')
    <div class="px-5 container-fluid position-relative h-100">
        @if (session('success'))
            <div class="mt-3 alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-7 col-12">
                <h2>Daftar Items</h2>

                <table class="table mt-3 table-bordered">
                    <thead>
                        <tr>
                            <th>Nama barang</th>
                            <th>Deskripsi</th>
                            <th>Stok - unit</th>
                            <th><span class="text-danger">Dibuat</span> / <span class="text-primary">Diperbarui</span> oleh
                            </th>
                            <th>CB - Posisi</th>
                            <th>Kategori / Projek</th>
                            <th>Butuh Request</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->stock }} {{ $item->unit }}</td>
                                <td>{{ $item->createdBy->name }} / {{ $item->updatedBy->name }}</td>
                                <td>{{ $item->box->code ?? 'Tidak Ada' }} - {{ $item->box->position ?? 'Tidak ada' }}
                                </td>
                                <td>{{ $item->category->name ?? 'Tidak Ada' }}</td>
                                <td>{{ $item->requires_approval == 1 ? 'Perlu' : 'Tidak Perlu' }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm me-1"><i
                                            class="fas fa-pencil"></i></a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus item ini?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $items->links() }}
            </div>
            <div class="col-md-5 col-12">
                <h2>Peminjaman / Pengambilan</h2>
                <table class="table mt-3 table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Barang</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Ambil/Pinjam</th>
                            <th>Status</th>
                            <th>Diajukan Pada</th>
                            <th>Dikembalikan Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($loans) --}}
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $loan->item->name }}</td>
                                <td>{{ $loan->user->name ?? $loan->guest_name }}</td>
                                <td>{{ $loan->qty }}</td>
                                <td>
                                    @if ($loan->type == 'ambil')
                                        <span class="badge bg-danger">Ambil</span>
                                    @else
                                        <span class="badge bg-primary">Pinjam</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($loan->status === 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($loan->status === 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($loan->status === 'returned')
                                        <span class="badge bg-primary">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $loan->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $loan->returned_at ? $loan->returned_at->format('d M Y H:i') : '-' }}</td>
                                <td class="gap-2 d-flex">
                                    {{-- Tombol Terima --}}
                                    <form action="{{ route('approve.loans', ['loan' => $loan->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Terima Permintaan">
                                            <i class="fas fa-check"></i> Terima
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <form action="{{ route('reject.loans', ['loan' => $loan->id]) }}" method="POST"
                                        onsubmit="return confirm('Tolak permintaan ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Tolak Permintaan">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <a href="{{ route('items.create') }}" class="shadow btn btn-primary position-fixed bottom-3 right-3 rounded-circle"
            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            +
        </a> --}}
    </div>
@endsection
