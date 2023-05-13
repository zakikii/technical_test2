<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
     public function index(){

      if (request()->ajax()) {
            $transaction = TransactionDetail::with(['transaction.user', 'product.galleries']);
            // dd($category);
            return DataTables::of($transaction)
                ->make();
        }
      //  dd('ini transaction');
      return view('pages.admin.transaction.index');
}}
