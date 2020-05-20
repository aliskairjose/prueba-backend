<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreCollection;
use App\Picture;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = new StoreCollection(Store::all());

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


        if ($request->hasFile('picture_2')) {
            $path_2 = $request->file('picture_2');
            $name_2 = $path_2->getClientOriginalName();
            \Storage::disk('public')->put($name_2, \File::get($path_2));
        }
        if ($request->hasFile('picture_1')) {
            $path_1 = $request->file('picture_1');
            $name_1 = $path_1->getClientOriginalName();
            \Storage::disk('public')->put($name_1, \File::get($path_1));
        };

        if ($request->hasFile('picture_0')) {
            $path_0 = $request->file('picture_0');
            $name_0 = $path_0->getClientOriginalName();
            \Storage::disk('public')->put($name_0, \File::get($path_0));

            Picture::create(
                [
                    'store_id' => $store->id,
                    'picture_1' => $name_0,
                    'picture_2' => $name_1,
                    'picture_3' => $name_2
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

    public function getImage($filename){
        $file = \Storage::disk('public')->get($filename);

        return new Response($file);
    }
}
