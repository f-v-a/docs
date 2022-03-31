<x-card title="Добавить данные">
    <div class="grid grid-cols-5 gap-3">
        <div class="field col-span-5">
            <x-textarea wire:model.defer="description" label="Описание" placeholder="Описание контрагента" />
        </div>
        <div class="field col-span-5">
            <x-input label="Наименование" placeholder="Наименование контрагента" wire:model.defer="name"/>
        </div>
        <div class="field col-span-5">
            <x-input class="pr-28" label="Email" placeholder="Email" suffix="@gmail.com" wire:model.defer="email"/>
        </div>
        <div class="field col-span-5">
            <x-inputs.maskable class="pr-28" label="ИНН" placeholder="ИНН" mask="############" wire:model.defer="inn"/>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="store()" primary label="Добавить" />
        </div>
    </x-slot>
</x-card>
