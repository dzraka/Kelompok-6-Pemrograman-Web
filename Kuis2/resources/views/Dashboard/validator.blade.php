@extends('layouts.app')

@section('header')
@endsection

@section('content')
<div class="container">
    <!-- Stats Cards Section -->
    <section class="mb-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-default">
                    <div class="card-header bg-blue-50 border-blue-200">
                        <h5 class="mb-0 text-blue-800">Pending Validations</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="display-4">{{ $pendingCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-default">
                    <div class="card-header bg-green-50 border-green-200">
                        <h5 class="mb-0 text-green-800">Approved Validations</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="display-4">{{ $approvedCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-default">
                    <div class="card-header bg-red-50 border-red-200">
                        <h5 class="mb-0 text-red-800">Rejected Validations</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="display-4">{{ $rejectedCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Validation Requests Section -->
    <section class="mb-5">
        <div class="section-header mb-3">
            <h4 class="section-title text-muted">Recent Validation Requests</h4>
        </div>

        <div class="card card-default">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Job Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($validations ?? [] as $validation)
                            <tr>
                                <td>{{ optional($validation->society)->name ?? 'N/A' }}</td>
                                <td>{{ optional($validation->jobCategory)->job_category ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{
                                        $validation->status == 'accepted' ? 'success' :
                                        ($validation->status == 'rejected' ? 'danger' : 'warning')
                                    }}">
                                        {{ ucfirst($validation->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Review</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No validation requests found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
