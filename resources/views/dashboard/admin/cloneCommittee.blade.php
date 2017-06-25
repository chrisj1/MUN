@extends('dashboard.admin.admin_layout')

@section('stuff')

	<h1 class="h1 text-center text-primary">Clone {{$committee->committee . " - " . $committee->topic}}</h1>

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

		<form class="form col-sm-6 col-md-6 col-lg-6" method="POST" action="/admin/{{$committee->id}}/clone/add">
			<div class="form-group">
				{{csrf_field()}}
				<table class="table col-sm-6 col-md-6 col-lg-6">
					<thead>
					<th>Position</th>
					<th>Include</th>
					</thead>
					<tbody>
					@foreach($positions as $position)
						<tr>
							<td>{{$position->name}}</td>
							<td class="vcenter">
								<input checked type="checkbox" name="positions[{{$position->id}}]">
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<input type="submit" class="btn btn-danger">
		</form>
	</div>
@endsection