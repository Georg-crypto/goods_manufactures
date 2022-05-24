

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ isset($manufacture) ? 'Изменение' : 'Добавление' }} производителя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ isset($manufacture)? route('manufactures.update', $manufacture->id) : route('manufactures.store') }}" id="addForm">
                    @csrf
                    @if (isset($manufacture))
                    @method('PUT')
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary" style="width: 40%;">
                            {{ isset($manufacture) ? 'Изменить' : 'Добавить' }}
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
