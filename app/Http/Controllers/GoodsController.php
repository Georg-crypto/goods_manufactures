<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditGoodsFormRequest;
use App\Models\Good;
use App\Models\GoodManufacture;
use App\Models\Manufacture;
use App\Services\GoodsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class GoodsController extends Controller
{

    public function __construct(GoodsService $goodsService)
    {
        $this->service = $goodsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(Request $request): string
    {

        if(isset($request->orderBy)) {
            $goods = $this->service->orderBy($request);
        }

        if($request->ajax()) {
            return view('ajax.goods', [
                'goods' => $goods
            ])->render();
        }

        $goods = $this->service->goodsAll();
        $manufactures = $this->service->manufacturesAll();

        return view('goods.goods', [
            'goods' => $goods,
            'manufactures' => $manufactures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create(): string
    {
        $manufactures = $this->service->manufacturesAll();

        return view('goods.goods_form', [
            'manufactures' => $manufactures
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request): string
    {
        if($request->ajax()) {

                $checkGoodNames = $this->service->checkGoodNames();

                foreach ($checkGoodNames as $goodName) {
                    if($goodName->name == $request->name) {
                        return view('ajax.goods', [
                            'goods' => $checkGoodNames
                        ])->render();
                    }
                }

                $good = $this->service->goodCreate($request);

                $insertedId = $good->id;

                foreach ($request->manufactures as $key => $value) {
                    $this->service->goodManufactureCreate($insertedId, $value);
                }

                $goods = $this->service->goodsAll();

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Good $good): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {

        $id = $good->id;

        $selectedManufactures = $this->service->selectedManufactures($id);

        $manufactures = $this->service->manufacturesAll();

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EditGoodsFormRequest $request, Good $good): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        if($validated['name'] === $good->name) {
            return redirect()->route('goods.index')->with('error', 'Название товара не изменено');
        }

        $goodNames = $this->service->goodNames();

        foreach ($goodNames as $goodName) {
            if($goodName->name == $validated['name']) {
                return redirect()->route('goods.index')->with('error', 'Такой товар уже существует');
            }
        }

        $id = $good->id;

        $this->service->goodsUpdate($id, $validated);

        $this->service->deleteGoodManufacture($id);

        foreach ($validated['manufactures'] as $key => $value) {
            $this->service->createGoodManufacture($id, $value);
        }

        return redirect()->route('goods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Good $good
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Good $good): \Illuminate\Http\RedirectResponse
    {
        $good->delete();

        return redirect()->route('goods.index');
    }
}
