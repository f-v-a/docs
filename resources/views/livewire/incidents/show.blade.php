{{-- <x-card blur title="Данные об инциденте">
    <div class="grid grid-cols-5 gap-3">
        <div class="field col-span-5">
            <x-textarea wire:model.defer="description" label="Описание" disabled/>
        </div>
        <div class="field col-span-5">
            <x-select
            label="Влияние на прием"
            :options="['Малое влияние на прием', 'Среднее влияние на прием', 'Прием приостановлен']"
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
            placeholder="Мастер не выбран"
            wire:model.defer="executor_id" disabled>
                @foreach ($performers as $performer)
                    <x-select.option label="{{ $performer->user->surname ?? '' }} {{ $performer->user->name ?? ''}} {{ $performer->user->patronymic ?? ''}} {{ $performer->user->position->name ?? ''}}" 
                        value="{{ $performer->id }}"/>
                @endforeach
            </x-select>
        </div>
        @if (auth()->user()->is_admin || auth()->user()->is_chief)
        <div class="field col-span-5">
            <x-textarea wire:model.defer="conclusion" label="Заключение" disabled/>
        </div>
        @endif
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
        </div>
    </x-slot>
</x-card> --}}
<x-card blur title="История инцидента">
<div class="w-full px-2 py-6">
  @forelse ($histories as $history) 
    <div class="flex">
      <div class="flex flex-col items-center mr-4">
        <div>
          <div class="flex items-center justify-center w-10 h-10 border rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
            </svg>
          </div>
        </div>
        <div class="w-px h-full bg-gray-300"></div>
      </div>
      <div class="pb-8 ">
        <p class="mb-2 text-xl font-bold text-gray-600">{{ $history->user->surname ?? '' }} {{ $history->user->name ?? ''}} {{ $history->user->patronymic ?? '' }}</p>
        <time class="mb-1 text-sm font-normal leading-none text-gray-400">{{ $history->updated_at }}</time>
        <p class="text-gray-700">
          @if ($history->condition == 'На согласовании')
            <p class="text-gray-700">
              Назначен мастер {{ $incident->executor->user->surname ?? ''}} {{ $incident->executor->user->name ?? ''}} {{ $incident->executor->user->patronymic ?? '' }}
            </p>
          @endif
          @if ($history->condition == 'Выбор исполнителя')
            <p class="text-gray-700">
              Новый инцидент
            </p>
          @endif
          @if ($history->condition == 'Новый')
            <p class="text-gray-700">
              Передан в работу мастеру
            </p>
          @endif
          @if ($history->condition == 'Отклонен исполнителем' || $history->condition == 'На проверке')
          <p class="text-gray-700">
            {{ $history->conclusion }}
          </p>
        @endif
          Статус: {{ $history->condition }}
        </p>
      </div>
    </div>
    @if ($history->condition == 'Завершен')
    <div class="flex">
      <div class="flex flex-col items-center mr-4">
        <div>
          <div class="flex items-center justify-center w-10 h-10 border rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
      </div>
      <div class="pt-1">
        <p class="mb-2 text-lg font-bold text-gray-600">Завершен</p>
        <p class="text-gray-700">
          {{ $history->conclusion }}
        </p>
      </div>
    </div>
  @endif

  @empty

  <p class="mb-2 text-xl font-bold text-gray-600"> История пуста </p>

  @endforelse
  </div>
</x-card>