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
    <div class="px-5 container-fluid">
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6 col-12">
                <h2>Peminjaman Barang Micro</h2>
            </div>
            <div class="col-md-4 col-12">
                <input type="search" name="sLoans" id="sLoans" class="form-control w-100 mb-3" placeholder="Search...">
            </div>
            <div class="col-md-2 col-12">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        QR Code
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <div class="p-3">
                            <div class="qr-container">
                                <div id="qrcode-loan"></div>
                                <button id="download-btn-loan" class="download-btn btn btn-success btn-sm"
                                    onclick="downloadQRCodeLoan()">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="loanTables" class="table mt-3 table-bordered">
                <thead class="table-primary">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("sLoans");
            const table = document.getElementById("loanTables");
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

        document.addEventListener("DOMContentLoaded", function() {
            // Generate QR Code untuk route loans.form-name
            new QRCode(document.getElementById("qrcode-loan"), {
                text: "{{ route('loans.form-name') }}",
                width: 120,
                height: 120,
                correctLevel: QRCode.CorrectLevel.H
            });
        });

        // Fungsi untuk download QR Code
        function downloadQRCodeLoan() {
            let qrDiv = document.querySelector("#qrcode-loan canvas");
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
                link.download = `QR_Loan_Form.png`;
                link.click();
            };
        }
    </script>
@endsection
