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

class SellerController extends Controller
{
    public function listProducts(){
        $products= Product::where('users_id', Auth::user()->id)->get();
        if (!$products->isEmpty()) {
           return response(['result' => true, 'data' => $products]);
        }
        return response(['result' => false, 'data' => 'products not found']);
   }

   public function changeStatusTransaction(Request $req){ 
    $transactiondetail = TransactionDetail::findorFail($req->input('detail_id'));
    //   $item->update($data);
    $transaction = Transaction::findorFail($req->input('transaction_id'));
    $status = $req->input('transaction_status');
    if ($status == 'WAITING') {
      if (Carbon::now() > $req->input('expired_time')) {
          $transactiondetail->transaction_status = 'EXPIRED';
          $transaction->transaction_status = 'EXPIRED';
          $transactiondetail->save();
          $transaction->save();
          return response(['result' => true, 'data' => 'transaction status change to EXPIRED']);
    }else{
      $transactiondetail->transaction_status = $req->input('shipping_status');
        $transaction->transaction_status = $req->input('shipping_status');
        $transactiondetail->save();   
        $transaction->save();
        return response(['result' => true, 'data' => 'transaction status change to '.$req->input('shipping_status')]);
    }
    } else {
        $transactiondetail->transaction_status = $req->input('shipping_status');
        $transaction->transaction_status = $req->input('shipping_status');
        $transactiondetail->save();   
        $transaction->save();
        return response(['result' => true, 'data' => 'transaction status change to '.$req->input('shipping_status')]);
    }

   }
}
