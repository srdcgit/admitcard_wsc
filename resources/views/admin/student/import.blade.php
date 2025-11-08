@extends('admin.layout.index')

@section('title')
    Import Students
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Import Students from CSV</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="icon-info22"></i> Instructions:</h6>
                    <ul class="mb-0">
                        <li>First, download the demo CSV template to see the required column structure.</li>
                        <li>Fill in your student data following the template format.</li>
                        <li>Select a center from the dropdown below.</li>
                        <li>Upload your CSV file to import all students to the selected center.</li>
                    </ul>
                </div>

                <div class="text-center mb-4">
                    <a href="{{route('admin.student.export.demo')}}" class="btn btn-success btn-lg">
                        <i class="icon-download4 mr-2"></i>Download Demo CSV Template
                    </a>
                </div>

                <form action="{{route('admin.student.import.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Select Center <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <select name="center_id" class="form-control select-search" required>
                                    <option value="">Select Center</option>
                                    @foreach($centers as $center)
                                    <option value="{{$center->id}}" {{old('center_id') == $center->id ? 'selected' : ''}}>
                                        {{$center->name}} - {{$center->address}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-control-feedback">
                                    <i class="icon-home4 text-muted"></i>
                                </div>
                            </div>
                            @error('center_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Upload CSV File <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="file" class="form-control" name="csv_file" accept=".csv,.txt" required>
                                <div class="form-control-feedback">
                                    <i class="icon-file-text2 text-muted"></i>
                                </div>
                                <span class="form-text text-muted">Maximum file size: 10MB. Accepted formats: CSV, TXT</span>
                            </div>
                            @error('csv_file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="icon-warning22"></i> CSV Format Requirements:</h6>
                        <ul class="mb-0">
                            <li>First row must contain column headers (name, application_id, father_name, etc.)</li>
                            <li>Column names are case-insensitive and can have spaces or underscores</li>
                            <li>Required column: <strong>name</strong></li>
                            <li>Optional columns: application_id, father_name, mother_name, dob_pass, dob, gender, phone, email, app_number, physically_challanged_category, folder_number, roll_number</li>
                            <li>Date format for DOB: YYYY-MM-DD (e.g., 2000-01-15)</li>
                        </ul>
                    </div>

                    <div class="text-right">
                        <a href="{{route('admin.student.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-upload4 mr-2"></i>Import Students
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // Initialize select2 if available
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('.select-search').select2();
    }
</script>
@endsection

