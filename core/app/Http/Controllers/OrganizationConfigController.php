<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationConfigs\UpdateRequest;
use App\Models\OrganizationConfig;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrganizationConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $organizationConfig = OrganizationConfig::findOrFail(1);
        return view('organizations.index')->with('organization',$organizationConfig);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrganizationConfig  $organizationConfig
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationConfig $organizationConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganizationConfig  $organizationConfig
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $organizationConfig = OrganizationConfig::findOrFail($id);
        return view('organizations.index')->with('organization',$organizationConfig);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationConfig  $organizationConfig
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $organization = OrganizationConfig::findOrFail($id);
        $imageName = $organization->logo;
        try{
            
        $imageName = $organization->logo;   
        if($request->logo != null){
            $filename = pathinfo($request->logo->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = "logo". time() .".".$request->logo->extension();

            $request->logo->move(public_path('organization'), $imageName);
            $oldPath = public_path('organization/').$organization->logo;
            if(file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $data = $request->validated();  
        $data['logo'] = $imageName;
        $organization->update($data);
            return back()->with('success','Data Successfully updated');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganizationConfig  $organizationConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationConfig $organizationConfig)
    {
        //
    }
}
