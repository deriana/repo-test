@extends('layouts.app')

@section('title', 'Letter Status')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Letter Status</h1>
            <div class="section-header-button">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModal" data-backdrop="false">Add New</button>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">References</a></div>
                <div class="breadcrumb-item">Letter Status</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <h2 class="section-title">Letter Status</h2>
            <p class="section-lead">Manage status references for letters (incoming/outgoing).</p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status List</h4>
                        </div>
                        <div class="card-body">

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $status)
                                            <tr>
                                                <td>{{ $status->status }}</td>
                                                <td>{{ $status->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="btn btn-sm btn-info mr-2" data-toggle="modal"
                                                            data-target="#editModal{{ $status->id }}"data-backdrop="false">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>

                                                        <form action="{{ route('letter-status.destroy', $status->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus status ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $status->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModalLabel{{ $status->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form
                                                        action="{{ route('letter-status.update', $status->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $status->id }}">
                                                                    Edit Status
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <input type="text" name="status"
                                                                        class="form-control"
                                                                        value="{{ $status->status }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('letter-status.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
