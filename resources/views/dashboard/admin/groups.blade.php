@extends('dashboard.admin.admin_layout')

@section('stuff')
	<h1 class="h1 text-center text-primary">Groups</h1>
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": true,
				"ordering": true,
				"pageLength": 15,

				"columns": [
					{"orderable": true, "searchable": true},
					{"orderable": true, "searchable": true},
					{"orderable": false, "searchable": false}
				]
			})
		});
	</script>

	<div style="padding: 2%">
		<table class="table table-striped sortable table-responsive" id="table">
			<thead>
			<tr>
				<td>Name</td>
				<td>Description</td>
				<td></td>
			</tr>
			</thead>
			<tbody>
			@foreach($groups as $group)
				<tr>
					<td>{{$group->group_name}}</td>
					<td>{{$group->description}}</td>
					<td><a href="/dashboard/admin/group/{{$group->id}}" class="btn btn-xs btn-primary">View</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

@endsection