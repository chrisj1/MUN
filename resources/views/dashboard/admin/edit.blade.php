@extends('dashboard.admin.admin_layout')

@section('title')
	Dashboard
@endsection

@section('stuff')
	<div style="margin-left: 5%; margin-right: 5%">
		<a href="/admin/delegates" style="margin-bottom: 2%">
			<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Return Back
		</a>

		<form method="POST" action="/delegates/{{$delegate->id}}/edit">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="firstname">Firstname <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
				</label>
				<input id="firstname" class="form-control" name="firstname" value="{{$delegate->firstname}}">
			</div>

			<div class="form-group">
				<label for="lastname">Lastname <span class="glyphicon glyphicon-asterisk"
				                                     aria-hidden="true"></span></label>
				<input id="lastname" class="form-control" name="lastname" value="{{$delegate->lastname}}">
			</div>

			<div class="form-group">
				<label for="requested_committee">Request Committee</label>
				<select name="requested_committee" class="form-control">
					<option value='0'></option>
					@foreach ($committees as $committee)
						<option {{$committee->id == $delegate->requested_committee ? "selected" : ""}} value={{$committee->id}}>{{$committee->committee}}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="lunch">Lunch</label>
				<select name="lunch" class="form-control">
					<option value='0'></option>
					@foreach ($lunches as $lunch)
						<option {{$lunch->id == $delegate->lunch ? "selected" : ""}} value={{$lunch->id}}>{{$lunch->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<button class="btn btn-primary" type="submit">Edit delegate</button>
			</div>
		</form>
	</div>
@endsection
