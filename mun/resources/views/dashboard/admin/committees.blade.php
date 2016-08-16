@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="text-center h1">Committees</h1>
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
					{"orderable": true, "searchable": true},
					{"orderable": false, "searchable": false}
				]
			})
		});
	</script>

	<a href="/admin/addCommittee" class="btn btn-primary">Add Committee</a>

	<table class="table table-striped sortable" id="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Committee</th>
			<th>Chair</th>
			<th>Positions</th>
			<th>Assigned Positions</th>
			<th>Topic</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@foreach ($committees as $committee)
			<tr>
				<td>
					{{ $committee->id}}
				</td>
				<td>
					{{ $committee->committee }}
				</td>
				<td>
					{{ $committee->chair_name }}
				</td>
				<td>
					{{count(\App\position::all()->where('committee_id', $committee->id))}}
				</td>
				<td>
					{{count(\App\position::all()->where('committee_id', $committee->id))
					 - count(\App\position::all()->where('committee_id', $committee->id)->where('delegate', null))}}
				</td>
				<td>
					{{$committee->topic}}
				</td>
				<td class="action">
					<a href="/admin/committees/{{$committee->id}}/delete" class="confirmation btn btn-xs btn-danger">Delete</a>
					<a href="/admin/committees/{{$committee->id}}/edit" class="btn btn-xs btn-primary">Edit</a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>


	<script type="text/javascript">
		var elems = document.getElementsByClassName('confirmation');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to delete this committee?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>
@endsection