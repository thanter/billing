<?php

namespace App\Http\Controllers;

use App\Plan;
use Braintree_ClientToken;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    /**
     * Shows the current status of the subscription
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function subscription()
    {
        $subscription = auth()->user()->subscription();

        if ($subscription) {
            // Active or OnGracePeriod
            if ($subscription->active()) {
                return view('billing.subscription', compact('subscription'));
            }

            // Cancelled
            if ($subscription->cancelled()) {
                return redirect()->route('home');
            }
        }

        return redirect()->route('home');
    }


    /**
     * Form to pay for new subscription
     *
     * @param $planName
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscribe($planName)
    {
        $plan = plan($planName);

        $clientToken = Braintree_ClientToken::generate();

        return view('billing.subscribe', compact('clientToken', 'plan'));
    }


    /**
     * Handles the subscription creation and save
     * Mind the middleware!
     *
     * @param Request $request
     * @param $planName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSubscribe(Request $request, $planName)
    {
        $paymentMethodNonce = $request->get('payment_method_nonce');

        auth()->user()->newSubscription('default', $planName)
                      ->create($paymentMethodNonce);

        return redirect()->route('subscription.status');
    }


    /**
     * Cancels subscription and
     * puts it on grace period
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelSubscription()
    {
        auth()->user()->subscription()->cancel();

        return redirect()->route('subscription.status');
    }


    /**
     * Cancels subscription for good
     * no grace period
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelSubscriptionForGood()
    {
        auth()->user()->subscription()->cancelNow();

        return redirect()->route('subscription.status');
    }


    /**
     * Reactivate a cancelled subscription
     * that is on its grace period
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reactivateSubscription()
    {
        auth()->user()->subscription()->resume();

        return redirect()->route('subscription.status');
    }


    /**
     * Swap current subscription for the higher one
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upgrade()
    {
        // Plan is hard coded for now
        auth()->user()->subscription()->swap('high_monthly');

        return redirect()->route('subscription.status');
    }


    /**
     * Swap current subscription for the lower one
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function downgrade()
    {
        auth()->user()->subscription()->swap('low_monthly');

        return redirect()->route('subscription.status');
    }
}
