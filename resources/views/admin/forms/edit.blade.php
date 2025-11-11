@extends('admin.layout.index')

@section('title')
	Edit Form
@endsection

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-builder.min.css">
@endsection

@section('content')
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Edit: {{ $form->title }}</h5>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label for="formTitle">Form Title</label>
			<input type="text" id="formTitle" class="form-control" value="{{ $form->title }}">
		</div>
		<div id="fb-editor"></div>
		<div class="mt-3">
			<button id="updateFormBtn" class="btn btn-primary">Update Form</button>
			<a href="{{ route('admin.forms.index') }}" class="btn btn-light ml-2">Cancel</a>
			<span id="saveStatus" class="ml-2 text-success" style="display:none;">Updated</span>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-builder.min.js"></script>
	<script>
		(function() {
			'use strict';
			const editor = document.getElementById('fb-editor');
			const existing = {!! json_encode($form->json_data) !!};
			const formBuilder = $(editor).formBuilder({
				formData: existing,
				disableFields: ['file'],
				disabledActionButtons: ['data','save'] // hide [{..}] JSON and built-in Save
			});

			const updateBtn = document.getElementById('updateFormBtn');
			const titleInput = document.getElementById('formTitle');
			const saveStatus = document.getElementById('saveStatus');

			updateBtn.addEventListener('click', async function() {
				const title = titleInput.value && titleInput.value.trim() ? titleInput.value.trim() : 'Untitled Form';
				const jsonData = formBuilder.actions.getData('json');
				updateBtn.disabled = true;
				saveStatus.style.display = 'none';

				try {
					const res = await fetch('{{ route('admin.form.update', $form->id) }}', {
						method: 'PUT',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': '{{ csrf_token() }}',
							'Accept': 'application/json'
						},
						body: JSON.stringify({ title: title, form_data: jsonData }),
						credentials: 'same-origin'
					});
					const payload = await res.json().catch(() => ({}));
					if (!res.ok) throw new Error('Failed');
					saveStatus.style.display = 'inline';
					setTimeout(() => { saveStatus.style.display = 'none'; }, 2000);
				} catch (e) {
					alert('Failed to update form.');
				} finally {
					updateBtn.disabled = false;
				}
			});
		})();
	</script>
@endsection


