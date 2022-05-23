
@extends('layouts.main')

@section('title', 'Главная')

@section('content')

    <h2>Главная</h2>

    <div class="d-flex justify-content-between">
        <div class="col-5">
            <h4>Товары</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Наименование товара</th>
                    <th scope="col">Фабрика(и)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($goods as $good)
                <tr>
                    <th scope="row">{{ $good->id }}</th>
                    <td>{{ $good->name }}</td>
                    <td>
                        @foreach($good->manufactures as $manufacture)
                            {{ $manufacture->name }}<br>
                            ------<br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="col-5">
            <h4>Производители</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Наименование фабрики</th>
                    <th scope="col">Товар(ы)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($manufactures as $manufacture)
                    <tr>
                        <th scope="row">{{ $manufacture->id }}</th>
                        <td>{{ $manufacture->name }}</td>
                        <td>
                            @foreach($manufacture->goods as $good)
                                {{ $good->name }}<br>
                                ------<br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    </div>

@endsection('content')



