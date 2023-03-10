<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();

        return response([
            'menus' => MenuResource::collection($menus),
            'message' => 'Data berhasil ditampilkan',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(), 'Cek Inputan Field']);
        }

        $menu = Menu::create($data);
        return response([
            'menu' => new MenuResource($menu),
            'message' => 'Data Menu Berhasil Ditambahkan'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return response([
            'menu' => new MenuResource($menu),
            'message' => 'Data Menu Berhasil Diambil'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->update($request->all());

        return response([
            'menu' => new MenuResource($menu),
            'message' => 'Data Menu Berhasil Diubah'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response([
            'message' => 'Data Menu Berhasil Dihapus'
        ], 200);
    }
}
