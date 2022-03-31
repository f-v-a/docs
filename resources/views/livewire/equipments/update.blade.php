<x-card blur title="Редактировать данные">
    <div class="grid grid-cols-5 gap-4">
        <div class="field col-span-5">
            <x-textarea wire:model.defer="description" label="Описание" placeholder="Описание оборудования" />
        </div>
        <div class="field col-span-5">
            @if ($isShow)
                <x-input label="Наименование" wire:model.defer="name" disabled/>
            @else
                <x-input label="Наименование" placeholder="Формируется автоматически" disabled/>
            @endif
        </div>
        <div class="field col-span-3">
            <x-select
            label="Модель"
            placeholder="Модель оборудования"
            wire:model.defer="model_id">
                @foreach ($models as $model)
                    <x-select.option label="{{ $model->type->name }} {{ $model->name }} {{ $model->manufacturer }}" 
                        value="{{ $model->id }}" wire:click="$emit('selected', '{{$model->type->name}} {{$model->name}} {{$model->manufacturer}}')" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-2">
            <x-input label="Кабинет" placeholder="№ кабинета" wire:model.defer="cabinet_number"/>
        </div>
        <div class="field col-span-2">
            <x-inputs.currency
                label="Цена"
                placeholder="Стоимость"
                icon="currency-dollar"
                thousands="."
                decimal=","
                precision="2"
                wire:model.defer="price"
            />
        </div>
        <div class="field col-span-3">
            <x-input label="Серийный номер" placeholder="Серийный номер" wire:model.defer="serial_number"/>
        </div>
        <div class="field col-span-5">
            <x-select
            label="Контрагент"
            placeholder="Выберите контрагента(если есть)"
            wire:model.defer="contractor_id">
                @foreach ($contractors as $contractor)
                    <x-select.option label="{{ $contractor->name }}" 
                        value="{{ $contractor->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-5">
            <x-datetime-picker
            label="Дата производства"
            placeholder="Дата производства"
            display-format="DD-MM-YYYY"
            parse-format="YYYY-MM-DD"
            :without-time="true"
            wire:model.defer="manufacture_date"
            />
        </div>
        <div class="field col-span-5">
            <x-datetime-picker
            label="Дата покупки"
            placeholder="Дата покупки"
            display-format="DD-MM-YYYY"
            parse-format="YYYY-MM-DD"
            :without-time="true"
            wire:model.defer="buy_date"
            />
        </div>
        <div class="field col-span-5">
            <x-datetime-picker
            label="Дата ввода в эксплуатацию"
            placeholder="Дата ввода в эксплуатацию"
            display-format="DD-MM-YYYY"
            parse-format="YYYY-MM-DD"
            :without-time="true"
            wire:model.defer="commissioning_date"
            />
        </div>
        <div class="field col-span-3">
            <x-inputs.maskable
            label="Гарантийный срок(месяцы)"
            mask="###"
            placeholder="Гарантийный срок"
            wire:model.defer="warranty_period"
            />
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="update()" primary label="Сохранить" />
        </div>
    </x-slot>
</x-card>
