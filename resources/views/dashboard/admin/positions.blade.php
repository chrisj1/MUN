@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="text-center h1">Positions</h1>
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
					{"orderable": false, "searchable": false},
					{"orderable": true, "searchable": true},
					{"orderable": true, "searchable": true},
					{"orderable": true, "searchable": true},
					{"orderable": true, "searchable": true},
					{"orderable": false, "searchable": false}
				]
			})
		});
	</script>


	<div style="margin: 5%">
		<div class="row">
			<a style="margin: 0.3%" class="btn btn-primary" href="/admin/addAPosition">Add Single Position</a>
			<a style="margin: 0.3%" class="btn btn-primary" href="/admin/addPositions">Add Multiple Positions</a>
		</div>
		<div class="row">
			<a style="margin: 0.3%" class="btn btn-primary" href="/admin/assignPositions">Assign Positions</a>
		</div>
	</div>
	<div style="margin-left: 5%; margin-right: 5%">
		<table class="table table-striped sortable" id="table">
			<thead>
			<tr>
				<th>#</th>
				<th>Committee</th>
				<th>Country/Name/ect.</th>
				<th>Delegate</th>
				<th>Delegation</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@foreach ($positions as $position)
				<tr>
					<td>
						{{ ++$count}}
					</td>
					<td>
						{{ \App\Committee::find($position->committee_id)->committee }}
					</td>
					<td>
						{{ $position->name }}
					</td>
					<td>
						{{ $delegates->get($position->delegate) != null ? $delegates->get($position->delegate-1)->firstname . ' ' .$delegates->get($position->delegate-1)->lastname : "not assigned"}}
					</td>
					<td>
						{{ $position->user_id != null ? \App\User::find($position->user_id)->school : "not assigned"}}
					</td>
					<td class="action">
						<a class="btn btn-danger btn-xs confirm" href="/dashboard/admin/position/{{$position->id}}/delete">Delete</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@endsection