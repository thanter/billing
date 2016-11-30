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

                    <ul class="list-group">
                        @foreach ($plans as $plan)
                            <li class="list-group-item">
                                <h4 class="text-center">{{ ucfirst($plan->title) }}</h4>

                                <a href="{{ route('subscribe', $plan->key) }}">
                                    I want this subscription for $ {{ $plan->getPrice() }} / {{ $plan->duration }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
