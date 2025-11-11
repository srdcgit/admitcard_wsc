@extends('admin.layout.index')

@section('title')
	Forms
@endsection

@section('content')
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">All Forms</h5>
		<div class="header-elements">
			<a href="{{ route('admin.form.builder') }}" class="btn btn-primary">Create New Form</a>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Status</th>
						<th>Public URL</th>
						<th>Created</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@forelse($forms as $key => $form)
					<tr>
						<td>{{ $key + 1 }}</td>
						<td>{{ $form->title }}</td>
						<td>
							<span class="badge {{ $form->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $form->is_active ? 'Active' : 'Inactive' }}</span>
						</td>
						<td>
							<a href="{{ route('form.public.show', $form->slug) }}" target="_blank">{{ route('form.public.show', $form->slug) }}</a>
						</td>
						<td>{{ $form->created_at?->format('Y-m-d H:i') }}</td>
						<td>
							<a href="{{ route('admin.form.show', $form->id) }}" class="btn btn-sm btn-info">Preview</a>
							<a href="{{ route('admin.form.submissions', $form->id) }}" class="btn btn-sm btn-secondary">Submissions</a>
							<a href="{{ route('admin.form.edit', $form->id) }}" class="btn btn-sm btn-primary">Edit</a>
							<form action="{{ route('admin.form.toggle', $form->id) }}" method="POST" style="display:inline;">
								@csrf
								<button type="submit" class="btn btn-sm {{ $form->is_active ? 'btn-warning' : 'btn-success' }}">
									{{ $form->is_active ? 'Deactivate' : 'Activate' }}
								</button>
							</form>
							<form action="{{ route('admin.form.destroy', $form->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this form? This cannot be undone.');">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-sm btn-danger">Delete</button>
							</form>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center">No forms found.</td>
					</tr>
				@endforelse
				</tbody>
			</table>
		</div>
	</div>
	
@endsection


