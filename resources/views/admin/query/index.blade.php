@extends('admin.layout.index')

@section('title')
    All Queries
@endsection

@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">All Queries</h5>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Send At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($queries  as $key => $query)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$query->name}} </td>
                        <td>{{@$query->email}}</td>
                        <td>{{@$query->phone}}</td>
                        <td>{{@$query->subject}}</td>
                        <td>{{@$query->message}}</td>
                        <td>{{@$query->created_at}}</td>
                        <td>
                            @if($query->is_solve)
                            <span class="badge badge-success">Solved</span>
                            @else 
                            <span class="badge badge-danger">Pending</span>
                            @endif
                        </td>
                        
                        <td>
                            @if($query->is_solve)
                            Already Solved
                            @else
                            <a href="{{route('admin.query.solved',$query->id)}}" class="btn btn-primary btn-sm">Mark Solved</a>
                            @endif
                        </td>
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
