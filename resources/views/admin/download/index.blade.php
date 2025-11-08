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
                        <td>{{$download->student->application_id}}</td>
                        <td>{{$download->student->name}}</td>
                        <td>{{$download->student->email}}</td>
                        <td>{{$download->student->roll_number}}</td>
                        <td>{{$download->student->dob}}</td>
                        <td>{{$download->student->folder_number}}</td>
                        <td>{{$download->student->center_detail}}</td>
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
