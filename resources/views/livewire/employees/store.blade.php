<x-card title="Добавить данные">
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
        <div class="field col-span-5 py-2">
            <div class="flex flex-wrap gap-4">
                <x-radio id="left-label" md left-label="Женщина" wire:model.defer="gender" value="Ж" />
                <x-radio id="right-label" md label="Мужчина" wire:model.defer="gender" value="М" />
            </div>
        </div>
        <div class="field col-span-2">
            <x-input label="№ кабинета" placeholder="№ кабинета" wire:model.defer="cabinet_number"/>
        </div>
        <div class="field col-span-3">
            <x-datetime-picker
            label="Дата рождения"
            placeholder="Выберите дату рождения"
            display-format="DD-MM-YYYY"
            parse-format="YYYY-MM-DD"
            :without-time="true"
            :max="now()->subYears(16)"
            wire:model.defer="birthday"
            />
        </div>
        <div class="field col-span-3">
            <x-input class="pr-28" label="Email" placeholder="Email" suffix="@gmail.com" wire:model.defer="email"/>
        </div>
        <div class="field col-span-2">
            <x-inputs.maskable
            label="Телефон"
            mask="#(###) ###-##-##"
            placeholder="Номер телефона"
            wire:model.defer="phone"
            />
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="store()" primary label="Добавить" />
        </div>
    </x-slot>
</x-card>
