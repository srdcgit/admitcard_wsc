<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $form->title }}</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-render.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<style>
		body { background:#f3f4f6; }
		.container { max-width: 860px; }
		.form-card {
			background: #fff;
			border: 1px solid #e5e7eb;
			border-radius: 12px;
			box-shadow: 0 10px 20px rgba(0,0,0,0.06);
			overflow: hidden;
		}
		.form-card__header {
			background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
			color: #fff;
			padding: 18px 22px;
		}
		.form-card__title {
			margin: 0;
			font-size: 22px;
			font-weight: 600;
			letter-spacing: .2px;
			text-transform: capitalize;
		}
		.form-card__body {
			padding: 22px;
		}
		.form-card__footer {
			padding: 16px 22px;
			background: #fafafa;
			border-top: 1px solid #e5e7eb;
			font-size: 13px;
			color: #6b7280;
		}
		.btn-submit {
			min-width: 160px;
			padding: 10px 16px;
			font-weight: 600;
		}
		/* Better spacing for rendered fields */
		#render-wrap .form-group, #render-wrap .form-check {
			margin-bottom: 14px;
		}
		#render-wrap label {
			font-weight: 500;
		}
	</style>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<div class="container py-4">
		<div class="form-card">
			<div class="form-card__header">
				<h1 class="form-card__title">{{ $form->title ?? 'Untitled Form' }}</h1>
			</div>
			<div class="form-card__body">
				@if(session('success'))
					<div class="alert alert-success mb-3">{{ session('success') }}</div>
				@endif
				<form id="public-form" method="POST" action="{{ route('form.public.submit', $form->slug) }}">
					@csrf
					<div id="render-wrap"></div>
					<div class="d-flex justify-content-end mt-3">
						<button type="submit" class="btn btn-primary btn-submit">Submit</button>
					</div>
				</form>
			</div>
			<div class="form-card__footer d-flex justify-content-between align-items-center">
				<span>Please review your details before submitting.</span>
				<span>{{ now()->format('M d, Y') }}</span>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-render.min.js"></script>
	<script>
		(function() {
			'use strict';
			const renderContainer = document.getElementById('render-wrap');
			const formData = @json($form->json_data);
			$(renderContainer).formRender({ formData });
		})();
	</script>
</body>
<!-- Keep indentation consistent with blade and HTML defaults -->
</html>


