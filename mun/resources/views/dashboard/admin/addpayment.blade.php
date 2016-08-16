@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="h1 text-center text-primary">Add a payment</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form class="form" method="POST" action="/dashboard/admin/addPayment/add">
		<div class="form-group">
			{{csrf_field()}}

			<div class="form-group">
				<label for="delegation" class="form_label col-md-6 col-lg-6 col-sm-6">Delegation</label>
				<select name="delegation" class="form-group-sm form-control">
					@foreach($delegations as $delegation)
						<option value="{{$delegation->id}}">{{$delegation->school}}</option>
					@endforeach
				</select>
			</div>
			<div class="row">
				<div>
					<div class="form-group col-md-3">
						<label for="dollars">Dollars</label>
						<input type="number" class="form-control" name="dollars" min="0">
					</div>
					<div class="form-group col-md-3">
						<label for="cents">Cents</label>
						<input type="number" class="form-control" name="cents" max="99" min="0" value="00">
					</div>
				</div>
			</div>
		</div>
		<input type="submit" class="confirmation btn btn-danger">
	</form>
	<script type="text/javascript">
		var elems = document.getElementsByClassName('confirmation');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to add this payment?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>
@endsection