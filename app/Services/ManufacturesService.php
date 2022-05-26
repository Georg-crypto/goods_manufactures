<?php

namespace App\Services;

use App\Models\Good;
use App\Models\GoodManufacture;
use App\Models\Manufacture;
use Illuminate\Support\Facades\DB;

/**
 * Class ManufacturesService.
 */
class ManufacturesService
{
    public function orderBy($request): \Illuminate\Support\Collection
    {
        if($request->orderBy == 'name-low-high') {
            $manufactures = DB::table('manufactures')->orderBy('name')->get();
        }
        if($request->orderBy == 'name-high-low') {
            $manufactures = DB::table('manufactures')->orderBy('name', 'desc')->get();
        }
        if($request->orderBy == 'id-low-high') {
            $manufactures = DB::table('manufactures')->orderBy('id')->get();
        }
        if($request->orderBy == 'id-high-low') {
            $manufactures = DB::table('manufactures')->orderBy('id', 'desc')->get();
        }

        return $manufactures;
    }

    public function manufacturesAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Manufacture::all();
    }

    public function goodsAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Good::all();
    }

    public function manufactureCreate($validator)
    {
        return Manufacture::create([
            'name' => $validator['name']
        ]);
    }

    public function goodManufactureCreate(int $value, int $insertedId)
    {
        return GoodManufacture::create([
            'good_id' => $value,
            'manufacture_id' => $insertedId
        ]);
    }

    public function selectedGoods(int $id): \Illuminate\Support\Collection
    {
        return DB::table('goods')
            ->select('goods.id', 'goods.name')
            ->leftJoin('good_manufacture', 'goods.id', '=', 'good_manufacture.good_id')
            ->where('good_manufacture.manufacture_id', '=', $id)
            ->get();
    }

    public function manufactureNames(): \Illuminate\Support\Collection
    {
        return DB::table('manufactures')
            ->select('name')
            ->get();
    }

    public function manufacturesUpdate(int $id, array $validated): int
    {
        return DB::table('manufactures')
            ->where('id', $id)
            ->update(['name' => $validated['name']]);
    }

    public function deleteGoodManufacture(int $id): int
    {
        return DB::table('good_manufacture')->where('manufacture_id', '=', $id)->delete();
    }

    public function createGoodManufacture(int $id, int $value)
    {
        return GoodManufacture::create([
            'good_id' => $value,
            'manufacture_id' => $id
        ]);
    }
}
