@extends('dashboard.admin.admin_layout')

@section('stuff')
	<h1 class="h1 text-center text-primary">Add a Briefing Paper</h1>

	<a href="/admin/papers"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form class="form" method="post" action="/admin/addPaper" enctype="multipart/form-data">
		<div class="form-group">{{csrf_field()}}</div>
		<div class="form-group">
			<label for="committee" class="form_label">Committee</label>
			<select class="form-control" name="committee">
				@foreach ($committees as $committee)
					<option {{Request::old('committee') == $committee->id ? "selected": ""}} value="{{$committee->id}}">{{$committee->full_name .
						' - ' . $committee->topic}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="form_label">Name</label>
			<input name="name" type="text" class="form-control">
		</div>
		<div class="form-group">
			<label for="paper" class="form_label">Paper <span class="glyphicon glyphicon-file"></span></label>
			<input name="paper" type="file" class="form-control">
		</div>
		<input type="submit" class="btn btn-primary">
	</form>
@endsection
