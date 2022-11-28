<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use yajra\Datatables\Datatables;

class BranchController extends Controller
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
            $branchs = Branch::latest()->with(['bank','createdByUser'])->get();
            return DataTables::of($branchs)
                ->addIndexColumn()
                ->addColumn('status', function ($branchs) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $branchs->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $branchs->id . '" getAreaid="' . $branchs->id . '" name="status"';
                    if ($branchs->status == 1) {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $branchs->id . '" class="form-check-label" for="customSwitch"></label></div>';
                    return $status;
                })
                ->addColumn('action', function ($branchs) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('branch.show', Crypt::encrypt($branchs->id)) . '" type="button" class="btn btn-info text-white" title="Edit">
                                <i class="bx bx-show"></i>
                              </a>
                              <a href="' . route('branch.edit', Crypt::encrypt($branchs->id)) . '" type="button" class="btn btn-success text-white" title="Edit">
                                <i class="bx bxs-edit"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $branchs->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                                <i class="bx bxs-trash"></i>
                              </a>
                            </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('layout.branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Get All Bank
        $banks = Bank::where('status',1)->get();
        return view('layout.branch.create',compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBranchRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBranchRequest $request)
    {
        // Store Data in DataBase
        $data = new Branch();
        $data->bank_id = $request->bank_id;
        $data->branch_name = $request->branch_name;
        $data->address = $request->address;
        $data->status = $request->status;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('branch.index')->with('t-success', 'Add successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {

        // Get Selected Branch Data
        $branch = Branch::findOrFail(Crypt::decrypt($id));

        return view('layout.branch.show',compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        //Get All Bank Data
        $banks = Bank::all();
        // Get Selected Branch Data
        $branch = Branch::findOrFail(Crypt::decrypt($id));

        return view('layout.branch.edit',compact('banks','branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBranchRequest $request
     * @param Branch $branch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->bank_id = $request->bank_id;
        $branch->branch_name = $request->branch_name;
        $branch->address = $request->address;
        $branch->status = $request->status;
        $branch->updated_by = Auth::user()->id;
        $branch->update();

        return redirect()->route('branch.index')->with('t-success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {
            Branch::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Item Deleted Successfully.',
            ]);
        }
    }

    /**
     * Change Data the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id){
        $branch = Branch::findOrfail($id);
        // Check Item Current Status
        if ($branch->status == 1) {
            $branch->status = 0;
            $branch->updated_by = Auth::user()->id;
            $branch->update();
            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
            ]);
        } else {
            $branch->status = 1;
            $branch->updated_by = Auth::user()->id;
            $branch->update();
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
            ]);
        }
    }
}
