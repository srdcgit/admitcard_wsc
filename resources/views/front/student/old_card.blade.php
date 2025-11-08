<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admit Card | Admit Card System</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('user_asset/assets/css/toastr.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('user_asset/global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('user_asset/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>

	<script src="{{asset('user_asset/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/demo_pages/form_select2.js')}}"></script>

	<script src="{{asset('user_asset/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('user_asset/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    
	<script src="{{asset('user_asset/global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>

	<script src="{{asset('user_asset/assets/js/app.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/demo_pages/datatables_basic.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/demo_pages/form_layouts.js')}}"></script>
	<script src="{{asset('user_asset/global_assets/js/demo_pages/dashboard.js')}}"></script>
	<!-- /theme JS files -->
	
	<!-- Theme JS files -->

	<script src="{{asset('user_asset/global_assets/js/demo_pages/job_list.js')}}"></script>
	<!-- /theme JS files -->
    <style>
        .bordered-card {
            border: 10px;
            border-style: double;
        }
        .border-single {
            border: 2px;
            border-style: solid;
        }
        .border-rounded {
            border: 3px;
            border-style: dotted;
        }
    </style>
</head>

<body>
	<!-- Page content -->
	<div class="page-content">


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body bordered-card">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{asset("card-logo.png")}}" alt="">
                                    </div>
                                    <div class="col-5">
                                        <h1 class="text-center" style="font-size:20px"><strong>THE HIGH COURT OF ORISSA: CUTTACK</strong></h1>
                                        <br>
                                        <h2 class="text-center" ><strong>ADMIT CARD</strong> </h2> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="text-center">Admission to the Preliminary Examination for the Post of Assistant Section Officer
                                            (Special Recruitment Drive), 2023</h1>
                                    </div>
                                     <div class="col-md-7" style="margin:auto">
                                        <h2>Date of Examination :<strong>24th December 2023</strong> </h2>
                                        <h2>Time of Examination : <strong>10.00 A.M. to 12.00 NOON</strong></h2>
                                        <h2>Reporting Time      : <strong> 09.00 A.M.</strong></h2>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-7 ml-4" style="margin-top:30px">
                                                <h2>Roll No.         : <strong>{{$student->application_id}}</strong></h2>
                                                <h2>Candidate’s Name : <strong>{{$student->name}}</strong></h2>
                                                <h2>Date of Birth    : <strong>{{Carbon\Carbon::parse($student->dob)->format('M d , Y')}}</strong></h2>
                                                <h2>Parent/Guardian Name    : <strong>{{$student->father_name}}</strong></h2>
                                            </div>
                                            <div class="col-4 text-right">
                                                <img src="{{asset('uploaded_files/'.$student->folder_number.'/passportphoto.jpg')}}" height="150" width="150" alt="">
                                                <br>
                                                <br>
                                                <img src="{{asset('uploaded_files/'.$student->folder_number.'/signature.jpg')}}" height="80" width="200" alt="">
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 border-rounded">
                                        <h2 class="text-center"><strong><u>VENUE</u></strong></h2>
                                        <h2 class="text-center"><strong>{{$student->center_detail}}</strong></h2>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-6 " style="margin-top:90px;">
                                        <h2><strong>Signature of the Candidate </strong></h2>
                                    </div>
                                    <div class="col-md-6 text-right"style="margin-top:30px;">
                                        <img src="{{asset('sign.png')}}" height="80" width="230" alt="">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-12 ">
                                        <h2 class="text-center"><strong><u>Instructions to the Candidate                                        </u></strong></h2>
                                    </div>
                                    <div class="col-md-12">
                                        <h5>
                                            1. Please bring this card along with original Aadhaar Card to secure admission to the Examination Centre.
                                        </h5>
                                        <h5>
                                            2. Candidate will not be permitted to enter the venue 15 minutes after the commencement of the Test.
                                        </h5>
                                        <h5>
                                            3. Candidate shall not be allowed to leave the Examination Hall before completion of One hour of the Test.
                                        </h5>
                                        <h5>
                                            4. Use only Black/Blue Pen/ Ball Point Pen.
                                        </h5>
                                        <h5>
                                            5. Possession of Electronic device in any form is strictly prohibited in the Examination Hall.
                                        </h5>
                                        <h5>
                                            6. Use of any unfair means by the candidate shall result in the cancellation of his/her candidature.
                                        </h5>
                                        <h5>
                                            7. Impersonation is an offence. A Candidate found to be involved in impersonation, apart from disqualification, shall be
                                            liable to be prosecuted.
                                        </h5>
                                        <h5>
                                            8. <strong><u>The Candidates are required to fill-up & carefully darken Roll no. and Test Booklet Series in the Answer sheet at the
                                                appropriate places & Answer Sheet Serial no. in the attendance sheets otherwise the answer sheet is liable for
                                                rejection.</u></strong>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </div>
                </div>

			</div>
			<!-- /content area -->



		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<script src="{{asset('user_asset/assets/js/toastr.js')}}"></script>
    <script>
        window.print();
    </script>
</body>
</html>
