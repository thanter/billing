@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Subscription details</div>

                    <div class="panel-body">
                        <p>
                            Your subscription plan

                            @if ($subscription->onGracePeriod())
                                <span class="label label-danger pull-right">CANCELLED</span>
                                <small>(You can use our services until: {{ $subscription->ends_at->toDateString() }})</small>
                            @elseif ($subscription->active())
                                <span class="label label-success pull-right">ACTIVE</span>
                            @endif
                        </p>
                        <p>
                            Plan
                            <span class="pull-right">{{ $subscription->plan()->title }}</span>
                        </p>
                        <p>
                            {{--TODO: REDO THIS--}}
                            {{--@if ($subscription->plan()->hasHigher())--}}
                                {{--<a href="{{ route('subscription.upgrade') }}">--}}
                                    {{--<span class="label label-primary pull-right">Upgrade</span>--}}
                                {{--</a>--}}
                            {{--@elseif ($subscription->plan()->hasLower())--}}
                                {{--<a href="{{ route('subscription.downgrade') }}">--}}
                                    {{--<span class="label label-primary pull-right">Downgrade</span>--}}
                                {{--</a>--}}
                                {{--</span>--}}
                            {{--@endif--}}
                        </p>
                        <p>
                            Subscription
                            <span class="pull-right">{{ ucfirst($subscription->plan()->duration) }}ly</span>
                        </p>
                    </div>

                    <div class="panel-footer">
                        @if ($subscription->onGracePeriod())
                            <a href="{{ route('subscription.reactivate') }}" class="btn btn-success btn-block">
                                Reactivate my subscription
                            </a>
                        @elseif ($subscription->active())
                            <a href="{{ route('subscription.cancel') }}" class="btn btn-danger btn-block">
                                Cancel my subscription
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
