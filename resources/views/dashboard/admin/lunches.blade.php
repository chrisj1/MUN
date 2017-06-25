@extends('dashboard.admin.admin_layout')

@section('stuff')
	<h1 class="text-center h1">Lunches</h1>
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
					{"orderable": false, "searchable": false}
				]
			})
		});
	</script>

	<div style="margin-right: 5%; margin-left: 5%">
		<a href="/admin/addLunch" class="btn btn-primary">Add Lunch</a>
		<table class="table table-striped sortable" id="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Lunch</th>
					<th>Orders</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach ($lunches as $lunch)
				<tr>
					<td>
						{{ $lunch->id}}
					</td>
					<td>
						{{ $lunch->name}}
					</td>
					<td>
						{{ count($delegates->where('lunch', $lunch->id)) }}
					</td>

					<td class="action">
						<a href="/admin/lunches/{{$lunch->id}}/delete" class="btn btn-xs btn-danger">Delete</a>
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
@endsection