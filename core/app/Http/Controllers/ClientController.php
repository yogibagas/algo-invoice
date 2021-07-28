<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\StoreRequest;
use App\Http\Requests\Clients\UpdateRequest;
use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $model)
    {
        //
        return view('clients.index', ['clients' => $model->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $model)
    {
        //
        $client = new $model;
        return view('clients.form')->with('client',$client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //
        // dd($request->validated());
        try{
            $data = $request->validated();
            $client = Client::updateOrCreate($data);

            return redirect()->route('client.edit',$client)->with('success','Data successfully added');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())->with('client',$request->validated());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $client = Client::findOrFail($id);
        // dd($client);
        return view('clients.form')->with('client',$client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Client $client)
    {
        //
        // dd($client->toArray());
        try{
            $data = $request->validated();
            $client->update($data);

            return redirect()->route('client.edit',$client)->with('success','Data successfully updated');
        }catch(\Exception $err){
            return back()->with('failed', 'Error! ' . $err->getMessage())
            ->with('client',$request->validated());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
