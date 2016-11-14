@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if ($type === 'paypal')
                            Default payment method: <strong>Paypal account</strong>
                        @elseif ($type === 'card')
                            Default payment method: <strong>Credit card</strong>
                        @endif
                    </div>

                    <div class="panel-body">
                        @if ($type === 'paypal')
                            <p><img src="{{ $method->imageUrl }}" alt=""></p>
                            <p>Email: {{ $method->email }}</p>
                        @elseif ($type === 'card')
                            <p><img src="{{ $method->imageUrl }}" alt=""></p>
                            <p>Type: {{ $method->cardType }}</p>
                            <p>Last Digits: {{ $method->last4  }}</p>
                        @endif
                    </div>

                    <div class="panel-footer text-center">
                        <a href="#" class="new-payment-button"><i class="fa fa-recycle"></i> Change my default payment method</a>
                    </div>

                    <div class="panel-body new-payment" style="display: none">
                        <form action="" id="checkout" method="POST">
                            {{ csrf_field() }}
                            <div id="payment-form"></div>

                            <input type="submit" class="btn btn-success pull-right" value="Save">
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

    <script>
        $('.new-payment-button').click(function(e)
        {
            e.preventDefault();

            $('.new-payment').slideToggle();
        })
    </script>
@endsection
