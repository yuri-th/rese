<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function create()
    {
        return view('/payment/stripe');
    }
    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\PaymentIntent::create([
                'amount' => 3000,
                'currency' => 'jpy',
                'payment_method_types' => ['card'],
                // 'payment_method' => $request->stripeToken,
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,
                    ],
                ],
                'confirm' => true,
            ]);

            return back()->with('status', '決済が完了しました！');
        } catch (\Stripe\Exception\CardException $e) {
            // カードに関するエラーが発生した場合
            return back()->with('flash_alert', '決済に失敗しました！(' . $e->getMessage() . ')');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // リクエストが無効な場合のエラー
            return back()->with('flash_alert', '決済に失敗しました！(' . $e->getMessage() . ')');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // その他のStripe APIエラー
            return back()->with('flash_alert', '決済に失敗しました！(' . $e->getMessage() . ')');
        }
    }
}
