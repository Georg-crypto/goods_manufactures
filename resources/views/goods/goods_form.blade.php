
@extends('layouts.main')

@section('title', isset($good) ? 'Изменение товара' : 'Добавление товара')

@section('content')

    <h3>{{ isset($good) ? 'Изменение' : 'Добавление' }} товара</h3>

    <form method="post" action="{{ isset($good)? route('goods.update', $good->id) : route('goods.store') }}">
        @csrf
        @if (isset($good))
            @method('PUT')
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label class="form-label">Наименование товара</label>
        <div class="mb-3">
            <input type="text" class="form-control" name="name" value="{{ isset($good) ? $good->name : '' }}">
        </div>
        <label class="form-label">Фабрика(и), производящая(ие) данный товар</label>
        <select class="form-select" multiple name="manufactures[]">
            @foreach($manufactures as $manufacture)
                    <option
                    @if (isset($selectedManufactures))
                        @foreach($selectedManufactures as $selectedManufacture)
                {{ (isset($good) && $manufacture->id == $selectedManufacture->id && $manufacture->name == $selectedManufacture->name) ? 'selected' : '' }}
                        @endforeach
                    @endif
                    value="{{ $manufacture->id }}">{{ $manufacture->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary mt-2">
            {{ isset($good) ? 'Изменить' : 'Добавить' }}
        </button>
    </form>

@endsection
