@extends('admin.layout.index')

@section('title')
	Form Submissions
@endsection

@section('content')
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Submissions: {{ $form->title }}</h5>
		<div class="header-elements">
			<a href="{{ route('admin.forms.index') }}" class="btn btn-light">Back to Forms</a>
			<a href="{{ route('form.public.show', $form->slug) }}" target="_blank" class="btn btn-primary ml-2">Open Public Form</a>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Submitted At</th>
						<th>Data</th>
					</tr>
				</thead>
				<tbody>
				@forelse($submissions as $key => $s)
					<tr>
						<td>{{ $key + 1 }}</td>
						<td>{{ $s->created_at?->format('Y-m-d H:i') }}</td>
						<td>
							@if(is_array($s->submission_data))
								<table class="table table-sm mb-0">
									@foreach($s->submission_data as $key => $value)
										<tr>
											<th style="width:220px;text-transform:capitalize">{{ str_replace('_',' ', $key) }}</th>
											<td>
												@if(is_array($value))
													{{ implode(', ', $value) }}
												@else
													{{ $value }}
												@endif
											</td>
										</tr>
									@endforeach
								</table>
							@else
								<pre class="mb-0" style="white-space:pre-wrap">{{ $s->submission_data }}</pre>
							@endif
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="3" class="text-center">No submissions yet.</td>
					</tr>
				@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection


