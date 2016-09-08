@extends('dashboard.admin.admin_layout')

@section('stuff')
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	<h1 class="text-center">{{$user->school}}</h1>
	<form METHOD="post" action="/admin/{{$user->id}}/assign">
		{{csrf_field()}}
		@foreach($committees->where('clone_of', null) as $committee)
			<h2>{{$committee->full_name . " - " . $committee->topic}}</h2>
			<br>
			<div class="panel panel-primary">
				<div class="panel-heading">
					Requested: <span class="amount">{{count(\App\Delegate::all()->where('requested_committee', $committee->id)->where('user_id', $user->id))}}</span>
				</div>
			</div>
			<table class="table table-striped sortable" id="table">
				<thead>
				<tr>
					<th>Position</th>
					<th>Committee</th>
					<th style="width: 10%">Assign</th>
				</tr>
				</thead>
				<tbody>
					@foreach($positions as $position)
						<tr>
							@if($position->committee->id == $committee->id)
								<td>{{$position->position->name}}</td>
								<td>{{\App\Committee::find($position->position->committee_id)->full_name ." - " . 
								\App\Committee::find($position->position->committee_id)->id}}</td>
								<td><input committee="{{$committee->id}}"  data-toggle="toggle" type="checkbox"
								           data-off="Not assigned" data-on="Assigned"
								           name="position[{{$position->position->id}}]" {{$position->position->user_id == $user->id ? "checked": ""}}></td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		@endforeach
		<div align="right">
			<input type="submit" class="btn btn-primary btn-lg">
		</div>
	</form>
@endsection