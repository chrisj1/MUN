@extends('dashboard.admin.admin_layout')

@section('stuff')
	<div style="margin-left: 2%; margin-right: 2%">
		<a href="/admin/positions" style="margin-bottom: 2%">
			<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Return Back
		</a>
		<h1 class="h1 text-center text-primary">Add Position</h1>
		<h4 class="h4 text-center">(Enter multiple positions by separating with commas)</h4>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form class="form" method="post" action="/admin/addPosition">
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
	</div>
@endsection