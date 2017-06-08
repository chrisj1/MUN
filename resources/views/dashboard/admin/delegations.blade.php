@extends('dashboard.admin.admin_layout')

@section('stuff')

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

				"aoColumns": [
					{"bSearchable":false, "bSortable":false},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{ "bSearchable" : false, "bSortable" : true },
					{"bSearchable":false, "bSortable":false}
				]
			})
		});
	</script>

	<h1 class="text-center">Delegations</h1>
	<div id="f"></div>
	<table class="table table-striped sortable" id="table">
		<thead>
		<tr>
			<th>#</th>
			<th>School</th>
			<th>Moderator</th>
			<th>Moderator Email</th>
			<th>Delegates</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@foreach ($delegations as $delegation)
			<tr>
				<td>
					{{ ++$count}}
				</td>
				<td>
					{{ $delegation->school }}
				</td>

				<td>
					{{ $delegation->name }}
				</td>

				<td>
					{{$delegation->email}}
				</td>

				<td>{{count(DB::table('delegates')->where('user_id', $delegation->id)->get())}}</td>
				<td class="action">
					<a href={{"/dashboard/admin/delgation/" . $delegation->id}} class="btn-primary btn-xs" >View</a>
					<a href={{"/dashboard/autoassign/" . $delegation->id}}>{{"/dashboard/autoassign/" . $delegation->id}}</a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection