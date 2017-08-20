@extends('dashboard.dashboard_layout')

@section('title')
	Dashboard
@endsection

@section('stuff')
	@if(count($positions) > 0)
		<table class="table table-striped sortable">
			<thead>
			<tr>
				<th>#</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Position</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($delegates as $delegate)
				<tr>
					<td>
						{{ $count++ }}
					</td>
					<td>
						{{ $delegate->firstname }}
					</td>

					<td>
						{{ $delegate->lastname }}
					</td>

					<td>
					{{ \App\Committee::find($delegate)}}

					<td>
						<a class="confirmation btn btn-danger btn-xs"
						   name="{{$delegate->firstname . $delegate->lastname}}"
						   style="margin:5px; justify-content:flex-end" href="/dashboard/{{ $delegate->id }}/delete">Delete</a>
						<a class="btn btn-primary btn-xs" style="margin:5px; justify-content:flex-end"
						   href="/dashboard/{{ $delegate->id }}/edit">Edit</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
	<br>

	@if(count(\App\Position::all()->where('user_id', Auth::user()->id)) > 0)
		<div class="panel-primary panel">
			<div class="panel-heading"><h3>Add a delegate</h3></div>
			<div class="panel-body">
				@if (count($errors) > 0)
					<div class="alert alert-danger" role="alert">
						@foreach ($errors->all() as $error)
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							{{$error}}
							<br>
						@endforeach
					</div>
				@endif

				<form method="POST" action="/users/{{$user->id}}/delegates">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="firstname">Firstname <span class="glyphicon glyphicon-asterisk"
						                                       aria-hidden="true"></span> </label>
						<input id="firstname" class="form-control" name="firstname"
						       value="{{Request::old('firstname')}}">
					</div>

					<div class="form-group">
						<label for="lastname">Lastname <span class="glyphicon glyphicon-asterisk"
						                                     aria-hidden="true"></span></label>
						<input id="lastname" class="form-control" name="lastname" value="{{Request::old('lastname')}}">
					</div>

					<div class="form-group">
						<label for="position">Position</label>
						<select name="position" class="form-control"
						        value="{{Request::old('position')}}">
							@foreach($positions as $pos)
								<option value="{{$pos->id}}">{{\App\Committee::find($pos->committee_id)->full_name . "-" . \App\Committee::find($pos->committee_id)->topic . "-" . $pos->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="lunch">Lunch</label>
						<select name="lunch" class="form-control" value="{{Request::old('lunch')}}">
							<option value='0'></option>
							@foreach ($lunches as $lunch)
								<option value={{$lunch->id}}>{{$lunch->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<button class="btn btn-primary" type="submit">Add new delegate</button>
					</div>
				</form>
			</div>
		</div>
	@else
		<div class="panel panel-danger">
			<div class="panel-heading">You have no positions assigned</div>
			<div class="panel-body">The confrence staff will assign you positions based
				on your requests.
			</div>
		</div>
	@endif

	<script type="text/javascript">
		var elems = document.getElementsByClassName('confirmation');
		var confirmIt = function (e) {
			if (!confirm('Are you sure you want to delete this delegate, this cannot be undone?')) e.preventDefault();
		};
		for (var i = 0, l = elems.length; i < l; i++) {
			elems[i].addEventListener('click', confirmIt, false);
		}
	</script>
@endsection
