<?php

namespace App\Http\Controllers\Web;

use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use yajra\Datatables\Datatables;

class AccountController extends Controller
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
            $accounts = Account::latest()->with(['branch','createdByUser'])->get();
            return DataTables::of($accounts)
                ->addIndexColumn()
                ->addColumn('status', function ($accounts) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $accounts->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $accounts->id . '" getAreaid="' . $accounts->id . '" name="status"';
                    if ($accounts->status == 1) {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $accounts->id . '" class="form-check-label" for="customSwitch"></label></div>';
                    return $status;
                })
                ->addColumn('default_account', function ($accounts) {
                    $default_account = ' <div class="form-check form-switch">';
                    $default_account .= ' <input onclick="showDefaultAccountSetAlert(' . $accounts->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $accounts->id . '" getAreaid="' . $accounts->id . '" name="status"';
                    if ($accounts->is_default == 1) {
                        $default_account .= "checked";
                    }
                    $default_account .= '><label for="customSwitch' . $accounts->id . '" class="form-check-label" for="customSwitch"></label></div>';
                    return $default_account;
                })
                ->addColumn('action', function ($accounts) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('account.show',Crypt::encrypt($accounts->id)) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('account.edit',Crypt::encrypt($accounts->id)) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                            </div>';
                })
                ->addColumn('bank_and_branch', function ($accounts) {
                    return $accounts->branch->branch_name.'|'.$accounts->branch->bank->bank_name;
                })
                ->addColumn('balance', function ($accounts) {
                    return Accounts::postBalance($accounts->id);
                })
                ->rawColumns(['action', 'status','default_account','balance','bank_and_branch'])
                ->make(true);
        }
        return view('layout.account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Get All Branch
        $branchs = Branch::where('status',1)->get();
        return view('layout.account.create',compact('branchs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAccountRequest $request)
    {
        DB::beginTransaction();
        try {
            // Bank Account Store
            $account = new Account();
            $account->branch_id = $request->branch_id;
            $account->account_number = $request->account_number;
            $account->account_holder_name = $request->account_holder_name;
            $account->is_default = $request->is_default;
            $account->status = $request->status;
            $account->note = $request->note;
            $account->created_by = Auth::user()->id;
            $account->save();

            // Transaction Store
            $transaction = new Transaction();
            $transaction->title = 'Initial Balance Deposit';
            $transaction->date = Carbon::now();
            $transaction->account_id = $account->id;
            $transaction->transaction_method = 2;
            $transaction->transaction_type = 0;
            $transaction->type = 2;
            $transaction->amount = $request->amount;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->created_by = Auth::user()->id;
            $transaction->save();

            DB::commit();
            return redirect()->route('account.index')->with('t-success', 'Add successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('alert-error', 'Operation failed for an internal error!');
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
        // Get Selected Account Data
        $account = Account::findOrFail(Crypt::decrypt($id));
        return view('layout.account.show',compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        // Get All Branch
        $branchs = Branch::all();
        // Get Selected Account Data
        $account = Account::findOrFail(Crypt::decrypt($id));
        return view('layout.account.edit',compact('branchs','account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccountRequest $request
     * @param Account $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->branch_id = $request->branch_id;
        $account->account_number = $request->account_number;
        $account->account_holder_name = $request->account_holder_name;
        $account->is_default = $request->is_default;
        $account->status = $request->status;
        $account->note = $request->note;
        $account->updated_by = Auth::user()->id;
        $account->update();

        return redirect()->route('account.index')->with('t-success', 'Updated successfully.');
    }

    /**
     * Change Data the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id){
        $account = Account::findOrfail($id);
        // Check Item Current Status
        if ($account->status == 1) {
            $account->status = 0;
            $account->updated_by = Auth::user()->id;
            $account->update();
            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
            ]);
        } else {
            $account->status = 1;
            $account->updated_by = Auth::user()->id;
            $account->update();
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
            ]);
        }
    }
    
    /**
     * Change Data the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function defaultAccountUpdate(Request $request,$id){
        if($request->ajax()){
            Account::where('is_default', 1)->update(['is_default' => 0]);
            Account::where('id', $id)->update(['is_default' => 1]);
            return response()->json([
                'success' => true,
                'message' => 'Default account set Successfully.',
            ]);
        }
    }


}
