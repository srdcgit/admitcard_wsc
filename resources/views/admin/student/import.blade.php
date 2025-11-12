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
                    <a href="{{route('admin.student.export.template')}}" class="btn btn-success btn-lg">
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
                            <label>Upload File <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    name="csv_file" 
                                    accept=".csv,.txt,.xlsx,.xls" 
                                    required
                                >
                                <div class="form-control-feedback">
                                    <i class="icon-file-excel text-muted"></i>
                                </div>
                                <span class="form-text text-muted">
                                    Maximum file size: <strong>10MB</strong>.  
                                    Accepted formats: <strong>CSV</strong>
                                </span>
                            </div>
                            @error('csv_file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="icon-warning22"></i> CSV Format Requirements:</h6>
                        <ul class="mb-0">
                            <li>
                                <strong>Download the official demo template</strong> first and fill it with your student data.  
                                <a href="{{ route('admin.student.export.template') }}" class="badge badge-info ml-1">Download Template</a>
                            </li>
                            <li>The <strong>first row</strong> must contain the column headers exactly as in the demo template.</li>
                            <li>Column names are <strong>case-insensitive</strong> and can include spaces or underscores (e.g. <code>Candidate First Name</code> or <code>candidate_first_name</code> are both valid).</li>
                            <li><strong>Required columns (in order):</strong>  
                                <ul>
                                    <li>application_id</li>
                                    <li>candidate_first_name</li>
                                    <li>candidate_last_name</li>
                                    <li>candidate_mobile_number</li>
                                    <li>dob</li>
                                    <li>email</li>
                                    <li>gender</li>
                                    <li>category</li>
                                    <li>skill_name</li>
                                    <li>team_individual</li>
                                    <li>current_state</li>
                                    <li>current_district</li>
                                </ul>
                            </li>
                            <li><strong>Date format for DOB:</strong> YYYY-MM-DD (e.g., 2000-01-15)</li>
                            <li>Accepted file formats: <strong>CSV</strong> (max 10MB)</li>
                            <li>⚠️ <strong>Tip:</strong> Always use the <em>exported demo template</em> to avoid structure errors and save as .CSV UTF-8 (Comma delimited).</li>
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

