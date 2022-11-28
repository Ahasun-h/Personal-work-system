<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Models\Account;
use App\Models\ExpenseOrWithdraw;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use yajra\Datatables\Datatables;

class ExpenseOrWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $transactions = Transaction::whereIn('transaction_type',[1,5])->latest()->with(['bankAccount','createdByUser'])->get();
            return DataTables::of($transactions)
                ->addIndexColumn()

                ->addColumn('action', function ($transactions) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('expense-or-withdraw.show', Crypt::encrypt($transactions->id)) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('expense-or-withdraw.edit', Crypt::encrypt($transactions->id)) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $transactions->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                                <i class="bx bxs-trash"></i>
                              </a>
                            </div>';
                })
                ->addColumn('account_and_name', function ($transactions) {
                    if($transactions->method == 2){
                        return $transactions->bankAccount->account_number .' ( <span class="text-primary ">'. $transactions->bankAccount->account_holder_name .' </span> ) ';
                    }else{
                        return 'A-0001 ( <span class="text-primary "> Cash </span> )';
                    }

                })
                ->addColumn('transaction_type', function ($transactions) {
                    if($transactions->transaction_type == 5){
                        return 'Expense';
                    }else if($transactions->transaction_type == 1){
                        return 'Withdraw';
                    }

                })
                ->rawColumns(['action', 'account_and_name','transaction_type'])
                ->make(true);
        }
        return view('layout.expense-or-withdraw.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Get All Active Account
        $accounts = Account::where('status',1)->get();
        return view('layout.expense-or-withdraw.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransactionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTransactionRequest $request)
    {
        //  Transaction Type Check Bank Account Or Cash Account
        if ($request->transaction_method == 2) {
            $balance = Accounts::postBalance($request->account_id);
        } else {
            $balance = Accounts::postBalance(0);
        }
        // Update Account Balance
        $balance = $balance - $request->amount;

        // Check Account Balance
        if ($balance < 0) {
            return redirect()->back()->with('alert-error', 'Transaction failed for insufficient balance! ');
        } else {
            //  Transaction Store
            $transaction = new Transaction();
            $transaction->title = $request->title;
            $transaction->date = $request->date;
            if ($request->transaction_method == 2) {
                $transaction->account_id = $request->account_id;
            } else {
                $transaction->account_id = 0;
            }
            $transaction->method = $request->transaction_method;
            $transaction->transaction_type = $request->transaction_type;
            $transaction->type = 1;
            $transaction->amount = $request->amount;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->note = $request->note;
            $transaction->created_by = Auth::user()->id;
            $transaction->save();

            return redirect()->route('expense-or-withdraw.index')->with('t-success', 'Add successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $transaction = Transaction::where('id',Crypt::decrypt($id))->with('bankAccount')->first();
        return view('layout.expense-or-withdraw.show',compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        // Get All Active Account
        $accounts = Account::all();
        // Get Selected ExpenseOrWithdraw Data
        $expense_or_withdraw = Transaction::where('id',Crypt::decrypt($id))->with('bankAccount')->first();

        // Get Balance
        $balance =  Accounts::postBalance($expense_or_withdraw->account_id);
        $balance =  $balance + $expense_or_withdraw->amount;

        return view('layout.expense-or-withdraw.edit',compact('accounts','expense_or_withdraw' ,'balance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransactionRequest $request
     * @param Transaction $expense_or_withdraw
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTransactionRequest $request, Transaction $expense_or_withdraw)
    {
        //  Transaction Type Check Bank Account Or Cash Account
        if ($expense_or_withdraw->method == 2) {
            $balance = Accounts::postBalance($request->account_id);
        } else {
            $balance = Accounts::postBalance(0);
        }
        // Get Previous Account Balance
        $balance = $balance + $expense_or_withdraw->amount;

        // Update Balance
        $balance = $balance - $request->amount;

        // Check Account Balance
        if ($balance < 0) {
            return redirect()->back()->with('alert-error', 'Transaction failed for insufficient balance! ');
        } else {
            // Transaction Update
            $expense_or_withdraw->title = $request->title;
            $expense_or_withdraw->date = $request->date;
            if ($expense_or_withdraw->method == 2) {
                $expense_or_withdraw->account_id = $request->account_id;
            } else {
                $expense_or_withdraw->account_id = 0;
            }
            $expense_or_withdraw->transaction_type = $request->transaction_type;
            $expense_or_withdraw->amount = $request->amount;
            $expense_or_withdraw->cheque_number = $request->cheque_number;
            $expense_or_withdraw->note = $request->note;
            $expense_or_withdraw->updated_by = Auth::user()->id;
            $expense_or_withdraw->update();

            return redirect()->route('expense-or-withdraw.index')->with('t-success', 'Update successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request ,$id)
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
