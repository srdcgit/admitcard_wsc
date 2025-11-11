@extends('admin.layout.index')

@section('title')
	Form Preview
@endsection

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-render.min.css">
@endsection

@section('content')
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">{{ $form->title }}</h5>
	</div>
	<div class="card-body">
		<form id="dynamic-form">
			<div id="render-wrap"></div>
			<div class="mt-3">
				<button type="submit" class="btn btn-success">Submit Response</button>
				<span id="submitStatus" class="ml-2 text-success" style="display:none;">Submitted</span>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-render.min.js"></script>
	<script>
		(function() {
			'use strict';
			const renderContainer = document.getElementById('render-wrap');
			const formData = @json($form->json_data);
			$(renderContainer).formRender({
				formData: formData
			});

			const formEl = document.getElementById('dynamic-form');
			const submitStatus = document.getElementById('submitStatus');

			function toObject(formArray) {
				const obj = {};
				formArray.forEach(({ name, value }) => {
					if (obj[name] !== undefined) {
						if (!Array.isArray(obj[name])) obj[name] = [obj[name]];
						obj[name].push(value);
					} else {
						obj[name] = value;
					}
				});
				return obj;
			}

			formEl.addEventListener('submit', async function(e) {
				e.preventDefault();
				const arr = $(formEl).serializeArray();
				const payload = toObject(arr);
				submitStatus.style.display = 'none';

				try {
					const res = await fetch('{{ route('admin.form.submit', $form->id) }}', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': '{{ csrf_token() }}',
							'Accept': 'application/json'
						},
						body: JSON.stringify(payload),
						credentials: 'same-origin'
					});
					const data = await res.json();
					if (data && data.success) {
						submitStatus.style.display = 'inline';
						formEl.reset();
						setTimeout(() => { submitStatus.style.display = 'none'; }, 2500);
					} else {
						alert('Failed to submit.');
					}
				} catch (err) {
					alert('Error submitting form.');
				}
			});
		})();
	</script>
@endsection


