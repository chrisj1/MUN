@extends('dashboard.dashboard_layout')

@section('title')
    Dashboard
@endsection

@section('stuff')
    <div>
        <div class="panel panel-info">
            <div class="panel-heading">Mange Delegate</div>

            <div class="panel-body">
                Here you can manage your delegates and assign committees and will see country assignments.
                Country Assignments should be posted at least two months before the confrence, along with
                briefing papers.
            </div>
        </div>
    </div>

    <div>
        <div class="panel panel-info">
            <div class="panel-heading">Assigning positions</div>

            <div class="panel-body">
                Positions will assigned manually to each delegation after the registration deadline. You will have to finalize the assignments, just
                because a committee is requested<strong> does not mean you are guaranteed to receive that position.</strong>
            </div>
        </div>
    </div>

    <div>
        <div class="panel panel-danger">
            <div class="panel-heading">Payment</div>
            <div class="panel-body">
                Your Delegate assignments are <strong> not </strong> finalized until
                payment is recieved. It is in your best interests to ensure that payment is
                made online or through a check as soon as possible.
            </div>
        </div>
    </div>

    @if(count($delegates) > 0)
        <table class="table table-striped sortable">
            <thead>
            <tr>
                <th>#</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Requested Committee</th>
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
                    {{ \App\Committee::find($delegate->requested_committee)['committee']}}

                    <td>
                        <a class="confirmation btn btn-danger btn-xs" name="{{$delegate->firstname . $delegate->lastname}}" style="margin:5px; justify-content:flex-end" href="/dashboard/{{ $delegate->id }}/delete">Delete</a>
                        <a class="btn btn-primary btn-xs" style="margin:5px; justify-content:flex-end" href="/dashboard/{{ $delegate->id }}/edit">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <br>

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
                    <label for="firstname">Firstname <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> </label>
                    <input id="firstname" class="form-control" name="firstname" value="{{Request::old('firstname')}}">
                </div>

                <div class="form-group">
                    <label for="lastname">Lastname <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></label>
                    <input id="lastname" class="form-control" name="lastname" value="{{Request::old('lastname')}}">
                </div>

                <div class="form-group">
                    <label for="requested_committee">Request Committee</label>
                    <select  name="requested_committee"class="form-control" value="{{Request::old('requested_committee')}}">
                        <option value='0'></option>
                        @foreach ($committees as $committee)
                            <option value={{$committee->id}}>{{$committee->committee}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="lunch">Lunch</label>
                    <select  name="lunch"class="form-control" value="{{Request::old('lunch')}}">
                        <option value='0'></option>
                        @foreach ($lunches as $lunch)
                            <option value={{$lunch->id}}>{{$lunch->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary"type="submit">Add new delegate</button>
                </div>
            </form>
        </div>
    </div>

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
