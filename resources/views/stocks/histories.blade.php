@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Stock Histories</h1>

        <!-- Search Bar -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari item atau pengguna...">
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="text-center table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>User</th>
                        <th>Previous Stock</th>
                        <th>New Stock</th>
                        <th>Quantity</th>
                        <th>Stock Type</th>
                        <th>Transaction Type</th>
                        <th>Returned</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="stockTable">
                    @foreach ($sHistories as $history)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $history->item->name ?? 'Unknown' }}</td>
                            <td>{{ $history->user->name ?? 'Guest' }}</td>
                            <td>{{ $history->previous_stock }}</td>
                            <td>{{ $history->new_stock }}</td>
                            <td>{{ $history->quantity }}</td>
                            <td>
                                <span class="badge {{ $history->s_type == 'increase' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($history->s_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $history->t_type == 'pinjam' ? 'bg-info' : 'bg-warning' }}">
                                    {{ ucfirst($history->t_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $history->returned ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $history->returned ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript untuk Pencarian -->
    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll("#stockTable tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchValue) ? "" : "none";
            });
        });
    </script>
@endsection
