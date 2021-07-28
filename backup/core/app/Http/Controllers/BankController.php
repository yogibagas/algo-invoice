<?php

namespace App\Http\Controllers;

use App\Http\Requests\Banks\StoreRequest;
use App\Http\Requests\Banks\UpdateRequest;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $bank = Bank::paginate(10);
        return view('bank.index')->with('banks',$bank);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $bank= new Bank();
        return view('bank.form')->with('model',$bank);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try{
            $data = $request->validated();
            $model = Bank::updateOrCreate($data);
            return redirect()->route('bank.edit',$model)->with('success','Data successfully added');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())
            ->with('model',$request->validated());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = Bank::findOrFail($id);
        return view('bank.form')->with('model',$model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Bank $bank)
    {
        //
        try{
            $data = $request->validated();
            $model = $bank->update($data);
            return redirect()->route('bank.edit',$model)->with('success','Data successfully edited');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())
            ->with('model',$request->validated());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }
    public function softDelete($id){
        return true;
    }
}
