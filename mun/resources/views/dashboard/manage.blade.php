@extends('dashboard.dashboard_layout')

@section('title')
Dashboard
@endsection

@section('stuff')
<div>
  <div class="col-md-8">
    <div class="panel panel-info">
      <div class="panel-heading">Mange Delegate</div>

      <div class="panel-body">
        Here you can manage your delgates and assign committees and will see country assignments.
        Country Assignments should be posted at least two months before the confrence, along with
        briefing papers.
      </div>
    </div>
  </div>
</div>

<div>
  <div class="col-md-8">
    <div class="panel panel-danger">
      <div class="panel-heading">Payment</div>
      <div class="panel-body">
        Your Delegate assignments are <strong> not </strong> finalized until
        payment is recieved. It is in your best interests to ensure that payment is 
        made online or through a check as soon as possible.
      </div>
    </div>
  </div>
</div>

<div class="col-md-8 col-md-offset-3">
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($delegates as $delegate)
        <tr>
          <td>
            {{ $delegate->firstname }}
          </td>

          <td>
            {{ $delegate->lastname }}
          </td>

          <td>
            <a class="confirmation" href="/dashboard/{{ $delegate->id }}/delete">Delete</a>
            <a href="/dashboard/{{ $delegate->id }}/edit">Edit</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
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
