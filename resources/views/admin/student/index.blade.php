@extends('admin.layout.index')

@section('title')
    All Students
@endsection

@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">All Students</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.student.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filter by Center:</label>
                                <select name="center_id" id="center_filter" class="form-control select-search">
                                    <option value="">All Centers</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}" {{ $selectedCenter == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filter by Download Status:</label>
                                <select name="download_status" id="download_filter" class="form-control select-search">
                                    <option value="">All Status</option>
                                    <option value="1" {{ $selectedDownloadStatus == '1' ? 'selected' : '' }}>Downloaded</option>
                                    <option value="0" {{ $selectedDownloadStatus == '0' ? 'selected' : '' }}>Not Downloaded</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <br>
                <a href="{{ route('admin.student.create') }}" class="btn btn-info">
                    <i class="icon-plus-circle2 mr-2"></i>Add Student
                </a>
                <button type="button" id="exportBtn" class="btn btn-success">
                    <i class="icon-download4 mr-2"></i>Export CSV
                </button>
                <a href="{{ route('admin.student.import') }}" class="btn btn-primary">
                    <i class="icon-upload4 mr-2"></i>Import Students
                </a>
            </div>
        </div>

        <!-- Student Table -->
        <div class="table-responsive">
            <table class="table datatable-save-state">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Application ID</th>
                        <th>Candidate Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Skill</th>
                        <th>Team/Individual</th>
                        <th>Center</th>
                        <th>Download Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $key => $student)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $student->application_id ?? '-' }}</td>
                            <td>{{ $student->candidate_first_name }} {{ $student->candidate_last_name }}</td>
                            <td>{{ $student->email ?? '-' }}</td>
                            <td>{{ $student->candidate_mobile_number ?? '-' }}</td>
                            <td>{{ $student->gender ?? '-' }}</td>
                            <td>{{ $student->skill_name ?? '-' }}</td>
                            <td>{{ $student->team_individual ?? '-' }}</td>
                            <td>
                                @if ($student->center)
                                    {{ $student->center->name }}, {{ $student->center->address }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if ($student->is_download == 1)
                                    <span class="badge badge-success">Downloaded</span>
                                @else
                                    <span class="badge badge-danger">Not Downloaded</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-primary btn-sm">
                                    <i class="icon-pencil7"></i> Edit
                                </a>
                                <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Are you sure you want to delete this student?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="icon-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize select2 if available
        if ($.fn.select2) {
            $('#center_filter').select2({
                placeholder: 'Select Center (Optional)',
                allowClear: true
            });
            $('#download_filter').select2({
                placeholder: 'Select Status (Optional)',
                allowClear: true
            });
        }

        // Auto-submit form when filters change
        $('#center_filter, #download_filter').on('change', function() {
            $('#filterForm').submit();
        });

        // Export CSV
        $('#exportBtn').on('click', function() {
            var centerId = $('#center_filter').val();
            var exportUrl = '{{ route('admin.student.export.demo') }}';
            if (centerId) {
                exportUrl += '?center_id=' + centerId;
            }
            window.location.href = exportUrl;
        });
    });
</script>
@endsection
