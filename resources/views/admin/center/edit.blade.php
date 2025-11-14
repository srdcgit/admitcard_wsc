@extends('admin.layout.index')

@section('title')
    Edit Center
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Edit Center</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
            
                <form action="{{route('admin.center.update',$center->id)}}" method="post">
                @csrf
                @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <label>Center Name <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('name', $center->name)}}" placeholder="Enter center name" name="name" required>
                                <div class="form-control-feedback">
                                    <i class="icon-home4 text-muted"></i>
                                </div>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>District <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('district', $center->district)}}" placeholder="Enter district" name="district" required>
                                <div class="form-control-feedback">
                                    <i class="icon-map text-muted"></i>
                                </div>
                            </div>
                        </div>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="col-md-6">
                            <label>Contact Person <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('contact_person', $center->contact_person)}}" placeholder="Enter contact person name" name="contact_person" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>
                            @error('contact_person')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Contact Number <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input type="text" class="form-control" value="{{old('contact_number', $center->contact_number)}}" placeholder="Enter contact number" name="contact_number" required>
                                <div class="form-control-feedback">
                                    <i class="icon-phone text-muted"></i>
                                </div>
                            </div>
                            @error('contact_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <textarea class="form-control" rows="3" placeholder="Enter center address" name="address" required>{{old('address', $center->address)}}</textarea>
                                <div class="form-control-feedback">
                                    <i class="icon-location4 text-muted"></i>
                                </div>
                            </div>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{route('admin.center.index')}}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection

