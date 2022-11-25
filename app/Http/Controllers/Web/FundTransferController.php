<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\FundTransfer\FundTransferRequest;
use App\Models\Account;
use App\Models\FundTransfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;

class FundTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $fundTransfers = FundTransfer::latest()->with(['inTransactionId','outTransactionId','createdByUser'])->get();
            return DataTables::of($fundTransfers)
                ->addIndexColumn()

                ->addColumn('action', function ($fundTransfers) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('fund-transfer.show', Crypt::encrypt($fundTransfers->id)) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('fund-transfer.edit', Crypt::encrypt($fundTransfers->id)) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $fundTransfers->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                                <i class="bx bxs-trash"></i>
                              </a>
                            </div>';
                })
                ->addColumn('account_in', function ($fundTransfers) {
                    if($fundTransfers->in_account == 0){
                        return 'A-0001 ( <span class="text-primary "> Cash </span> )';
                    }else{
                        return $fundTransfers->inTransactionId->bankAccount->account_number .' ( <span class="text-primary ">'. $fundTransfers->inTransactionId->bankAccount->account_holder_name .' </span> ) ';
                    }

                })
                ->addColumn('account_out', function ($fundTransfers) {
                    if($fundTransfers->out_account == 0){
                        return 'A-0001 ( <span class="text-danger "> Cash </span> )';
                    }else{
                        return $fundTransfers->outTransactionId->bankAccount->account_number .' ( <span class="text-danger ">'. $fundTransfers->outTransactionId->bankAccount->account_holder_name .' </span> ) ';
                    }
                })
                ->rawColumns(['action', 'account_in','account_out'])
                ->make(true);
        }
        return view('layout.fund-transfer.index');
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
        return view('layout.fund-transfer.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FundTransferRequest $request)
    {
        try {
            $balance = Accounts::postBalance($request->out_account);
            $balance = $balance - $request->amount;

            if ($balance < 0) {
                return redirect()->route('layout.fund-transfer.index')->with('exception', 'Transaction failed for insufficient balance! ');
            } else {

                DB::beginTransaction();
                // Out Transaction Account
                $transactionOut = new Transaction();
                $transactionOut->title = $request->title;
                $transactionOut->date = $request->date;
                $transactionOut->account_id = $request->out_account;
                if($transactionOut->account_id == 0 ) {
                    $transactionOut->transaction_method = '1';
                }else{
                    $transactionOut->transaction_method = '2';
                }
                $transactionOut->transaction_type = 7;
                $transactionOut->type = 1;
                $transactionOut->amount = $request->amount;
                $transactionOut->note = $request->note;
                $transactionOut->cheque_number = $request->cheque_number;
                $transactionOut->created_by = Auth::user()->id;
                $transactionOut->save();

                // In Transaction Account
                $transactionIn = new Transaction();
                $transactionIn->title = $request->title;
                $transactionIn->date = $request->date;
                $transactionIn->account_id = $request->in_account;
                if($transactionIn->account_id == 0 ) {
                    $transactionIn->transaction_method = '1';
                }else{
                    $transactionIn->transaction_method = '2';
                }
                $transactionIn->transaction_type = 6;
                $transactionIn->type = 2;
                $transactionIn->amount = $request->amount;
                $transactionIn->note = $request->note;
                $transactionIn->cheque_number = $request->cheque_number;
                $transactionIn->created_by = Auth::user()->id;
                $transactionIn->save();

                // FundTransfer Store
                $fundTransfer = new FundTransfer();
                $fundTransfer->title = $request->title;
                $fundTransfer->date = $request->date;
                $fundTransfer->in_account = $request->in_account;
                $fundTransfer->in_transaction_id = $transactionIn->id;
                $fundTransfer->out_account = $request->out_account;
                $fundTransfer->out_transaction_id = $transactionOut->id;
                $fundTransfer->amount = $request->amount;
                $fundTransfer->created_by = Auth::user()->id;
                $fundTransfer->save();

                DB::commit();
                return redirect()->route('fund-transfer.index')->with('t-success', 'Add successfully.');
            }
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert-error', 'Operation failed ! ' . $exception->getMessage());
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
        // Get Selected ExpenseOrWithdraw Data
        $fundTransfer = FundTransfer::where('id',Crypt::decrypt($id))->with(['inTransactionId','outTransactionId'])->first();

        return view('layout.fund-transfer.show',compact('fundTransfer' ));
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
        $fund_transfer = FundTransfer::where('id',Crypt::decrypt($id))->with(['inTransactionId','outTransactionId'])->first();

        // Get Balance
        $balance =  Accounts::postBalance($fund_transfer->out_account);
        $balance =  $balance + $fund_transfer->amount;

        return view('layout.fund-transfer.edit',compact('accounts','fund_transfer' ,'balance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FundTransferRequest $request, FundTransfer $fund_transfer)
    {
        try {
            $balance = Accounts::postBalance($fund_transfer->out_account);
            $balance = $balance + $fund_transfer->amount;
            $balance = $balance - $request->amount;

            if ($balance < 0) {
                return redirect()->route('layout.fund-transfer.index')->with('exception', 'Transaction failed for insufficient balance! ');
            } else {

                DB::beginTransaction();
                // Out Transaction Account
                $transactionOut = Transaction::findOrFail($fund_transfer->out_transaction_id);
                $transactionOut->title = $request->title;
                $transactionOut->date = $request->date;
                $transactionOut->account_id = $request->out_account;
                if($transactionOut->account_id == 0 ) {
                    $transactionOut->transaction_method = '1';
                }else{
                    $transactionOut->transaction_method = '2';
                }
                $transactionOut->amount = $request->amount;
                $transactionOut->note = $request->note;
                $transactionOut->cheque_number = $request->cheque_number;
                $transactionOut->updated_by = Auth::user()->id;
                $transactionOut->update();

                // In Transaction Account
                $transactionIn = Transaction::findOrFail($fund_transfer->in_transaction_id);
                $transactionIn->title = $request->title;
                $transactionIn->date = $request->date;
                $transactionIn->account_id = $request->in_account;
                if($transactionIn->account_id == 0 ) {
                    $transactionIn->transaction_method = '1';
                }else{
                    $transactionIn->transaction_method = '2';
                }
                $transactionIn->amount = $request->amount;
                $transactionIn->note = $request->note;
                $transactionIn->cheque_number = $request->cheque_number;
                $transactionIn->updated_by = Auth::user()->id;
                $transactionIn->update();

                // FundTransfer Store
                $fund_transfer->title = $request->title;
                $fund_transfer->date = $request->date;
                $fund_transfer->in_account = $request->in_account;
                $fund_transfer->in_transaction_id = $transactionIn->id;
                $fund_transfer->out_account = $request->out_account;
                $fund_transfer->out_transaction_id = $transactionOut->id;
                $fund_transfer->amount = $request->amount;
                $fund_transfer->updated_by = Auth::user()->id;
                $fund_transfer->update();

                DB::commit();
                return redirect()->route('fund-transfer.index')->with('t-success', 'Updated successfully.');
            }
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert-error', 'Operation failed ! ' . $exception->getMessage());
        }
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
            // FundTransfer Data Get
            $fundTransfer = FundTransfer::findOrFail($id);

            // Cash Out Transaction Delete
            $outTransactionId = Transaction::findOrFail($fundTransfer->out_transaction_id);
            $outTransactionId->updated_by = Auth::user()->id;
            $outTransactionId->delete();

            // Cash In Transaction Delete
            $inTransactionId = Transaction::findOrFail($fundTransfer->in_transaction_id);
            $inTransactionId->updated_by = Auth::user()->id;
            $inTransactionId->delete();

            $fundTransfer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item Deleted Successfully.',
            ]);
        }
    }
}
