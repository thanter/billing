@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Payment method</div>

                    <div class="panel-body">

                        @if ($paymentMethod instanceof Braintree\PayPalAccount)
                            <img src="{{ $paymentMethod->imageUrl }}" alt=""><br>
                            Email: {{ $paymentMethod->email }}<br>
                        @elseif ($paymentMethod instanceof Braintree\CreditCard)
                            <img src="{{ $paymentMethod->imageUrl }}" alt=""><br>
                            Type: {{ $paymentMethod->cardType }}<br>
                            Owner: {{ $paymentMethod->cardholderName  }}<br>
                            Last Digits: {{ $paymentMethod->last4  }}<br>
                        @endif
                        <br>
                        <br>

                        <form action="" id="checkout" method="POST">
                            {{ csrf_field() }}
                            <div id="payment-form"></div>
                            <input type="submit" class="btn btn-success" value="Update method">
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
