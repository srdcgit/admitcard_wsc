

<!-- Global stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('user_asset/assets/css/toastr.css')}}" rel="stylesheet" type="text/css">
<style>
    .form-wrapper{
        max-width: 850px;
        margin: auto;
    }
    .form-label{
        font-weight: 600;
    }
    .card{
        border-radius: 12px;
    }
    .card-header{
        border-radius: 12px 12px 0 0;
    }
    .btn-primary{
        padding: 10px 25px;
        font-size: 16px;
        border-radius: 8px;
    }
</style>

<div class="container mt-5 form-wrapper">

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-center">Exam Coordinator Registration</h4>
        </div>

        <div class="card-body p-4">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('examcoordinator.public.store') }}" method="POST">
                @csrf

                <h5 class="mb-3 text-primary font-weight-bold">Personal Details</h5>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Center <span class="text-danger">*</span></label>
                        <select name="center_id" class="form-control" required>
                            <option value="">Select Center</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('center_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                </div>

                <h5 class="mt-4 mb-3 text-primary font-weight-bold">Address Details</h5>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                        @error('state') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                        @error('city') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                        <input type="text" name="zip" class="form-control" value="{{ old('zip') }}" required>
                        @error('zip') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                </div>

                <h5 class="mt-4 mb-3 text-primary font-weight-bold">Security</h5>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        Submit Application <i class="icon-paperplane ml-2"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

