@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Subscribe to {{ $plan }}</div>

                    <div class="panel-body">
                        <form action="{{ route('subscribe', $plan) }}" id="checkout" method="POST">
                            {{ csrf_field() }}

                            <div id="payment-form"></div>

                            <br>
                            <input type="submit" class="btn btn-success btn-block" value="Pay {{ $price }} euros">
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
