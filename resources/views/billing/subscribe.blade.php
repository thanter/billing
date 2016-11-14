@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @if (Auth::user()->subscription())
                    @if (Auth::user()->subscription()->onGracePeriod())
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> You are still on grace period from your last subscription.
                            It will be cancelled if you proceed.
                        </div>
                    @elseif (Auth::user()->subscription()->active())
                        <div class="alert alert-danger">
                            <strong>Warning!</strong> Your subscription is still active. It will be cancelled if you proceed.
                        </div>
                    @endif
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Subscribe to plan <strong>{{ ucfirst($plan->priceName) }}</strong>
                        for $ {{ number_format($plan->price / 100) }} per month
                    </div>

                    <div>
                        <form action="{{ route('subscribe', $plan->name) }}" id="checkout" method="POST">
                            {{ csrf_field() }}
                            <div class="panel-body" id="payment-form"></div>

                            <div class="panel-footer">
                                <input type="submit" class="btn btn-success btn-block" value="Proceed">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer-scripts')
    <script src="https://js.braintreegateway.com/js/braintree-2.29.0.min.js"></script>

    <script>
        var clientToken = "{{ $clientToken }}";

        braintree.setup(clientToken, "dropin", {
            container: "payment-form"
        });
    </script>
@endsection
