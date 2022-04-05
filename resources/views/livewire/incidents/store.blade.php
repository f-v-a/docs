<x-card title="Добавить данные">
    <div class="grid grid-cols-1 gap-3">
        <div class="field">
            <x-textarea wire:model.defer="description" label="Описание" placeholder="Описание инцидента" />
        </div>
        <div class="field">
            <x-select
            label="Влияние на прием"
            placeholder="Выберите из списка"
            :options="['Незначительное', 'Значительное', 'Критичное']"
            wire:model.defer="influence"
            />
        </div>
        @if (auth()->user()->is_admin)
            <div class="field">
                <x-select
                label="Сотрудник"
                placeholder="Выберите инициатора"
                wire:model="creator_id">
                    @foreach ($employees as $employee)
                        <x-select.option label="{{ $employee->user->surname ?? '' }} {{ $employee->user->name ?? ''}} {{ $employee->user->patronymic ?? ''}}" 
                            value="{{ $employee->id }}" class="relative"/>
                    @endforeach
                </x-select>
            </div>
            @if ($this->creator_id != null)
                <div class="field">
                    <x-select
                    label="Оборудование"
                    placeholder="Выберите оборудование"
                    wire:model.defer="equipment_id">
                        @foreach ($equipments as $equipment)
                            <x-select.option label="{{ $equipment->name }} Серийный № {{ $equipment->serial_number }}" value="{{ $equipment->id }}" />
                        @endforeach
                    </x-select>
                </div>
            @endif
        @endif

        @if (auth()->user()->is_user)
        <div class="field">
            <x-select
            label="Оборудование"
            placeholder="Выберите оборудование"
            wire:model.defer="equipment_id">
                @foreach ($equipments as $equipment)
                    <x-select.option label="{{ $equipment->name }} Серийный № {{ $equipment->serial_number }}" value="{{ $equipment->id }}" />
                @endforeach
            </x-select>
        </div>
        @endif
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="store()" primary label="Добавить" />
        </div>
    </x-slot>
</x-card>