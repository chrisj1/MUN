@extends('dashboard.admin.admin_layout')

@section('stuff')
	<a href="/admin/groups" style="margin: 2%"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Return Back</a>
	<h1 class="h1 text-center text-primary">Group</h1>

	<div style="margin: 2%">
		<form method="POST" action="/dashboard/admin/group/{{$group->id}}/edit">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="name">Name</label>
				<input name="name" class="form-control" type="text" value="{{$group->group_name}}">
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<input name="description" class="form-control" type="text" value="{{$group->description}}">
			</div>

			<div class="form-group">
				<button class="btn btn-primary" type="submit">Edit Group</button>
			</div>
		</form>

		<h1 class="h1 text-center text-primary">Users</h1>
		<table class="table">
			<thead>
				<tr>
					<td>Name</td>
					<td>Email</td>
					<td>School</td>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>
							{{$user->name}}
						</td>
						<td>
							{{$user->email}}
						</td>
						<td>
							{{$user->school}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection