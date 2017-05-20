@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="h1 text-center text-primary">Add a Lunch</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form class="form" method="POST" action="/dashboard/admin/addLunch/add">
		<div class="form-group">
			{{csrf_field()}}
			<div class="form-group">
				<label class="form_label" for="name">Name</label>
				<input class="form-control" name="name">
			</div>
		</div>
		<input type="submit" class="confirmation btn btn-danger">
	</form>

	<script type="text/javascript">
		var elems = document.getElementsByClassName('confirmation');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to add this lunch?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>
@endsection