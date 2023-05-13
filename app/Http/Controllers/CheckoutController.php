<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\config;
use Midtrans\snap;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // save user data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // proses checkout
        $code = 'STORE-'.mt_rand(0000, 9999);
        $carts = Cart::with(['product', 'user'])
                    ->where('users_id', Auth::user()->id)
                    ->get();

        // Membuat Transaksi
        $transaction = Transaction::create([
          'users_id' => Auth::user()->id,
          'insurance_price' => 0,
          'shipping_price' => 0,
          'total_price' => $request->total_price,
          'transaction_status' => 'WAITING',
          'code' => $code,
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-'.mt_rand(0000, 9999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'transaction_status' => 'WAITING',
                'resi' => '',
                'code' => $trx,
                'expired_time' => Carbon::now()->addMinutes(120),
            ]);
        }

        // Delete cart data
        Cart::with(['product', 'user'])
                ->where('users_id', Auth::user()->id)
                ->delete();

        // return dd($transaction);
        // konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat array untuk dikirim ke midtrans
        $midtrans = [
           'transaction_details' => [
               'order_id' => $code,
               'gross_amount' => (int) $request->total_price,
           ],
           'customer_details' => [
               'first_name' => 'Galih Pratama',
               'email' => 'hanamura.iost@gmail.com',
           ],
           'enabled_payments' => ['gopay', 'bank_transfer'],
           'vtweb' => [],
        ];

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    // setelah deployment dibikin
      public function callback(Request $request)
      {
      }
}
