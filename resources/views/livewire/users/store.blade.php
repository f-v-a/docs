<x-card title="Добавить данные">
    <div class="grid grid-cols-12 gap-3">
        <div class="field col-span-12">
            <x-input label="Логин" placeholder="Введите логин" wire:model.defer="login"/>
        </div>
        <div class="field col-span-12">
            <x-input label="Пароль" placeholder="Введите пароль" wire:model.defer="password"/>
        </div>
        <div class="field col-span-12">
            <x-input label="Фамилия" placeholder="Введите фамилию" wire:model.defer="surname"/>
        </div>
        <div class="field col-span-12">
            <x-input label="Имя" placeholder="Введите имя" wire:model.defer="name"/>
        </div>
        <div class="field col-span-12">
            <x-input label="Отчество" placeholder="Введите отчество" wire:model.defer="patronymic"/>
        </div>
        <div class="field col-span-6">
            <x-select
            label="Должность"
            placeholder="Должность"
            wire:model.defer="position_id">
                @foreach ($positions as $position)
                    <x-select.option label="{{ $position->name }}" value="{{ $position->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-6">
            <x-select
            label="Роль"
            placeholder="Роль"
            wire:model.defer="role_id">
                @foreach ($roles as $role)
                    <x-select.option label="{{ $role->name }}" value="{{ $role->id }}" />
                @endforeach
            </x-select>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="store()" primary label="Добавить" />
        </div>
    </x-slot>
</x-card>
