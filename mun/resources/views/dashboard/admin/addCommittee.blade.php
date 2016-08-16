@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="h1 text-center text-primary">Add a Committee</h1>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form class="form" method="post" action="/admin/addCommittee/add">
		<div class="form-group">{{csrf_field()}}</div>
		<div class="form-group">
			<label for="name" class="form_label">Committee Name</label>
			<input name="name" class="form-control" type="text" value="{{Request::old('name')}}" >
		</div>

		<div class="form-group">
			<label for="abbreviation" class="form_label">Abbreviation</label>
			<input name="abbreviation" class="form-control" type="text" value="{{Request::old('abbreviation')}}">
		</div>

		<div class="form-group">
			<label for="topic" class="form_label">Topic</label>
			<input name="topic" class="form-control" type="text" value="{{Request::old('topic')}}">
		</div>

		<div class="form-group">
			<label for="chair_name" class="form_label">Chair Name</label>
			<input name="chair_name" class="form-control" type="text" value="{{Request::old('chair_name')}}">
		</div>


		<div class="form-group">
			<label for="chair_email" class="form_label">Chair Email</label>
			<input name="chair_email" class="form-control" type="email" value="{{Request::old('chair_email')}}" >
		</div>

		<input class="btn btn-danger" type="submit">
	</form>
@endsection