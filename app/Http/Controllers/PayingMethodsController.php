<?php

namespace App\Http\Controllers;

use App\User;
use Braintree_ClientToken;
use Illuminate\Http\Request;

class PayingMethodsController extends Controller
{
    /**
     * Retrieve from BT the default payment method
     * Show the form to change the default  method
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function defaultMethod()
    {
        $user = auth()->user();

        extract($this->getDefaultMethod($user));    //type, method

        $clientToken = Braintree_ClientToken::generate([
            "customerId" => $user->braintree_id
        ]);

        return view('billing.paymentMethod', compact('clientToken', 'type', 'method'));
    }


    /**
     * Handle the change of the default
     * payment method
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $creditCardToken = $request->get('payment_method_nonce');

        auth()->user()->updateCard($creditCardToken);

        return redirect()->route('payment.method');
    }



    private function getDefaultMethod(User $user)
    {
        $payment = $user->asBraintreeCustomer()->defaultPaymentMethod();

        if ($payment instanceof \Braintree\PayPalAccount) {
            $type = 'paypal';
        } elseif ($payment instanceof \Braintree\CreditCard) {
            $type = 'card';
        }

        return [
            'type' => $type,
            'method' => $payment
        ];
    }
}
