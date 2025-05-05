@extends('layouts.app')

@section('content')
    <style>
        .qr-container {
            position: relative;
            display: inline-block;
            transition: all 0.5s ease-in-out;
        }

        .download-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            opacity: 1;
            transition: all 0.5s ease-in-out;
        }

        .qr-container:hover .download-btn {
            display: block;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="px-5 container-fluid">
        <h1 class="mb-4">Daftar Box</h1>

        <a href="{{ route('boxes.create') }}" class="mb-3 btn btn-primary">
            Tambah Box
        </a>

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
                        <th>No</th>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Posisi</th>
                        <th>Ukuran</th>
                        <th>QR Code</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($boxes as $box)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $box->code }}</td>
                            <td>{{ $box->description }}</td>
                            <td>{{ $box->position }}</td>
                            <td>{{ ucfirst($box->size) }}</td>
                            <td>
                                <div class="qr-container" onmouseover="showDownloadBtn({{ $box->id }})"
                                    onmouseout="hideDownloadBtn({{ $box->id }})">
                                    <div id="qrcode-{{ $box->id }}"></div>
                                    <button id="download-btn-{{ $box->id }}"
                                        class="download-btn btn btn-success btn-sm"
                                        onclick="downloadQRCode({{ $box->id }})">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.boxes.details', $box->id) }}" class="btn btn-info"><i
                                        class="fas fa-circle-info"></i></a>

                                <a href="{{ route('boxes.edit', $box->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fas fa-pencil"></i></a>

                                <form id="delete-form-{{ $box->id }}" action="{{ route('boxes.destroy', $box->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $box->id }}, '{{ $box->code }}')">
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
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($boxes as $box)
                new QRCode(document.getElementById("qrcode-{{ $box->id }}"), {
                    text: "{{ route('boxes.show', $box->id) }}",
                    width: 120,
                    height: 120,
                    correctLevel: QRCode.CorrectLevel.H
                });
            @endforeach
        });

        function downloadQRCode(boxId) {
            let qrDiv = document.querySelector(`#qrcode-${boxId} canvas`);
            if (!qrDiv) {
                alert("QR Code belum terbentuk!");
                return;
            }

            let qrCanvas = document.createElement("canvas");
            let qrSize = 300;
            let padding = 30;

            qrCanvas.width = qrSize;
            qrCanvas.height = qrSize;
            let ctx = qrCanvas.getContext("2d");

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, qrSize, qrSize);

            let qrImage = new Image();
            qrImage.src = qrDiv.toDataURL("image/png");
            qrImage.onload = function() {
                ctx.drawImage(qrImage, padding, padding, qrSize - 2 * padding, qrSize - 2 * padding);

                let link = document.createElement("a");
                link.href = qrCanvas.toDataURL("image/png");
                link.download = `QR_Box_${boxId}.png`;
                link.click();
            };
        }

        function confirmDelete(boxId, boxCode) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Box <b>${boxCode}</b> akan dihapus beserta data Barang yang ada di dalamnya.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${boxId}`).submit();
                }
            });
        }
    </script>
@endsection
