@extends('admin.layout.index')

@section('title', 'Edit Exam Coordinator')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Edit Exam Coordinator</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.examcoordinator.update', $coordinator->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <label>Center <span class="text-danger">*</span></label>
                            <select name="center_id" class="form-control" required>
                                <option value="">Select Center</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}" {{ $coordinator->center_id == $center->id ? 'selected' : '' }}>
                                        {{ $center->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('center_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $coordinator->name) }}" class="form-control" placeholder="Enter full name" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $coordinator->email) }}" class="form-control" placeholder="Enter email" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $coordinator->phone) }}" class="form-control" placeholder="Enter phone number" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>State</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state', $coordinator->state) }}" placeholder="Enter state">
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $coordinator->city) }}" placeholder="Enter city">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>ZIP</label>
                            <input type="text" name="zip" class="form-control" value="{{ old('zip', $coordinator->zip) }}" placeholder="Enter ZIP code">
                            @error('zip')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep old password">
                            <small class="text-muted">Leave blank if you don’t want to change it</small>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Enter address">{{ old('address', $coordinator->address) }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $coordinator->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$coordinator->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ route('admin.examcoordinator.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
