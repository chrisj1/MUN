@extends('dashboard.admin.admin_layout')

@section('stuff')
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"responsive": true,
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"ordering": true,
				"pageLength": 15,

				"aoColumns": [
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":false, "bSortable":false}
				]
			})
		});
	</script>

	<h1 class="text-center">Papers</h1>

	<hr>
	<div style="margin-right: 5%; margin-left: 5%">
		<a class="btn btn-primary" href="/admin/addPaper">Add Paper</a>

		@if(count($papers) > 0)
			<table class="table table-striped sortable" id="table">
					<thead>
						<th>Committee</th>
						<th>Name</th>
						<th style="width: 10%"></th>
					</thead>
					<tbody>
						@foreach($papers as $paper)
							<tr>
								<td>{{$committees->where('id', $paper->committee_id)->first()->full_name . " - " . $committees->where('id', $paper->committee_id)->first()->topic}}</td>
								<td>{{$paper->name}}</td>
								<td><a  target="_blank" href="/download/{{$paper->id}}" class="btn btn-primary btn-xs">Download</a> </td>
							</tr>
						@endforeach
					</tbody>
			</table>
		@else
			<h3 class="text-center">No Papers</h3>
		@endif
	</div>
@endsection