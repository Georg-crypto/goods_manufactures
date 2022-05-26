<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditManufacturesFormRequest;
use App\Models\Good;
use App\Models\GoodManufacture;
use App\Models\Manufacture;
use App\Services\ManufacturesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManufacturesController extends Controller
{
    public function __construct(ManufacturesService $manufacturesService)
    {
        $this->service = $manufacturesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(Request $request): string
    {
        if(isset($request->orderBy)) {
            $manufactures = $this->service->orderBy($request);
        }

        if($request->ajax()) {
            return view('ajax.manufactures', [
                'manufactures' => $manufactures
            ])->render();
        }

        $manufactures = $this->service->manufacturesAll();
        $goods = $this->service->goodsAll();

        return view('manufactures.manufactures', [
            'manufactures' => $manufactures,
            'goods' => $goods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create(): string
    {
        $goods = $this->service->goodsAll();

        return view('manufactures.manufactures_form', [
            'goods' => $goods
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

            $checkManufactureNames = $this->service->checkManufactureNames();

            foreach ($checkManufactureNames as $manufactureName) {
                if($manufactureName->name == $request->name) {
                    return view('ajax.manufactures', [
                        'manufactures' => $checkManufactureNames
                    ])->render();
                }
            }

            $manufacture = $this->service->manufactureCreate($request);

            $insertedId = $manufacture->id;

            foreach ($request->goods as $key => $value) {
                $this->service->goodManufactureCreate($value, $insertedId);
            }

            $manufactures = $this->service->manufacturesAll();

            return view('ajax.manufactures', [
                'manufactures' => $manufactures
            ])->render();
        }
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
     * @param  Manufacture $manufacture
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Manufacture $manufacture): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {

        $id = $manufacture->id;

        $selectedGoods = $this->service->selectedGoods($id);

        $goods = $this->service->goodsAll();

        return view('manufactures.manufactures_form', [
            'goods' => $goods,
            'manufacture' => $manufacture,
            'selectedGoods' => $selectedGoods
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Manufacture $manufacture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EditManufacturesFormRequest $request, Manufacture $manufacture): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        if($validated['name'] === $manufacture->name) {
            return redirect()->route('manufactures.index')->with('error', 'Название фабрики не изменено');
        }

        $manufactureNames = $this->service->manufactureNames();

        foreach ($manufactureNames as $manufactureName) {
            if($manufactureName->name == $validated['name']) {
                return redirect()->route('manufactures.index')->with('error', 'Такая фабрика уже существует');
            }
        }

        $id = $manufacture->id;

        $this->service->manufacturesUpdate($id, $validated);

        $this->service->deleteGoodManufacture($id);

        foreach ($validated['goods'] as $key => $value) {
            $this->service->createGoodManufacture($id, $value);
        }

        return redirect()->route('manufactures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Manufacture $manufacture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Manufacture $manufacture): \Illuminate\Http\RedirectResponse
    {
        $manufacture->delete();

        return redirect()->route('manufactures.index');
    }
}
