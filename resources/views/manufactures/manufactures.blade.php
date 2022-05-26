
@extends('layouts.main')

@section('title', 'Производители')

@section('content')

        <h2>Производители</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between">
{{--            <a type="button" class="btn btn-primary col-4" href="{{ route('manufactures.create') }}">Добавить производителя</a>--}}

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="width: 30%;">
                Добавить производителя
            </button>

            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Сортировать таблицу
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="dropdown-item manufactures_sorting" data-order="name-low-high" style="cursor: pointer;">Сортировать по имени (А-Я, A-Z)</li>
                    <li class="dropdown-item manufactures_sorting" data-order="name-high-low" style="cursor: pointer;">Сортировать по имени (Я-А, Z-A)</li>
                    <li class="dropdown-item manufactures_sorting" data-order="id-low-high" style="cursor: pointer;">Сортировать по ID (по возрастанию)</li>
                    <li class="dropdown-item manufactures_sorting" data-order="id-high-low" style="cursor: pointer;">Сортировать по ID (по убыванию)</li>
                </ul>
            </div>

        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Наименование производителя</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody class="manufactures">
            @foreach($manufactures as $manuf)
                <tr>
                    <th scope="row">{{ $manuf->id }}</th>
                    <td>{{ $manuf->name }}</td>
                    <td>
                        <a type="button" class="btn btn-success" href="{{ route('manufactures.edit', $manuf->id) }}">Изменить</a>
                        <form method="POST" action="{{ route('manufactures.destroy', $manuf->id) }}" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger")>Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        @include('modals.addManufactureModal')

@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            $(".manufactures_sorting").click(function () {
                let orderBy = $(this).data('order')
                $.ajax({
                    url: "{{ route('manufactures.index') }}",
                    type: "GET",
                    data: {
                        orderBy: orderBy
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        $('.manufactures').html(data)
                    }
                });
            })

            $("#addForm").submit(function (e) {
                e.preventDefault();
                let form = $(this).serialize();
                $.ajax({
                    url: '{{ route('manufactures.store') }}',
                    type: "POST",
                    data: form,
                    success: (data) => {
                        $('#addModal').modal('hide');
                        $('#addForm')[0].reset();
                        $('.manufactures').html(data)
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

