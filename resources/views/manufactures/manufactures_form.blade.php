
@extends('layouts.main')

@section('title', isset($manufacture) ? 'Изменение производителя' : 'Добавление производителя')

@section('content')

    <h3>{{ isset($manufacture) ? 'Изменение' : 'Добавление' }} производителя</h3>

    <form method="post" action="{{ isset($manufacture)? route('manufactures.update', $manufacture->id) : route('manufactures.store') }}">
        @csrf
        @if (isset($manufacture))
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
        <label class="form-label">Наименование производителя</label>
        <div class="mb-3">
            <input type="text" class="form-control" name="name" value="{{ isset($manufacture) ? $manufacture->name : '' }}">
        </div>
        <label class="form-label">Товар(ы), которые производит данная фабрика</label>
        <select class="form-select" multiple name="goods[]">
            @foreach($goods as $good)
                <option
                    @if (isset($selectedGoods))
                    @foreach($selectedGoods as $selectedGood)
                    {{ (isset($manufacture) && $good->id == $selectedGood->id && $good->name == $selectedGood->name) ? 'selected' : '' }}
                    @endforeach
                    @endif
                    value="{{ $good->id }}">{{ $good->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">
            {{ isset($manufacture) ? 'Изменить' : 'Добавить' }}
        </button>
    </form>

@endsection('content')
