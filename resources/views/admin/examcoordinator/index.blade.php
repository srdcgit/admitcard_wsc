@extends('admin.layout.index')
@section('title', 'Exam Coordinators')
@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Exam Coordinators</h5>
        <div class="header-elements">
            <a href="{{ route('admin.examcoordinator.create') }}" class="btn btn-primary btn-sm">Add New</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Center</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coordinators as $key => $coordinator)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $coordinator->center->name ?? '-' }}</td>
                        <td>{{ $coordinator->name }}</td>
                        <td>{{ $coordinator->email }}</td>
                        <td>{{ $coordinator->phone }}</td>
                        <td>{{ $coordinator->city }}</td>
                        <td>{!! $coordinator->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.examcoordinator.edit', $coordinator->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('admin.examcoordinator.destroy', $coordinator->id) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
