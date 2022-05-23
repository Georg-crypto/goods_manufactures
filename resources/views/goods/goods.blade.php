
@extends('layouts.main')

@section('title', 'Товары')

@section('content')

        <h2>Товары</h2>

        <a type="button" class="btn btn-primary col-4" href="{{ route('goods.create') }}">Добавить товар</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Наименование товара</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($goods as $product)
            <tr>
                <th scope="row">{{ $product->id }}</th>
                <td>{{ $product->name }}</td>
                <td>
                    <a type="button" class="btn btn-success" href="{{ route('goods.edit', $product->id) }}">Изменить</a>
                    <form method="POST" action="{{ route('goods.destroy', $product->id) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger")>Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>

@endsection('content')



