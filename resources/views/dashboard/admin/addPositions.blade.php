@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="h1 text-center text-primary">Add Positions</h1>
	<h4 class="h4 text-center text-primary">(Enter multiple positions by separating with commas)</h4>


	<div style="margin-left: 5%; margin-right: 5%">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form class="form" method="post" action="/admin/addPositions">
			<div class="form-group">{{csrf_field()}}</div>
			<div class="form-group">
				<label for="committee" class="form_label">Committee</label>
				<select class="form-control" name="committee">
					@foreach ($committees as $committee)
						<option {{Request::old('committee') == $committee->id ? "selected": ""}} value="{{$committee->id}}" {{isset($last) ? ($last->committee_id == $committee->id ? "selected" : "") : ""}}>{{$committee->full_name .
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