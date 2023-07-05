<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $user = Auth::user();

        // validate order address is exists & user created it
        $validator = Validator::make($request->all(), [
            'order_address_id' => 'required|exists:orders_addresses,id,user_id,' . $user['id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // get cart for user not ordered
        $cart = Cart::where('user_id', $user['id'])->where('been_ordered', 0)->first();

        // no cart for user
        if (is_null($cart)) {
            return redirect()->route('createTransaction')->with('error', 'There is not cart.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $cart->total()
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('createTransaction')->with('error', 'Something went wrong.');
        } else {
            return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // get cart for user not ordered
            $user = Auth::user();
            $cart = Cart::where('user_id', $user['id'])->where('been_ordered', 0)->last();
            $cart->been_ordered = 1;
            $cart->save();

            $order_address = OrderAddress::where('user_id', $user['id'])->last();

            $order = new Order;
            $order->user_id = $user['id'];
            $order->address_id = $order_address->id;
            $order->cart_id = $cart->id;
            $order->has_been_received = 0;
            $order->total = $cart->total;
            $order->save();

            return redirect()->route('createTransaction')->with('success', 'Transaction complete.');
        } else {
            return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
