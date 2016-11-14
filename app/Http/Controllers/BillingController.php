<?php

namespace App\Http\Controllers;

use App\Plan;
use Braintree_ClientToken;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function getSubscribe($planName)
    {
        $plan = Plan::findByName($planName);

        $clientToken = Braintree_ClientToken::generate();
        $subscription = auth()->user()->subscription();

        return view('billing.subscribe', compact('clientToken', 'plan', 'subscription'));
    }


    public function postSubscribe(Request $request, $planName)
    {
        $user = auth()->user();

        $subscription = $user->subscription();

        if ($subscription and $subscription->active()) {
            $user->subscription()->cancelNow();
        }

        $paymentMethodNonce = request('payment_method_nonce');

        // returns Laravel\Cashier\Subscription
        $user->newSubscription('default', $planName)->create($paymentMethodNonce);

        return redirect()->route('subscription.status');
    }



    public function getSubscription()
    {
        $subscription = auth()->user()->subscription();

        if ($subscription and $subscription->active()) {
            return view('billing.subscription', compact('subscription'));
        }

        return redirect()->route('home');
    }



    public function cancelSubscription()
    {
        $response = auth()->user()->subscription()->cancel();

        return redirect()->route('subscription.status');
    }


    public function reactivateSubscription()
    {
        $response = auth()->user()->subscription()->resume();

        return redirect()->route('subscription.status');
    }


    public function cancelSubscriptionForGood()
    {
        $response = auth()->user()->subscription()->cancelNow();

        return redirect()->route('subscription.status');
    }


    public function upgrade()
    {
        $planName = 'high_monthly';

        $response = auth()->user()->subscription()->swap($planName);

        return redirect()->route('subscription.status');
    }


    public function downgrade()
    {
        $planName = 'low_monthly';

        $response = auth()->user()->subscription()->swap($planName);

        return redirect()->route('subscription.status');
    }




    public function getPayingMethod()
    {
        $clientToken = \Braintree_ClientToken::generate([
            "customerId" => auth()->user()->braintree_id
        ]);

        $paymentMethod = auth()->user()->asBraintreeCustomer()->defaultPaymentMethod();

        if ($paymentMethod instanceof \Braintree\PayPalAccount) {
            $isPaypal = true;
        }

        if ($paymentMethod instanceof \Braintree\CreditCard) {
            $isPaypal = false;
        }

        return view('billing.paymentMethod', compact('paymentMethod', 'isPaypal', 'clientToken'));
    }


    public function postPayingMethod(Request $request)
    {
        $creditCardToken = request('payment_method_nonce');

        auth()->user()->updateCard($creditCardToken);

        return redirect()->route('payment.method');
    }


    public function invoices()
    {
        $invoice = auth()->user()->invoices()->first();

        echo $invoice->id;
        echo $invoice->date()->toFormattedDateString(). "<br>";
        echo $invoice->total(). "<br>";


    }
}
