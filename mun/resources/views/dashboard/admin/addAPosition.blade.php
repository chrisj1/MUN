@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="h1 text-center text-primary">Add a Position</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form class="form" method="post" action="/admin/addAPosition">
		<div class="form-group">{{csrf_field()}}</div>
		<div class="form-group">
			<label for="committee" class="form_label">Committee</label>
			<select class="form-control" name="committee">
				@foreach ($committees as $committee)
					<option {{Request::old('committee') == $committee->id ? "selected": ""}} value="{{$committee->id}}">{{$committee->full_name .
						($committee->clone_of == null ? '  (Orginal) ' : ' (Clone) ') . ' - ' . $committee->topic}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="position" class="form_label">Position</label>
			<input name="position" class="form-control" type="text" value="{{Request::old('position')}}">
		</div>

		<input class="btn btn-danger" type="submit">
	</form>
@endsection