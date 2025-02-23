@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2>Tools Categories</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createtcgModal">Add tcg</button>
        </div>

        <div class="row">
            @foreach ($toolscategories as $tcg)
                <div class="mb-3 col-md-4">
                    <div class="card border-{{ ['primary', 'success', 'danger', 'warning', 'info'][rand(0, 4)] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tcg->name }}</h5>
                            <p class="card-text">{{ $tcg->description }}</p>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edittcgModal{{ $tcg->id }}">Edit</button>
                            <form action="{{ route('toolscategories.destroy', $tcg->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="edittcgModal{{ $tcg->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit tcg</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('toolscategories.update', $tcg->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $tcg->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description">{{ $tcg->description }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Create Modal -->
        <div class="modal fade" id="createtcgModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add tcg</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('toolscategories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
