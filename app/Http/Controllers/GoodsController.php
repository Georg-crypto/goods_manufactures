<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\GoodManufacture;
use App\Models\Manufacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(isset($request->orderBy)) {
            if($request->orderBy == 'name-low-high') {
                $goods = DB::table('goods')->orderBy('name')->get();
            }
            if($request->orderBy == 'name-high-low') {
                $goods = DB::table('goods')->orderBy('name', 'desc')->get();
            }
            if($request->orderBy == 'id-low-high') {
                $goods = DB::table('goods')->orderBy('id')->get();
            }
            if($request->orderBy == 'id-high-low') {
                $goods = DB::table('goods')->orderBy('id', 'desc')->get();
            }
        }

        if($request->ajax()) {
            return view('ajax.goods', [
                'goods' => $goods
            ])->render();
        }

        $goods = Good::all();
        $manufactures = Manufacture::all();

        return view('goods.goods', [
            'goods' => $goods,
            'manufactures' => $manufactures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manufactures = Manufacture::all();

        return view('goods.goods_form', [
            'manufactures' => $manufactures
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()) {
            $good = Good::create([
                'name' => $request->name
            ]);

            $insertedId = $good->id;

            foreach ($request->manufactures as $key => $value) {
                GoodManufacture::create([
                    'good_id' => $insertedId,
                    'manufacture_id' => $value
                ]);
            }

            $goods = Good::all();

            return view('ajax.goods', [
                'goods' => $goods
            ])->render();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Good $good
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Good $good
     * @return \Illuminate\Http\Response
     */
    public function edit(Good $good)
    {
        $id = $good->id;

        $selectedManufactures = DB::table('manufactures')
            ->select('manufactures.id', 'manufactures.name')
            ->leftJoin('good_manufacture', 'manufactures.id', '=', 'good_manufacture.manufacture_id')
            ->where('good_manufacture.good_id', '=', $id)
            ->get();

        $manufactures = Manufacture::all();

        return view('goods.goods_form', [
            'good' => $good,
            'manufactures' => $manufactures,
            'selectedManufactures' => $selectedManufactures
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Good $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Good $good)
    {
        $id = $good->id;

        DB::table('goods')
            ->where('id', $id)
            ->update(['name' => $request->name]);

        DB::table('good_manufacture')->where('good_id', '=', $id)->delete();

        foreach ($request->manufactures as $key => $value) {
            GoodManufacture::create([
                'good_id' => $id,
                'manufacture_id' => $value
            ]);
        }

        return redirect()->route('goods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Good $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        $good->delete();

        return redirect()->route('goods.index');
    }
}
