<?php

namespace App\Services;

use App\Models\Good;
use App\Models\GoodManufacture;
use App\Models\Manufacture;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Collection;

/**
 * Class GoodsService.
 */
class GoodsService
{
    public function orderBy($request): \Illuminate\Support\Collection
    {
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

        return $goods;
    }

    public function goodsAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Good::all();
    }

    public function manufacturesAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Manufacture::all();
    }

    public function goodCreate($validator)
    {
        return Good::create([
            'name' => $validator['name']
        ]);
    }

    public function goodManufactureCreate(int $insertedId, int $value)
    {
        return GoodManufacture::create([
            'good_id' => $insertedId,
            'manufacture_id' => $value
        ]);
    }

    public function selectedManufactures(int $id): \Illuminate\Support\Collection
    {
        return DB::table('manufactures')
            ->select('manufactures.id', 'manufactures.name')
            ->leftJoin('good_manufacture', 'manufactures.id', '=', 'good_manufacture.manufacture_id')
            ->where('good_manufacture.good_id', '=', $id)
            ->get();
    }

    public function goodNames(): \Illuminate\Support\Collection
    {
        return DB::table('goods')
            ->select('name')
            ->get();
    }

    public function goodsUpdate(int $id, array $validated): int
    {
        return DB::table('goods')
            ->where('id', $id)
            ->update(['name' => $validated['name']]);
    }

    public function deleteGoodManufacture(int $id): int
    {
        return DB::table('good_manufacture')->where('good_id', '=', $id)->delete();
    }

    public function createGoodManufacture(int $id, int $value)
    {
        return GoodManufacture::create([
            'good_id' => $id,
            'manufacture_id' => $value
        ]);
    }
}
