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
					{ "orderable": false, "searchable" : false },
					{ "orderable": true, "searchable": true},
					{ "orderable": true, "searchable": true},
					{ "orderable": true, "searchable": true},
					{ "orderable": true, "searchable": true},
					{ "orderable": false, "searchable": false}
				]
			})
		});
	</script>


	<div class="row">
		<a class="btn btn-primary" href="/admin/addAPosition">Add a position</a>
		<a class="btn btn-primary" href="/admin/addPositions">Add Positions</a>
	</div>
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
					{{ $committees->get($position->committee_id-1)->committee }}
				</td>
				<td>
					{{ $position->name }}
				</td>
				<td>
					{{ $delegates->get($position->delegate) != null ? $delegates->get($position->delegate-1)->firstname . ' ' .$delegates->get($position->delegate-1)->lastname : "not assigned"}}
				</td>
				<td>
					{{$delegates->get($position->delegate) != null ? $users->get($delegates->get($position->delegate-1)->user_id-1)->school : "not assigned"}}
				</td>
				<td class="action">
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

@endsection