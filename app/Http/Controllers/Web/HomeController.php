<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Total Account Sum
        $bankAccount = Account::all()->count();

        // Total Bank Account Balance
        $debit = Transaction::where('type',1)->sum('amount');
        $credit = Transaction::where('type',2)->sum('amount');
        $balance = $credit - $debit;


        // Get Current Year Total Debit
        $debitValue = Transaction::where('deleted_at',null)
            ->select(DB::raw("COUNT(*) as count ,  MONTHNAME(date) as month, type" ))
            ->orderBy("date")
            ->groupBy(DB::raw("month(date)"))
            ->groupBy('type')
            ->get()
            ->toArray();


        $debit_array = [];
        $credit_array = [];
        $month = [];

        foreach($debitValue as $data){
            if($data['type'] == 1){
                array_push($debit_array,$data['count']);
                if($data['month'] == null){
                    array_push($month,$data['month']);
                }elseif(!in_array($data['month'], $month)) {
                    array_push($month,$data['month']);
                }
            }elseif ($data['type'] == 2){
                array_push($credit_array,$data['count']);
                if($data['month'] == null){
                    array_push($month,$data['month']);
                }elseif(!in_array($data['month'], $month)) {
                    array_push($month,$data['month']);
                }
            }
        }

        return view('layout.dashboard.dashboard',compact('bankAccount','debit','credit','balance','debit_array','credit_array','month'));
    }
}
