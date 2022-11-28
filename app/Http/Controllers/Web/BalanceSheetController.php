<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use yajra\Datatables\Datatables;

class BalanceSheetController extends Controller
{
    /**
     * Display a listing of Accounts balance and other information.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function accountBalanceSheet(Request $request)
    {
        if($request->ajax()){
            $debit = 0;
            $credit = 0;
            $postBalance = 0;
            $transactions = Transaction::groupBy('account_id')->get();

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('account_info', function ($transactions) {
                    if($transactions->account_id == 0){
                        return 'Cash | A-0001';
                    }else{
                       $account = Account::findOrFail($transactions->account_id);
                        return $account->account_number . ' | ' . $account->account_holder_name;
                    }

                })
                ->addColumn('debit', function ($transactions) use (&$debit) {
                    $debit = Accounts::debitBalance($transactions->account_id);
                    return $debit;
                })
                ->addColumn('credit', function ($transactions) use (&$credit) {
                    $credit = Accounts::creditBalance($transactions->account_id);
                    return $credit;
                })
                ->addColumn('balance', function ($transactions) use (&$debit, &$credit) {
                    return $credit - $debit;
                })
                ->addColumn('action', function ($transactions) {

                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('account.statement',$transactions->account_id) . '" type="button" class="btn btn-info text-white" title="Edit">
                                    <i class="bx bx-show"></i>
                                  </a>
                            </div>';
                })
                ->rawColumns(['action', 'account_info','debit','credit','balance'])
                ->make(true);
        }
        return view('layout.balance-sheet.account-balance-sheet');
    }

    /**
     * Display a specified of Accounts balance and other information.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function accountStatement(Request $request,$id){

        if($request->ajax()){
            // date
            if($request->start_date == null && $request->end_date == null){
                $startDate = Carbon::now()->firstOfMonth();
                $endDate =  Carbon::now()->lastOfMonth();
            }else{
                $startDate = $request->start_date;
                $endDate = $request->end_date;
            }

            $debit = Accounts::previousDebitBalance($id,$startDate);
            $credit = Accounts::previousCreditBalance($id,$startDate);

            // Previous Balance
            $previousBalance = Accounts::previousPostBalance($id,$startDate);
            $previousDebit = $debit;
            $previousCredit = $credit;

            $transactions = Transaction::where('account_id',$id)
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->get();

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('account_info', function ($transactions) {
                    if($transactions->account_id == 0){
                        return 'Cash | A-0001';
                    }else{
                        $account = Account::findOrFail($transactions->account_id);
                        return $account->account_number . ' | ' . $account->account_holder_name;
                    }
                })
                ->addColumn('transaction_type', function ($transactions) {
                    if($transactions->transaction_type == 0){
                        return '<span class="text-success text-bold">Initial Balance</span>';
                    } else if ($transactions->transaction_type == 1) {
                        return '<span class="text-danger text-bold">Withdraw</span>';
                    } else if ($transactions->transaction_type == 2) {
                        return '<span class="text-success text-bold">Deposit</span>';
                    } else if ($transactions->transaction_type == 3) {
                        return '<span class="text-success text-bold">Revenue</span>';
                    } else if ($transactions->transaction_type == 5) {
                        return '<span class="text-danger text-bold">Expense</span>';
                    } else if ($transactions->transaction_type == 6) {
                        return '<span class="text-success text-bold">Fund-Transfer (Cash-In)</span>';
                    } else if ($transactions->transaction_type == 7) {
                        return '<span class="text-danger text-bold">Fund-Transfer (Cash-Out)</span>';
                    } else {
                        return '...';
                    }
                })
                ->addColumn('amount',function ($transactions){
                    if($transactions->type == 1){
                        return '<span class="text-danger text-bold">'.$transactions->amount.'</span>';
                    }else{
                        return '<span class="text-success text-bold">'.$transactions->amount.'</span>';
                    }
                })
                ->addColumn('debit', function ($transactions) use (&$debit) {
                    if($transactions->type == 1){
                        $debit = $transactions->amount + $debit;
                    }else{
                        $debit;
                    }
                    return $debit;
                })
                ->addColumn('credit', function ($transactions) use (&$credit) {
                    if($transactions->type == 2){
                        $credit = $transactions->amount + $credit;
                    }else{
                        $credit;
                    }
                    return $credit;
                })
                ->addColumn('balance', function ($transactions) use (&$debit, &$credit) {
                    return $credit - $debit;
                })
                ->with('previous_balance',$previousBalance)
                ->with('previous_debit',$previousDebit)
                ->with('previous_credit',$previousCredit)
                ->rawColumns(['action', 'account_info','debit','credit','balance','transaction_type','amount'])
                ->make(true);
        }

        $idAccount = $id;

        return view('layout.balance-sheet.account_statement',compact('idAccount'));
    }


}
