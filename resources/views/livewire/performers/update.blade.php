<x-card title="Редактировать данные">
    <div class="grid grid-cols-5 gap-3">
        <div class="field col-span-5">
            <x-select
            label="ФИО"
            placeholder="ФИО сотрудника"
            wire:model.defer="user_id">
                @foreach ($users as $user)
                    <x-select.option label="
                    {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }} {{ $user->position->name }}" 
                    value="{{ $user->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-5">
            <x-select
            label="Контрагент"
            placeholder="Выберите контрагента"
            wire:model.defer="contractor_id">
                @foreach ($contractors as $contractor)
                    <x-select.option label=" {{ $contractor->name }}" 
                    value="{{ $contractor->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-3">
            <x-input class="pr-28" label="Email" placeholder="Введите Email" suffix="@gmail.com" wire:model.defer="email"/>
        </div>
        <div class="field col-span-2">
            <x-inputs.maskable
            label="Телефон"
            mask="#(###) ###-##-##"
            placeholder="Введите номер телефона"
            wire:model.defer="phone"
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