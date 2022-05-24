

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
