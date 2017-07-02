@extends('dashboard.admin.admin_layout')

@section('stuff')
	<h1 class="h1 text-center text-primary">User Administration</h1>

	<h3 class="h3 text-center">Users</h3>

	<div style="margin: 5%">
		<table class="table" id="users">
			<thead>
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>School</th>
				<th>Email</th>
				<th>Created At</th>
				<th>Updated At</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{$user->id}}</td>
						<td>{{$user->name}}</td>
						<td>{{$user->school}}</td>
						<td>{{$user->email}}</td>
						<td>{{$user->created_at}}</td>
						<td>{{$user->updated_at}}</td>
						<td>{{$user->isAdmin() ? "Admin": "User"}}</td>
						<td>
							<div class="dropdown">
								<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
									Actions
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									@if(!$user->isAdmin())
										<li><a href="#">Make Administrator</a></li>
									@endif
									@if(!$user->isChair())
										<li><a href="#">Make Chair</a></li>
										@endif
									<li><a href="#">Delete</a></li>
								</ul>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<h3 class="h3 text-center">Admins</h3>

		<table class="table" id="admins">
			<thead>
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>Email</th>
				<th>Created At</th>
				<th>Updated At</th>
			</tr>
			</thead>
			<tbody>
			@foreach($users->filter(function ($value, $key) {
                return $value->isAdmin();
			}) as $user)
				<tr>
					<td>{{$user->id}}</td>
					<td>{{$user->name}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->created_at}}</td>
					<td>{{$user->updated_at}}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

	<script>
		$(document).ready(function () {
			$('#users').DataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"ordering": true,
				"pageLength": 30,

				"aoColumns": [
					{"bSearchable":false, "bSortable":false},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{ "bSearchable" : false, "bSortable" : true },
					{ "bSearchable" : false, "bSortable" : false },
					{ "bSearchable" : true, "bSortable" : false },
					{ "bSearchable" : false, "bSortable" : false }
				]
			})

			$('#admins').DataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"ordering": true,
				"pageLength": 30,

				"aoColumns": [
					{"bSearchable":false, "bSortable":false},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{ "bSearchable" : false, "bSortable" : true }
				]
			})
		});
	</script>
@endsection