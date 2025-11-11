@extends('admin.layout.index')

@section('title')
	Form Builder
@endsection

@section('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-builder.min.css">
	<style>
		.builder-actions { margin-top: 15px; }
	</style>
@endsection

@section('content')
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Drag & Drop Form Builder</h5>
	</div>
	<div class="card-body">
		<div class="form-group">
			<label for="formTitle">Form Title</label>
			<input type="text" id="formTitle" class="form-control" placeholder="Enter form title">
		</div>
		<div id="fb-editor"></div>
		<div class="builder-actions">
			<button id="saveFormBtn" class="btn btn-primary">Save Form</button>
			<span id="saveStatus" class="ml-2 text-success" style="display:none;">Saved</span>
		</div>
	</div>
	<div class="card-footer">
		<p class="mb-0">Use the panel to the right to drag fields into the canvas.</p>
	</div>
	<input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
</div>
@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/formBuilder/dist/form-builder.min.js"></script>
	<script>
		(function() {
			'use strict';

			const editor = document.getElementById('fb-editor');
			const options = {
				disableFields: ['file'],
				disabledActionButtons: ['data'],
			};
			const formBuilder = $(editor).formBuilder(options);

			const saveButton = document.getElementById('saveFormBtn');
			const titleInput = document.getElementById('formTitle');
			const saveStatus = document.getElementById('saveStatus');

			function postJson(url, data) {
				return fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': document.getElementById('csrfToken').value,
						'Accept': 'application/json'
					},
					body: JSON.stringify(data),
					credentials: 'same-origin'
				});
			}

			saveButton.addEventListener('click', async function() {
				const title = titleInput.value && titleInput.value.trim() ? titleInput.value.trim() : 'Untitled Form';
				const jsonData = formBuilder.actions.getData('json');
				saveButton.disabled = true;
				saveStatus.style.display = 'none';

				try {
					const res = await postJson('{{ route('admin.form.save') }}', {
						title: title,
						form_data: jsonData
					});
					const payload = await res.json();
					if (payload && payload.success) {
						saveStatus.style.display = 'inline';
						if (payload.public_url) {
							alert('Form saved! Public URL: ' + payload.public_url);
						}
					} else {
						alert('Failed to save form.');
					}
				} catch (e) {
					alert('Error saving form.');
				} finally {
					saveButton.disabled = false;
					setTimeout(() => { saveStatus.style.display = 'none'; }, 2000);
				}
			});
		})();
	</script>
@endsection


