<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeOrDeposit\StoreIncomeOrDepositRequest;
use App\Http\Requests\IncomeOrDeposit\UpdateIncomeOrDepositRequest;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Models\Account;
use App\Models\Income;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class IncomeOrDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $transactions = Transaction::whereIn('transaction_type', [2, 3])->latest()->with(['bankAccount', 'createdByUser'])->get();
            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('action', function ($transactions) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('income-or-deposit.show', Crypt::encrypt($transactions->id)) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('income-or-deposit.edit', Crypt::encrypt($transactions->id)) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $transactions->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                                <i class="bx bxs-trash"></i>
                              </a>
                            </div>';
                })
                ->addColumn('account_and_name', function ($transactions) {
                    if ($transactions->transaction_method == 2) {
                        return $transactions->bankAccount->account_number . ' ( <span class="text-primary ">' . $transactions->bankAccount->account_holder_name . ' </span> ) ';
                    } else {
                        return 'A-0001 ( <span class="text-primary "> Cash </span> )';
                    }

                })
                ->addColumn('transaction_type', function ($transactions) {
                    if ($transactions->transaction_type == 2) {
                        return 'Deposit';
                    } else if ($transactions->transaction_type == 3) {
                        return 'Income';
                    }

                })
                ->rawColumns(['action', 'account_and_name', 'transaction_type'])
                ->make(true);
        }
        return view('layout.income-or-deposit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get All Active Account
        $accounts = Account::where('status',1)->get();
        return view('layout.income-or-deposit.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        // Transaction Store
        $transaction = new Transaction();
        $transaction->title = $request->title;
        $transaction->date = $request->date;
        if ($request->transaction_method == 2) {
            $transaction->account_id = $request->account_id;
        } else {
            $transaction->account_id = 0;
        }
        $transaction->transaction_method = $request->transaction_method;
        $transaction->transaction_type = $request->transaction_type;
        $transaction->type = 2;
        $transaction->amount = $request->amount;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->note = $request->note;
        $transaction->created_by = Auth::user()->id;
        $transaction->save();

        return redirect()->route('income-or-deposit.index')->with('t-success', 'Add successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('id',Crypt::decrypt($id))->with('bankAccount')->first();
        return view('layout.income-or-deposit.show',compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get All Active Account
        $accounts = Account::all();
        // Get Selected ExpenseOrWithdraw Data
        $income_or_deposit = Transaction::where('id',Crypt::decrypt($id))->with('bankAccount')->first();
        return view('layout.income-or-deposit.edit',compact('accounts','income_or_deposit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $income_or_deposit)
    {
        $income_or_deposit->title = $request->title;
        $income_or_deposit->date = $request->date;
        if ($income_or_deposit->transaction_method == 2) {
            $income_or_deposit->account_id = $request->account_id;
        } else {
            $income_or_deposit->account_id = 0;
        }
        $income_or_deposit->transaction_type = $request->transaction_type;
        $income_or_deposit->amount = $request->amount;
        $income_or_deposit->cheque_number = $request->cheque_number;
        $income_or_deposit->note = $request->note;
        $income_or_deposit->updated_by = Auth::user()->id;
        $income_or_deposit->update();

        return redirect()->route('income-or-deposit.index')->with('t-success', 'Update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if($request->ajax()){
            //  Transaction Data Get
            $transaction = Transaction::where('id', $id)->first();
            $transaction->updated_by = Auth::user()->id;
            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item Deleted Successfully.',
            ]);
        }
    }
}
