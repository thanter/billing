@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h3 class="text-center">We offer 3 plans. The longer the better ;)</h3>
                    <br>


                    {{--TODO: DO NOT HARDCODE PLAN NAMES AND PRICES--}}
                    {{--TODO: RETRIEVE THEM FROM CONFIG--}}

                    <ul class="list-group">
                        @foreach ($plans as $plan)
                            <li class="list-group-item">
                                <a href="{{ route('subscribe', $plan->getKey()) }}">
                                    {{ ucfirst($plan->getTitle()) }}
                                </a>
                                ($ {{ $plan->getPrice() }} / month)
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
