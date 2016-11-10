<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use Braintree_ClientToken;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function getSubscribe($plan)
    {
        $plan = strtolower($plan) . "_monthly";

        switch($plan)
        {
            case 'low_monthly':
                $price = 5;
                break;
            case 'high_monthly':
                $price = 10;
                break;
        }

        $clientToken = Braintree_ClientToken::generate();

        return view('billing.subscribe', compact('clientToken', 'plan', 'price'));
    }


    public function postSubscribe(Request $request, $plan)
    {
        $user = auth()->user();
        $paymentMethodNonce = request('payment_method_nonce');

        // Laravel\Cashier\Subscription
        $what = $user->newSubscription('default', $plan)->create($paymentMethodNonce);

        return redirect()->to('subscription');
    }


    public function getSubscription()
    {
        $user = auth()->user();

        $subscription = $user->subscription();

        if ($subscription->active()) {
            dd($user->subscriptionDetails($subscription));
            return view('billing.subscription', compact('subscription'));
        }

        return redirect()->to('subscribe');
    }


    public function cancelSubscription()
    {
        $user = User::find(1);

        $response = $user->subscription()->cancelNow();

        return redirect()->to('subscription');
    }


    public function getPayingMethod()
    {
        $user = User::find(1);

        $clientToken = \Braintree_ClientToken::generate([
            "customerId" => $user->braintree_id
        ]);

        $paymentMethod = $user->asBraintreeCustomer()->defaultPaymentMethod();

        return view('billing.paymentMethod', compact('paymentMethod', 'clientToken'));
    }


    public function postPayingMethod(Request $request)
    {
        $user = User::find(1);

        $creditCardToken = request('payment_method_nonce');

        $user->updateCard($creditCardToken);

        return redirect()->to('paying');
    }
}
