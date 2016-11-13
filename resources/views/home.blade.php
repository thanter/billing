@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <p>
                        I want the cheap plan for <a href="{{ route('subscribe', 'low_monthly') }}">$5 per month</a>
                    </p>
                    <p>
                        I want the expensive plan for <a href="{{ route('subscribe', 'high_monthly') }}">$10 per month</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
