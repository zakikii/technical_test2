<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sellTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                              ->whereHas('product', function ($product) {
                                  $product->where('users_id', Auth::user()->id);
                              })->get();
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                            ->whereHas('transaction', function ($transaction) {
                                $transaction->where('users_id', Auth::user()->id);
                            })->get();

        return view('pages.dashboard-transactions', [
            'sellTransactions' => $sellTransactions,
            'buyTransactions' => $buyTransactions,
        ]);
    }

        public function details(Request $request, $id)
        {
            $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
                                ->findOrFail($id);

            return view('pages.dashboard-transactions-details', [
                'transaction' => $transaction,
            ]);
        }

        public function details2(Request $request, $id)
        {
            $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
                                ->findOrFail($id);

            return view('pages.dashboard-purchase-details', [
                'transaction' => $transaction,
            ]);
        }

      public function update(Request $request, $id)
      {
          $transactiondetail = TransactionDetail::findorFail($id);
          //   $item->update($data);
          $transaction = Transaction::findorFail($request->input('transaction_id'));
          $status = $request->input('transaction_status');
          if ($status == 'WAITING') {
            if (Carbon::now() > $request->input('expired_time')) {
                $transactiondetail->transaction_status = 'EXPIRED';
                $transaction->transaction_status = 'EXPIRED';
                $transactiondetail->save();
                $transaction->save();
          }else{
            $transactiondetail->transaction_status = $request->input('shipping_status');
              $transaction->transaction_status = $request->input('shipping_status');
              $transactiondetail->save();   
              $transaction->save();
          }
          } else {
              $transactiondetail->transaction_status = $request->input('shipping_status');
              $transaction->transaction_status = $request->input('shipping_status');
              $transactiondetail->save();   
              $transaction->save();
          }

          return redirect()->route('dashboard-transaction-details', $id);

          // return redirect()->route('dashboard-product');
      }
}
