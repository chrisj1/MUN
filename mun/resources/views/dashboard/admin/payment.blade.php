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
					{"bSearchable":true, "bSortable":true},
					{"bSearchable":false, "bSortable":false}
				]
			})
		});
	</script>

	<h1 class="text-center">Payments</h1>
	<a class="btn btn-primary" href="/dashboard/admin/addPayment" style="margin-bottom: 1%">Add Payment</a>
	<table class="table table-striped sortable" id="table">
		<thead>
		<tr>
			<th>#</th>
			<th>Delegation</th>
			<th>Amount</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
			@foreach ($payments as $payment)
				<tr>
					<td>
						{{ $payment->id}}
					</td>
					<td>
						{{ $users->find($payment->user_id)->school }}
					</td>

					<td>
						{{\App\Http\Controllers\DashboardController::money_format('%#10n', $payment->amount/100)}}
					</td>
					<td>
						<a  class="btn btn-danger btn-xs confirm" href="/dashboard/admin/deletePayment/{{$payment->id}}">Delete</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<script type="text/javascript">

		var elems = document.getElementsByClassName('confirm');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to delete this payment, this cannot be undone?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>
@endsection