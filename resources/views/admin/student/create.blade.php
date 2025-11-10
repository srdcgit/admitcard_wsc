@extends('admin.layout.index')

@section('title')
    Add New Student
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Student</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
            
                <form action="{{route('admin.student.store')}}" method="post">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('name')}}" placeholder="Enter student name" name="name" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Application ID</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('application_id')}}" placeholder="Enter application ID" name="application_id">
                                <div class="form-control-feedback">
                                    <i class="icon-barcode2 text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Father Name</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('father_name')}}" placeholder="Enter father name" name="father_name">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Mother Name</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('mother_name')}}" placeholder="Enter mother name" name="mother_name">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>DOB Pass</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('dob_pass')}}" placeholder="Enter DOB as per passport" name="dob_pass">
                                <div class="form-control-feedback">
                                    <i class="icon-calendar text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Date of Birth</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="date" class="form-control" value="{{old('dob')}}" name="dob">
                                <div class="form-control-feedback">
                                    <i class="icon-calendar text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Gender</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <select name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="M" {{old('gender') == 'M' ? 'selected' : ''}}>Male</option>
                                    <option value="F" {{old('gender') == 'F' ? 'selected' : ''}}>Female</option>
                                    <option value="Other" {{old('gender') == 'Other' ? 'selected' : ''}}>Other</option>
                                </select>
                                <div class="form-control-feedback">
                                    <i class="icon-users text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('phone')}}" placeholder="Enter phone number" name="phone">
                                <div class="form-control-feedback">
                                    <i class="icon-phone text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Email</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="email" class="form-control" value="{{old('email')}}" placeholder="Enter email address" name="email">
                                <div class="form-control-feedback">
                                    <i class="icon-mail5 text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>App Number</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('app_number')}}" placeholder="Enter application number" name="app_number">
                                <div class="form-control-feedback">
                                    <i class="icon-barcode2 text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Physically Challenged Category</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('physically_challanged_category')}}" placeholder="Enter category" name="physically_challanged_category">
                                <div class="form-control-feedback">
                                    <i class="icon-info22 text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Roll Number</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('roll_number')}}" placeholder="Enter roll number" name="roll_number">
                                <div class="form-control-feedback">
                                    <i class="icon-barcode2 text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Center <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <select name="center_detail" class="form-control select-search" required>
                                    <option value="">Select Center</option>
                                    @foreach($centers as $center)
                                    <option value="{{$center->id}}" {{old('center_detail') == $center->id ? 'selected' : ''}}>
                                        {{$center->name}} - {{$center->address}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-control-feedback">
                                    <i class="icon-home4 text-muted"></i>
                                </div>
                            </div>
                            @error('center_detail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{route('admin.student.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
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

