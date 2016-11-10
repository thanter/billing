@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Subscription</div>

                    <div class="panel-body">
                        Your subscription is active!!!!

                        <br>
                        <a href="subscription/cancel" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
