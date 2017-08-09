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
									<li><a type="button" data-toggle="modal" data-target="#chairModal">Make Chair</a></li>
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

	<div class="modal fade" id="chairModal" tabindex="-1" role="dialog" aria-labelledby="chairModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">
					<form class="form">
						<label for="committees">Committees</label>
						<select id="committees">
							<option>Test1</option>
							<option>Test2</option>
							<option>Test3</option>
							<option>Test4</option>
							<option>Test5</option>
						</select>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
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
					{"bSearchable": false, "bSortable": false},
					{"bSearchable": true, "bSortable": true},
					{"bSearchable": true, "bSortable": true},
					{"bSearchable": true, "bSortable": true},
					{"bSearchable": false, "bSortable": true},
					{"bSearchable": false, "bSortable": false},
					{"bSearchable": true, "bSortable": false},
					{"bSearchable": false, "bSortable": false}
				]
			});

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
					{"bSearchable": false, "bSortable": false},
					{"bSearchable": true, "bSortable": true},
					{"bSearchable": true, "bSortable": true},
					{"bSearchable": true, "bSortable": true},
					{"bSearchable": false, "bSortable": true}
				]
			})
		});
	</script>
@endsection