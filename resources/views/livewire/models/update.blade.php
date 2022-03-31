<x-card title="Редактировать данные">
    <div class="grid grid-cols-4 gap-3">
        <div class="field col-span-4">
            <x-input label="Наименование" placeholder="Введите наименование" wire:model.defer="name"/>
        </div>
        <div class="field col-span-2">
            <x-select
            label="Тип оборудования"
            placeholder="Тип оборудования"
            wire:model.defer="type_id">
                @foreach ($types as $type)
                    <x-select.option label="{{ $type->name }}" value="{{ $type->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-2">
            <x-select
            label="Производитель"
            placeholder="Производитель"
            wire:model.defer="manufacturer">
                @foreach ($countries as $country)
                    <x-select.option label="{{ $country }}" value="{{ $country }}" />
                @endforeach
            </x-select>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="update()" primary label="Сохранить" />
        </div>
    </x-slot>
</x-card>
