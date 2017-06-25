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
				<th>Is Admin</th>
			</tr>
			</thead>
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