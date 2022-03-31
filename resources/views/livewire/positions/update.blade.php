<x-card title="Редактировать данные">
    <div class="form-group">
        <x-input label="Наименование" placeholder="Введите наименование" wire:model="name"/>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="update()" primary label="Сохранить" />
        </div>
    </x-slot>
</x-card>