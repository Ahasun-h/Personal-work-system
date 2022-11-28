<?php

namespace App\Http\Controllers\Web;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){

        // Get Setting Data
        $setting = Setting::latest('id')->first();

        return view('layout.setting.setting',compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingRequest $request){
        $setting = Setting::latest('id')->first();

        // Check Exit Of Setting
        if($setting == null){
            $setting = new Setting();
        }

        $setting->title = $request->title;
        $setting->address = $request->address;
        $setting->description = $request->description;

        // Upload Logo
        if(!empty($request['logo'])){
            if(empty($setting->logo)){
                // Upload New Logo
                $logo = Helper::fileUpload($request->logo,'setting','logo');

            }else{
                // Remove Old File
                @unlink(public_path('/') . $setting->logo);

                // Upload New Logo
                $logo = Helper::fileUpload($request->logo,'setting','logo');

            }
            $setting->logo = $logo;
        }

        // Upload Favicon
        if(!empty($request['favicon'])){
            if(empty($setting->favicon)){
                // Upload New Favicon
                $favicon = Helper::fileUpload($request->favicon,'setting','favicon');

            }else{
                // Remove Old File
                @unlink(public_path('/') . $setting->favicon);

                // Upload New Favicon
                $favicon = Helper::fileUpload($request->favicon,'setting','favicon');
            }
            $setting->favicon = $favicon;
        }
        $setting->save();
        return redirect()->route('setting')->with('t-success', 'Update successfully.');
    }
}
