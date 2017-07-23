@extends('dashboard.dashboard_layout')

@section('title')
	Dashboard
@endsection

@section('stuff')

	<form method="POST" action="/users/{{$user->id}}/request">
		{{ csrf_field() }}
		<h1>Middle School</h1>
		<table class="table table-striped">
			<thead>
			<tr>
				<th style="width: 25%">Committee</th>
				<th style="width: 20%">Number requested</th>
				<th style="width: 25%">Level</th>
				<th style="width: 25%">Notes</th>
			</tr>
			</thead>
			<tbody>
			@foreach($committees->where('high_school', 0) as $committee)
				<tr>
					<td>{{$committee->committee . " - " . $committee->topic}}</td>
					<td>
						<select onchange="getDelNumber()" name="committee[{{$committee->id}}]" class="delNumber">
							@for($i = 0; $i <= 30; $i++)
								<option value="{{$i}}"
								@if(count(\App\Request::all()->where('committee_id', $committee->id)->where('user_id', $user->id)) == 0)
										@else
									{{\App\Request::all()->where('committee_id', $committee->id)->where('user_id', $user->id)->first()->amount == $i ? "selected" : ""}}
										@endif
								>{{$i}}</option>
							@endfor
						</select>
					</td>
					<td>
						{{$committee->level}}
					</td>
					<td>
						{{$committee->notes}}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<h1>High School</h1>
		<table class="table table-striped">
			<thead>
			<tr>
				<th style="width: 25%">Committee</th>
				<th style="width: 20%">Number requested</th>
				<th style="width: 25%">Level</th>
				<th style="width: 25%">Notes</th>
			</tr>
			</thead>
			<tbody>
			@foreach($committees->where('high_school', 1) as $committee)
				<tr>
					<td>{{$committee->committee . " - " . $committee->topic}}</td>
					<td>
						<select onchange="getDelNumber()" name="committee[{{$committee->id}}]" class="delNumber">
							@for($i = 0; $i <= 30; $i++)
								<option value="{{$i}}"
								@if(count(\App\Request::all()->where('committee_id', $committee->id)->where('user_id', $user->id)) == 0)
										@else
									{{\App\Request::all()->where('committee_id', $committee->id)->where('user_id', $user->id)->first()->amount == $i ? "selected" : ""}}
										@endif
								>{{$i}}</option>
							@endfor
						</select>
					</td>
					<td>
						{{$committee->level}}
					</td>
					<td>
						{{$committee->notes}}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<input type="submit" class="btn btn-primary" id="submit">
	</form>
	<div class="panel panel-danger" id="max">
		<div class="panel-heading">
			You can only request up to 30 positions.
		</div>
	</div>

	<script>
		$(document.ready(getDelNumber()));

		function getDelNumber() {
			var selects = document.getElementsByClassName("delNumber");
			var total = 0;
			for (var i = 0; i < selects.length; i++) {
				var element = selects[i];
				total += element.selectedIndex;
			}
			document.getElementById("submit").disabled = total > 30;
			document.getElementById("max").style.visibility = total > 30 ? "initial" : "hidden";
		}
	</script>
@endsection