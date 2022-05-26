
@extends('layouts.main')

@section('title', 'Товары')

@section('content')

        <h2>Товары</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="width: 30%;">
                Добавить товар
            </button>

            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Сортировать таблицу
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="dropdown-item goods_sorting" data-order="name-low-high" style="cursor: pointer;">Сортировать по имени (А-Я, A-Z)</li>
                    <li class="dropdown-item goods_sorting" data-order="name-high-low" style="cursor: pointer;">Сортировать по имени (Я-А, Z-A)</li>
                    <li class="dropdown-item goods_sorting" data-order="id-low-high" style="cursor: pointer;">Сортировать по ID (по возрастанию)</li>
                    <li class="dropdown-item goods_sorting" data-order="id-high-low" style="cursor: pointer;">Сортировать по ID (по убыванию)</li>
                </ul>
            </div>

        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Наименование товара</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody class="goods">
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

    @include('modals.addGoodModal')

@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            $(".goods_sorting").click(function () {
                let orderBy = $(this).data('order')
                $.ajax({
                    url: "{{ route('goods.index') }}",
                    type: "GET",
                    data: {
                        orderBy: orderBy
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        $('.goods').html(data)
                    }
                });
            })

            $("#addForm").submit(function (e) {
                e.preventDefault();
                let form = $(this).serialize();
                $.ajax({
                    url: '{{ route('goods.store') }}',
                    type: "POST",
                    data: form,
                    success: (data) => {
                        $('#addModal').modal('hide');
                        $('#addForm')[0].reset();
                        $('.goods').html(data)
                    },
                    error: function(data) {
                        // will display json of validation errors, which you'd loop through and display
                        console.log(data);
                    }
                });
                return false;
            })
        })
    </script>
@endsection



