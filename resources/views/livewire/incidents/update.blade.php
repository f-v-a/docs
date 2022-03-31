@if ((auth()->user()->is_admin || auth()->user()->is_chief) && ($this->condition != 'На согласовании'))
<x-card title="Редактировать данные">
    <div class="grid grid-cols-5 gap-3">
        <div class="field col-span-5">
            <x-textarea wire:model.defer="description" label="Описание" disabled/>
        </div>
        <div class="field col-span-5">
            <x-select
            label="Влияние на прием"
            :options="['Незначительное', 'Значительное', 'Критичное']"
            wire:model.defer="influence"
            disabled />
        </div>
        <div class="field col-span-5">
            <x-select
            label="Оборудование"
            wire:model.defer="equipment_id" disabled>
                @foreach ($equipments as $equipment)
                    <x-select.option label="{{ $equipment->name }}" value="{{ $equipment->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-5">
            <x-select
            label="Сотрудник"
            wire:model.defer="creator_id" disabled>
                @foreach ($employees as $employee)
                    <x-select.option label="{{ $employee->user->surname ?? '' }} {{ $employee->user->name ?? ''}} {{ $employee->user->patronymic ?? ''}}" 
                        value="{{ $employee->id }}" />
                @endforeach
            </x-select>
        </div>
        <div class="field col-span-5">
            <x-select
            label="Мастер"
            placeholder="Выберите мастера"
            wire:model.defer="executor_id">
                @foreach ($performers as $performer)
                    <x-select.option label="{{ $performer->user->surname ?? '' }} {{ $performer->user->name ?? ''}} {{ $performer->user->patronymic ?? ''}} {{ $performer->user->position->name ?? ''}}" 
                        value="{{ $performer->id }}" />
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
@endif

@if (auth()->user()->is_performer)
<x-card title="Инцидент #{{ $this->selectedId }} ">
    <div class="grid grid-cols-1 gap-3">
        <div class="field col-span-1">
            @if ($this->condition == 'Новый')
                <x-textarea wire:model.defer="conclusion" label="Причина"/>
            @else
                <x-textarea wire:model.defer="conclusion" label="Заключение"/>
            @endif
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            @if ($this->condition == 'Принят' || $this->condition == 'На доработке')
                <x-button wire:click="update()" primary label="На проверку" />
            @endif
            @if ($this->condition == 'Новый')
                <x-button wire:click="reject()" primary label="Отклонить" />    
            @endif
        </div>
    </x-slot>
</x-card>
@endif

@if ((auth()->user()->is_admin || auth()->user()->is_chief) && $this->condition == 'На согласовании')
<x-card title="Инцидент #{{ $this->selectedId }} ">
    <div class="grid grid-cols-1 gap-3">
        <div class="field col-span-1">
            <x-textarea wire:model.defer="conclusion" label="Причина завершения" placeholder="Указать причину по которой завершается инцидент"/>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button wire:click="agreement({{ $agreement = 0 }})" primary label="Сменить исполнителя" /> 
            <x-button wire:click="agreement({{ $agreement = 1 }})" primary label="Завершить инцидент" />      
        </div>
    </x-slot>
</x-card>
@endif

