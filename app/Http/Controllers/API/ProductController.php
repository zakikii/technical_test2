<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
Use Auth;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function userPurchases()
    {
        $user_id = Auth::user()->id;
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])->findOrFail($user_id);
        $purchase = Transaction::where('users_id', $user_id)->get();

        if ($purchase) {
            return response(['result' => true, 'data' => $purchase, 'nama_produk' => $transaction->product->name]);
        }
        return response(['result' => false, 'data' => 'data not found']);
        // return response()->json($data, 200);
    }

    public function addCart(Request $req)
      {
        $cart = new Cart();
        $cart->products_id = $req->input('product_id');
        $cart->users_id = Auth::user()->id;

        if ($cart->save()) {
            return response(['result' => true, 'data' => $cart]);
        }
        return response(['result' => false, 'data' => 'cant insert data']);

        
     }

    public function checkoutItem(Request $req){
        $code = 'STORE-'.mt_rand(0000, 9999);
        // $item = new Transaction();
        // $item->users_id = Auth::user()->id;
        // $item->insurance_price = 0;
        // $item->shipping_price =0;
        // $item->total_price = $req->input('price');
        // $item->transaction_status = "WAITING";
        // $item-> code = $code;
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $req->input('price'),
            'transaction_status' => 'WAITING',
            'code' => $code,
          ]);

        $carts = Cart::with(['product', 'user'])->where('users_id', Auth::user()->id)->get();
            
        if (!$carts->isEmpty()) {
            foreach($carts as $cart){
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
                Cart::with(['product', 'user'])
                ->where('users_id', Auth::user()->id)
                ->delete();
                return response(['result' => true, 'transaction' => $transaction]);
           
        }
        return response(['result' => false]);
        

        
        // $transaction = Transaction::create([
        //     'users_id' => Auth::user()->id,
        //     'insurance_price' => 0,
        //     'shipping_price' => 0,
        //     'total_price' => $request->input('price'),
        //     'transaction_status' => 'WAITING',
        //     'code' => $code,
        //   ]);
    }

   
}
