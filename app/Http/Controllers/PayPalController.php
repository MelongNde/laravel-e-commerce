<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    public function getExpressCheckout()
    {
        $checkoutData = $this->checkoutData();


        // dd($cartItems);


        $provider = new ExpressCheckout();

        $response = $provider->setExpressCheckout($checkoutData);

        return redirect($response['paypal_link']);

        // dd($response);
    }

    private function checkoutData(){
        $cart = \Cart::session(auth()->id());

        $cartItems = array_map(function($item){
            return [
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['quantity']
            ];
        }, $cart->getContent()->toarray());

        $checkoutData = [
            'items' => $cartItems,

           'return_url' => route('paypal.success'),
           'cancel_url' => route('paypal.cancel'),
           'invoice_id' => uniqid(),
           'invoice_description' => 'Order description',
           'total' => $cart->getTotal()
       ];

       return $checkoutData;
    }

    public function cancelPage()
    {
        dd('Payment faild');
    }

    public function getExpressCheckoutSuccess(Request $request)
    {
        $token = $request->get('token');
        $payerId = $request->get('PayerID');
        $provider = new ExpressCheckout();
        $checkoutData = $this->checkoutData();
        $response = $provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            // Perform transaction on PayPal
            $payment_status = $provider->doExpressCheckoutPayment($checkoutData, $token, $payerId);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

            dd('Payment successful');

            // if(in_array($status, ['Completed','Processed'])) {
            //     $order = Order::find($orderId);
            //     $order->is_paid = 1;
            //     $order->save();

            //     //send mail

            //     Mail::to($order->user->email)->send(new OrderPaid($order));


            //     return redirect()->route('home')->withMessage('Payment successful!');
            // }

        }
    }

}
