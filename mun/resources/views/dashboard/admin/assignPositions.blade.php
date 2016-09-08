@extends('dashboard.admin.admin_layout')

@section('stuff')
	<h1 class="text-center">Select Delegation</h1>

	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"ordering": true,
				"pageLength": 15,

				"columns": [
					{"orderable": true, "searchable": true},
					{"orderable": true, "searchable": true},
					{"orderable": true, "searchable": true},
					{"orderable": false, "searchable": false}
				]
			})
		});
	</script>

	<table class="table table-striped sortable" id="table">
		<thead>
			<tr>
				<th>School</th>
				<th>Requested</th>
				<th>Assigned</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr class="">
					<td>{{$user->school}}</td>
					<td>{{count($delegates->where('user_id', $user->id))}}</td>
					<td>{{count($positions->where('user_id', $user->id))}}</td>
					<td><a class="btn btn-success btn-xs" href="/admin/{{$user->id}}/assign">Assign</a> </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection