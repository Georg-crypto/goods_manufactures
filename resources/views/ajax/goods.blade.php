

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
