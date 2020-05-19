<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Picture;
use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();

        return response()->json(
            [
                'isSuccess' => true,
                'objects' => $stores,
                'count' => $stores->count()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path_0 = '';
        $path_1 = '';
        $path_2 = '';
        $store = Store::create(
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ]
        );


        if ($request->hasFile('picture_2')) $path_2 = $request->picture_2->store('public/images');
        if ($request->hasFile('picture_1')) $path_1 = $request->picture_1->store('public/images');

        if ($request->hasFile('picture_0')) {
            $path_0 = $request->picture_0->store('public/images');
            Picture::create(
                [
                    'store_id' => $store->id,
                    'picture_1' => $path_0,
                    'picture_2' => $path_1,
                    'picture_3' => $path_2
                ]
            );
        }

        return response()->json(
            [
                'isSuccess' => true,
                'message' => 'Se ha guardado nueva tienda',
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
