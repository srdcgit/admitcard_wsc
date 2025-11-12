@extends('admin.layout.index')

@section('title', 'Add Exam Coordinator')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add Exam Coordinator</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.examcoordinator.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Center <span class="text-danger">*</span></label>
                            <select name="center_id" class="form-control" required>
                                <option value="">Select Center</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter full name" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email" required>
                        </div>

                        <div class="col-md-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Enter phone number" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>State</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state') }}" placeholder="Enter state">
                        </div>
                        <div class="col-md-6">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="Enter city">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>ZIP</label>
                            <input type="text" name="zip" class="form-control" value="{{ old('zip') }}" placeholder="Enter ZIP code">
                        </div>
                        <div class="col-md-6">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ route('admin.examcoordinator.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
