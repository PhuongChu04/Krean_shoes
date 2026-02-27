@extends('admin.layouts.admin')

@section('content')
<h3>Category List</h3>
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
<table class="table">
<tr>
<th>Name</th>
<th>Parent</th>
<th>Image</th>
<th>Action</th>
</tr>
@foreach($categories as $cat)
<tr>
<td>{{ $cat->name }}</td>
<td>{{ $cat->parent->name ?? '-' }}</td>
<td>@if($cat->image)<img src="{{ asset('storage/'.$cat->image) }}" width="60">@endif</td>
<td>
<a href="{{ route('admin.categories.edit',$cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('admin.categories.destroy',$cat->id) }}" method="POST" style="display:inline">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>
@endsection
