<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $expenses = Expense::latest()->with(['transaction','createdByUser'])->get();
            return DataTables::of($expenses)
                ->addIndexColumn()

                ->addColumn('action', function ($expenses) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('expense.show', $expenses->id) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('expense.edit', $expenses->id) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $expenses->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                                <i class="bx bxs-trash"></i>
                              </a>
                            </div>';
                })
                ->addColumn('account', function ($expenses) {
                    if($expenses->transaction_way == 2){
                        return $expenses->transaction->bankAccount->account_number;
                    }else{
                        return 'A-0001';
                    }

                })
                ->addColumn('bank_and_branch', function ($expenses) {
                    if($expenses->transaction_way == 2){
                        return $expenses->transaction->bankAccount->branch->branch_name.'|'.$expenses->transaction->bankAccount->branch->bank->bank_name;
                    }else{
                        return 'Cash';
                    }

                })
                ->rawColumns(['action', 'account','bank_and_branch'])
                ->make(true);
        }
        return view('layout.expense.index');
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
        return view('layout.expense.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseRequest $request)
    {
        DB::beginTransaction();
        try {
            //  Transaction Type Check Bank Account Or Cash Account
            if ($request->transaction_way == 2) {
                $balance = Accounts::postBalance($request->account_id);
            }else{
                $balance = Accounts::postBalance(0);
            }
            // Update Account Balance
            $balance = $balance - $request->amount;

            // Check Account Balance
            if ($balance < 0) {
                return redirect()->back()->with('exception', 'Transaction failed for insufficient balance! ');
            } else {
                //  Transaction Store
                $transaction = new Transaction();
                $transaction->transaction_title = $request->expense_title;
                $transaction->transaction_date = $request->expense_date;
                if ($request->transaction_way == 2) {
                    $transaction->account_id = $request->account_id;
                } else {
                    $transaction->account_id = 0;
                }
                $transaction->transaction_purpose = 5;
                $transaction->transaction_type = 1;
                $transaction->amount = $request->amount;
                $transaction->cheque_number = $request->cheque_number;
                $transaction->description = $request->note;
                $transaction->created_by = Auth::user()->id;
                $transaction->save();

                // expense store
                $expense = new Expense();
                $expense->expense_title = $request->expense_title;
                $expense->expense_date = $request->expense_date;
                $expense->transaction_way = $request->transaction_way;
                $expense->transaction_id = $transaction->id;
                $expense->amount = $request->amount;
                $expense->created_by = Auth::user()->id;
                $expense->save();

                DB::commit();
                return redirect()->route('expense.index')->with('message', 'Add successfully.');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('exception', 'Operation failed ! ' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $accounts = Account::where('status',1)->get();
        // Get Selected Expense Data
        $expense = Expense::where('id',$id)->with('transaction')->first();

        // Get Balance
        $balance =  Accounts::postBalance($expense->transaction->account_id);
        $balance =  $balance - $expense->amount;

        return view('layout.expense.edit',compact('accounts','expense' ,'balance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        if($request->ajax()){
            try {
                DB::beginTransaction();
                // Get Selected Expense
                $expense = Expense::where('id', $id)->with(['transaction', 'createdByUser'])->first();

                //  Transaction Data Get
                $transaction = Transaction::where('id', $expense->transaction_id)->first();
                $transaction->updated_by = Auth::user()->id;
                $transaction->delete();
                $expense->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Item Deleted Successfully.',
                ]);
            } catch
            (\Exception $exception) {
                DB::rollBack();
                return redirect()->back()->with('error', $exception->getMessage());
            }
        }
    }
}
