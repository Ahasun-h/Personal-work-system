<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\StoreBankRequest;
use App\Http\Requests\Bank\UpdateBankRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banks = Bank::latest()->with('createdByUser')->get();
            return DataTables::of($banks)
                ->addIndexColumn()
                ->addColumn('status', function ($banks) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $banks->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $banks->id . '" getAreaid="' . $banks->id . '" name="status"';
                    if ($banks->status == 1) {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $banks->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })
                ->addColumn('description', function ($banks) {
                    return Str::limit($banks->description, 20, $end = '.....');
                })
                ->addColumn('action', function ($banks) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('bank.show', $banks->id) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('bank.edit', $banks->id) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $banks->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                                <i class="bx bxs-trash"></i>
                              </a>
                            </div>';
                })
                ->rawColumns(['action', 'status', 'description'])
                ->make(true);
        }
        return view('layout.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layout.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankRequest $request)
    {
        // Store Data in DataBase
        $data = new Bank();
        $data->bank_name = $request->bank_name;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('bank.index')->with('t-success', 'Add successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        return view('layout.bank.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('layout.bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request,Bank $bank)
    {
        $bank->bank_name = $request->bank_name;
        $bank->description = $request->description;
        $bank->status = $request->status;
        $bank->updated_by = Auth::user()->id;
        $bank->update();

        return redirect()->route('bank.index')->with('t-success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {
            Bank::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Item Deleted Successfully.',
            ]);
        }
    }


    /**
     * Change Data the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id){
        $bank = Bank::findOrfail($id);
        // Check Item Current Status
        if ($bank->status == 1) {
            $bank->status = 0;
            $bank->updated_by = Auth::user()->id;
            $bank->update();
            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
            ]);
        } else {
            $bank->status = 1;
            $bank->updated_by = Auth::user()->id;
            $bank->update();
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
            ]);
        }
    }
}
