@extends('admin.layout.index')

@section('title')
    All Centers
@endsection

@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">All Centers</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="text-right mb-3">
            <a href="{{route('admin.center.create')}}" class="btn btn-primary">
                <i class="icon-plus-circle2 mr-2"></i>Add New Center
            </a>
        </div>
        <div class="table-responsive">
            <table class="table datatable-save-state">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($centers  as $key => $center)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$center->name}}</td>
                        <td>{{$center->address}}</td>
                        <td>{{$center->contact_person}}</td>
                        <td>{{$center->contact_number}}</td>
                        <td>
                            <a href="{{route('admin.center.edit',$center->id)}}" class="btn btn-primary btn-sm">
                                <i class="icon-pencil7"></i> Edit
                            </a>
                            <form action="{{route('admin.center.destroy',$center->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this center?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i> Delete
                                </button>
                            </form>
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

