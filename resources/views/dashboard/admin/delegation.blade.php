@extends('dashboard.admin.admin_layout')

@section('stuff')
	<h1 class="h1 text-primary text-center">
		{{$user->school}}
	</h1>

	<div class="col-md-8 ">
		<table class="table table-bordered table-responsive">
			<tr>
				<td>
					<strong>Moderator:</strong>
				</td>
				<td>
					{{$user->name}}
				</td>
			</tr>
			<tr>
				<td>
					<strong>Email:</strong>
				</td>
				<td>
					{{$user->email}}
				</td>
			</tr>
			<tr>
				<td>
					<strong>Cost:</strong>
				</td>
				<td>
					{{$cost}}
				</td>

			<tr>
				<td>
					<strong>Amount paid:</strong>
				</td>
				<td>
					{{$paid_amount}}
				</td>
			<tr>
				<td>
					<strong>Balance:</strong>
				</td>
				<td>
					{{$amount_due}}
				</td>
			</tr>
		</table>
	</div>

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
					{ "orderable": false, "searchable": false}
				]
			})
		});
	</script>
	
	<table class="table table-striped sortable" id="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Requested Committee</th>
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
				<td class="action">
					<a class="confirmation btn btn-danger btn-xs" name="{{$delegate->firstname . $delegate->lastname}}" style="margin:5px; justify-content:flex-end" href="/dashboard/{{ $delegate->id }}/delete">Delete</a>
					<a class="btn btn-primary btn-xs" style="margin:5px; justify-content:flex-end" href="/dashboard/{{ $delegate->id }}/edit">Edit</a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<br>

	<h1 class="h1 text-center">Payments</h1>
	<script>
		$(document).ready(function () {
			$('#payments').DataTable({
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"ordering": true,
				"pageLength": 15,
				'searching': false,

				"columns": [
					{ "orderable": true, "searchable" : false },
					{ "orderable": true, "searchable" : false },
				]
			})
		});
	</script>

	<table class="table table-striped sortable" id="payments">
		<thead>
			<th>Time</th>
			<th>Amount</th>
		</tr>
		</thead>
		<tbody>
			@foreach ($payments as $payment)
				<tr>
					<td>
						{{$payment->created_at}}
					</td>
					<td>
						{{ \App\Http\Controllers\DashboardController::money_format('%#10n', $payment->amount/100.0)}}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection