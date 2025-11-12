@extends('admin.layout.index')

@section('title')
    Edit Student
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Edit Student</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.student.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <label>Application ID</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="application_id" class="form-control" value="{{ old('application_id', $student->application_id) }}" placeholder="Enter application ID">
                                <div class="form-control-feedback">
                                    <i class="icon-barcode2 text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Center <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <select name="center_detail" class="form-control select-search" required>
                                    <option value="">Select Center</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}" {{ old('center_detail', $student->center_detail) == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }} - {{ $center->address }}
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

                    <div class="row">
                        <div class="col-md-6">
                            <label>First Name <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="candidate_first_name" class="form-control" value="{{ old('candidate_first_name', $student->candidate_first_name) }}" placeholder="Enter first name" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                            @error('candidate_first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="candidate_last_name" class="form-control" value="{{ old('candidate_last_name', $student->candidate_last_name) }}" placeholder="Enter last name" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                            @error('candidate_last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Mobile Number <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="candidate_mobile_number" class="form-control" value="{{ old('candidate_mobile_number', $student->candidate_mobile_number) }}" placeholder="Enter mobile number" required>
                                <div class="form-control-feedback">
                                    <i class="icon-phone text-muted"></i>
                                </div>
                            </div>
                            @error('candidate_mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Email</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" placeholder="Enter email address">
                                <div class="form-control-feedback">
                                    <i class="icon-mail5 text-muted"></i>
                                </div>
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Date of Birth</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}" placeholder="Enter date of birth">
                                <div class="form-control-feedback">
                                    <i class="icon-calendar text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Gender</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <select name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div class="form-control-feedback">
                                    <i class="icon-users text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Category</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="category" class="form-control" value="{{ old('category', $student->category) }}" placeholder="Enter category (e.g., SC/ST/OBC)">
                                <div class="form-control-feedback">
                                    <i class="icon-info22 text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Skill Name</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="skill_name" class="form-control" value="{{ old('skill_name', $student->skill_name) }}" placeholder="Enter skill name">
                                <div class="form-control-feedback">
                                    <i class="icon-graduation2 text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Team / Individual</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <select name="team_individual" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Team" {{ old('team_individual', $student->team_individual) == 'Team' ? 'selected' : '' }}>Team</option>
                                    <option value="Individual" {{ old('team_individual', $student->team_individual) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                </select>
                                <div class="form-control-feedback">
                                    <i class="icon-users4 text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Current State</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="current_state" class="form-control" value="{{ old('current_state', $student->current_state) }}" placeholder="Enter current state">
                                <div class="form-control-feedback">
                                    <i class="icon-map text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Current District</label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" name="current_district" class="form-control" value="{{ old('current_district', $student->current_district) }}" placeholder="Enter current district">
                                <div class="form-control-feedback">
                                    <i class="icon-location4 text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('admin.student.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
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
