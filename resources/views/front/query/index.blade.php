<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>QUERY | ADMIT CARD SYSTEM </title>

	<!-- Global stylesheets -->
    <link rel="shortcut icon" type="image/png" href="{{asset('front/image/favicon.png')}}">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
    <link href="{{asset('user_asset/assets/css/toastr.css')}}" rel="stylesheet" type="text/css">

	<!-- Core JS files -->
	<script src="{{asset('user_asset/global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('user_asset/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script src="{{asset('user_asset/assets/js/app.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/demo_pages/login.js')}}"></script>
	<!-- /theme JS files -->

</head>

<body class="bg-slate-800">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login card -->
				<form class="login-form" method="POST" action="{{route('query.store')}}">
                    @csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<img src="{{asset("card-logo.png")}}" alt="">
								<h5 class="mb-0">Assistant Section Officer <br>Special Recruitment Drive-2023</h5>
								<span class="d-block text-muted">Send your query to us</span>
							</div>
                            <label><strong>Name</strong></label>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" name="name" class="form-control" placeholder="Enter Name" required>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>
                            <label><strong>Email Address</strong></label>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
								<div class="form-control-feedback">
									<i class="icon-mail5 text-muted"></i>
								</div>
							</div>
                            <label><strong>Phone Number</strong></label>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
								<div class="form-control-feedback">
									<i class="icon-phone text-muted"></i>
								</div>
							</div>
                            <label><strong>Subject</strong></label>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" name="subject" class="form-control" placeholder="Enter Query Subject" required>
								<div class="form-control-feedback">
									<i class="icon-diff-ignored text-muted"></i>
								</div>
							</div>
							<div class="form-group form-group-feedback form-group-feedback-left">
                                <label><strong>Message</strong></label>
                                <textarea name="message" class="form-control"></textarea>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Send <i class="icon-circle-right2 ml-2"></i></button>
							</div>
						</div>
					</div>
				</form>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
    <script src="{{asset('user_asset/assets/js/toastr.js')}}"></script>
	@toastr_render

</body>
</html>
