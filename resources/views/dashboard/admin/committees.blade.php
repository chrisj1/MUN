@extends('dashboard.admin.admin_layout')

@section('stuff')

	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	<h1 class="text-center h1">Committees</h1>
	<br>
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
					{"orderable": false, "searchable": false},
					{"orderable": false, "searchable": false},
					{"orderable": false, "searchable": false}
				]
			})
		});
	</script>
	<div style="margin-right: 5%; margin-left: 5%">
	<a style="width: 150px" href="/admin/addCommittee" class="btn btn-primary">Add Committee</a>

		<input data-offstyle="danger" style="align-content: right" id="toggle-event" data-width="200" checked type="checkbox" data-toggle="toggle"
		       data-on="Showing Clones" data-off="Not Showing Clones">

		<table class="table table-striped sortable" id="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Committee</th>
			<th>Topic</th>
			<th>Chair</th>
			<th>Positions</th>
			<th>Assigned Positions</th>
			<th>Clone of</th>
			<th>Middle or High School</th>
			<th style="width: 15%"></th>
		</tr>
		</thead>
		<tbody>
		@foreach ($committees as $committee)
			<tr class="{{$committee->clone_of == null ? "" : "hidethis"}}">
				<td>
					{{ $committee->id}}
				</td>
				<td>
					{{ $committee->full_name }}
				</td>
				<td>
					{{$committee->topic}}
				</td>
				<td>
					{{ $committee->chair_name }}
				</td>
				<td>
					{{count(\App\Position::all()->where('committee_id', $committee->id))}}
				</td>
				<td>
					{{count(\App\Position::all()->where('committee_id', $committee->id))
					 - count(\App\Position::all()->where('committee_id', $committee->id)->where('delegate', null))}}
				</td>
				<td>
					{{$committee->clone_of == null ? "" : $committee->find($committee->clone_of)->full_name . " - " . $committee->find($committee->clone_of)->topic}}
				</td>
				<td>
					{{$committee->high_school ? "High School": "Middle School"}}
				</td>
				<td class="action">
					<a href="/admin/committees/{{$committee->id}}/delete" class="confirmation btn btn-xs btn-danger">Delete</a>
					<a href="/admin/committees/{{$committee->id}}/edit" class="btn btn-xs btn-primary">Edit</a>
					@if($committee->clone_of == null)
						<a href="/admin/committees/{{$committee->id}}/clone" class="btn btn-xs btn-success confirmation2">Clone</a>
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
		var elems = document.getElementsByClassName('confirmation');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to delete this committee?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>

	<script>
		var hidden = false;
		$(function() {
			$('#toggle-event').change(function() {
				hidden ? $("table tbody tr.hidethis").show() : $("table tbody tr.hidethis").hide();
				hidden = !hidden;
			})
		})
	</script>
@endsection