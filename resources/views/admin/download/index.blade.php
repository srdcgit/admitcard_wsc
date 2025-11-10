@extends('admin.layout.index')

@section('title')
    All Downloads
@endsection

@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">All Downloads</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-save-state">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Application ID#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role Number</th>
                        <th>DOB</th>
                        <th>Folder Number</th>
                        <th>Center</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($downloads  as $key => $download)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$download->student->application_id ?? 'NULL'}}</td>
                        <td>{{$download->student->name ?? 'NULL'}}</td>
                        <td>{{$download->student->email ?? 'NULL'}}</td>
                        <td>{{$download->student->roll_number ?? 'NULL'}}</td>
                        <td>{{$download->student->dob ?? 'NULL'}}</td>
                        <td>{{$download->student->folder_number ?? 'NULL'}}</td>
                        <td>{{$download->student->center_detail ?? 'NULL'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
    
        </div>

    </div>
</div>
@endsection
@section('scripts')
@endsection
