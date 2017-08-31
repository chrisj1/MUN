@extends('dashboard.admin.admin_layout')

@section('stuff')
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<a href="/admin/assignPositions" style="margin: 5%"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Return Back</a>
	<h1 class="text-center">{{$user->school}}</h1>

	<div style="margin-left: 5%; margin-right: 5%">
		<form METHOD="post" action="/admin/{{$user->id}}/assign" id="form">
			{{csrf_field()}}
			@foreach($committees->where('clone_of', null) as $committee)
				<h2>{{$committee->full_name . " - " . $committee->topic}}</h2>

				<div class="panel panel-primary">
					<div class="panel-heading">
						Requested: <span class="amount">{{count(\App\Request::all()->where('committee_id', $committee->id)->where('user_id', $user->id)) > 0 ?
						 collect(\App\Request::all()->where('committee_id', $committee->id)->where('user_id', $user->id))->first()->amount : 0}}</span>
					</div>
				</div>
				<table class="table table-striped sortable">
					<thead>
					<tr>
						<th>Position</th>
						<th>Committee</th>
						<th style="width: 10%">Assign</th>
					</tr>
					</thead>
					<tbody>
					@foreach($positions as $position)
						@if($position->position->committee_id == $committee->id)
							<tr>
								<td>{{$position->position->name}}</td>
								<td>{{$committee->full_name ." - " .
									$committee->id}}</td>
								<td><input committee="{{$committee->id}}" data-toggle="toggle" type="checkbox"
								           data-off="Not assigned" data-on="Assigned"
								           name="position[{{$position->position->id}}]"
								           {{$position->position->user_id == $user->id ? "checked": ""}}
								           class="assignToggle"></td>
							</tr>
						@endif
					@endforeach
					</tbody>
				</table>
			@endforeach
			<div align="right">
				<input type="submit" class="btn btn-primary btn-lg">
			</div>
		</form>
	</div>

	<script>
		var form = document.getElementById("form");

		function submit() {
			form.submit();
		}
	</script>

	<script>
		$(document).ready(function () {
			$('table.table').DataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"ordering": true,
				"pageLength": 10,

				"columns": [
					{"orderable": true, "searchable": true},
					{"orderable": false, "searchable": false},
					{"orderable": false, "searchable": false}
				]
			});
		});
	</script>
@endsection