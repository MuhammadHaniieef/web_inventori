@extends('layouts.app')

@section('content')
    <div class="px-5 container-fluid">
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif
        <h2>Peminjaman Barang Micro</h2>
        <div class="table-responsive">
            <table class="table mt-3 table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama - Divisi</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Telp</th>
                        <th>Diajukan Pada</th>
                        <th>Sudah Dikembalikan</th>
                        <th>Dikembalikan Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($loans) --}}
                    @foreach ($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $loan->name }} - {{ $loan->division }}</td>
                            <td>{{ $loan->tool->name }}</td>
                            <td>{{ $loan->qty }}</td>
                            <td>{{ $loan->phone ?? '-' }}</td>
                            <td>{{ $loan->borrowed_at }}</td>
                            <td>
                                @if ($loan->returned == false)
                                    <span class="badge bg-danger">Belum</span>
                                @else
                                    <span class="badge bg-success">Sudah</span>
                                @endif
                            </td>
                            <td>{{ $loan->returned_at ? $loan->returned_at : '-' }}</td>
                            <td class="gap-2 d-flex">
                                {{-- <form action="{{ route('approve.loans', ['loan' => $loan->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Terima Permintaan">
                                    <i class="fas fa-check"></i> Terima
                                </button>
                            </form>
                            <form action="{{ route('reject.loans', ['loan' => $loan->id]) }}" method="POST"
                                onsubmit="return confirm('Tolak permintaan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak Permintaan">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </form> --}}

                                <form action="{{ route('return.loans', ['loan' => $loan->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" title="Kembalikan Barang">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
