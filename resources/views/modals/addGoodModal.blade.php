

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ isset($good) ? 'Изменение' : 'Добавление' }} товара</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="post" action="{{ isset($good)? route('goods.update', $good->id) : route('goods.store') }}" id="addForm">
                    @csrf
                    @if (isset($good))
                        @method('PUT')
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary" style="width: 40%;">
                            {{ isset($good) ? 'Изменить' : 'Добавить' }}
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
