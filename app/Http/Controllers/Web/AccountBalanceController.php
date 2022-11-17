<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountBalanceController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAccountBalance(Request $request,$id){
        if ($request->ajax()) {
            $balance = Accounts::postBalance($id);
            return response()->json($balance);
        }
    }
}
