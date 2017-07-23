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

	<h1 class="text-center">Delegates</h1>
	<div style="margin-right: 5%; margin-left: 5%">
		<table class="table table-striped sortable" id="table">
			<thead>
			<tr>
				<th>#</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Requested Committee</th>
				<th>Delegation</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@foreach ($delegates as $delegate)
				<tr>
					<td>
						{{ ++$count}}
					</td>
					<td>
						{{ $delegate->firstname }}
					</td>

					<td>
						{{ $delegate->lastname }}
					</td>

					<td>
						{{ \App\Committee::find($delegate->requested_committee)['committee']}}
					</td>
					<td>
						{{\App\User::find($delegate->user_id)->school}}
					</td>
					<td class="action">
						<a class="confirmation btn btn-danger btn-xs"
						   name="{{$delegate->firstname . $delegate->lastname}}"
						   style="margin:5px; justify-content:flex-end" href="/dashboard/{{ $delegate->id }}/delete">Delete</a>
						<a class="btn btn-primary btn-xs" style="margin:5px; justify-content:flex-end"
						   href="/dashboard/admin/{{ $delegate->id }}/edit">Edit</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		var elems = document.getElementsByClassName('confirmation');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to delete this delegate, this cannot be undone?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>
@endsection