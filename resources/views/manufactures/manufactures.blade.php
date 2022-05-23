
@extends('layouts.main')

@section('title', 'Производители')

@section('content')

        <h2>Производители</h2>

        <a type="button" class="btn btn-primary col-4" href="{{ route('manufactures.create') }}">Добавить производителя</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Наименование производителя</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            @foreach($manufactures as $manufacture)
                <tr>
                    <th scope="row">{{ $manufacture->id }}</th>
                    <td>{{ $manufacture->name }}</td>
                    <td>
                        <a type="button" class="btn btn-success" href="{{ route('manufactures.edit', $manufacture->id) }}">Изменить</a>
                        <form method="POST" action="{{ route('manufactures.destroy', $manufacture->id) }}" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger")>Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tr>
            </tbody>

        </table>

@endsection('content')

