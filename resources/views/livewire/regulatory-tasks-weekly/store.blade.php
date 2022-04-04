<x-card title="Добавить данные">
    <div class="grid grid-cols-6 gap-4" x-data="{ indefinitely: false}">
        <div class="grid grid-cols-6 gap-4 col-span-6">
            <div class="field col-span-6">
                <x-textarea wire:model.defer="description" label="Описание" placeholder="Описание задачи" />
            </div>
            <div class="field col-span-6">
                <ul class="flex flex-row justify-around flex-wrap pb-4">
                    <li>
                        <label for="monday" class="w-full text-gray-700 text-sm font-semibold pb-2">Пн</label>
                        <x-checkbox id="monday" md wire:model.defer="monday" value="Пн" />
                    </li>
                    <li>
                        <label for="tuesday" class="w-full text-gray-700 text-sm font-semibold pb-2">Вт</label>
                        <x-checkbox id="tuesday" md wire:model.defer="tuesday" value="Вт" />
                    </li>
                    <li>
                        <label for="wednesday" class="w-full text-gray-700 text-sm font-semibold pb-2">Ср</label>
                        <x-checkbox id="wednesday" md wire:model.defer="wednesday" value="Ср" />
                    </li>
                    <li>
                        <label for="thirsday" class="w-full text-gray-700 text-sm font-semibold pb-2">Чт</label>
                        <x-checkbox id="thirsday" md wire:model.defer="thirsday" value="Чт" />
                    </li>
                    <li>
                        <label for="friday" class="w-full text-gray-700 text-sm font-semibold pb-2">Пт</label>
                        <x-checkbox id="friday" md wire:model.defer="friday" value="Пт" />
                    </li>
                    <li>
                        <label for="saturday" class="w-full text-gray-700 text-sm font-semibold pb-2">Сб</label>
                        <x-checkbox id="saturday" md wire:model.defer="saturday" value="Сб" />
                    </li>
                    <li>
                        <label for="sunday" class="w-full text-gray-700 text-sm font-semibold pb-2">Вс</label>
                        <x-checkbox id="sunday" md wire:model.defer="sunday" value="Вс" />
                    </li>
                </ul>

                <label for="periodicity" class="w-full text-gray-700 text-sm font-semibold pb-2">Повторять каждые</label>
                <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                    <x-inputs.maskable placeholder="0" wire:model.defer="periodicity" mask="#" suffix="нед"/>
                </div>
            </div>
            <div class="field col-span-6">
                <x-datetime-picker
                label="Начало"
                placeholder="Дата начала"
                display-format="DD-MM-YYYY"
                parse-format="YYYY-MM-DD"
                :without-time="true"
                :without-tips="true"
                :min="now()"
                wire:model="start_date"
                />
            </div>
            <div class="field col-span-6">
                <div x-show="!indefinitely">
                    <x-datetime-picker
                    label="Завершение"
                    placeholder="Дата завершения"
                    display-format="DD-MM-YYYY"
                    parse-format="YYYY-MM-DD"
                    :without-time="true"
                    :without-tips="true"
                    :min="now()->addDays(1)"
                    :max="now()->addYears(10)"
                    wire:model="end_date"
                    />
                </div>
                <div class="field col-span-6">
                    <label for="indefinitely" class="flex items-center pt-4">
                        <x-checkbox @click="indefinitely = !indefinitely" md id="indefinitely" wire:model.defer="indefinitely" value="true" />
                        <label class="block text-sm font-medium text-secondary-700 dark:text-gray-400 ml-2">Бессрочно</label>
                    </label>
                </div>
            </div>
            {{-- <div class="field col-span-3">
                <x-select
                label="Инициатор"
                placeholder="Инициатор"
                wire:model.defer="employee_id">
                    @foreach ($employees as $employee)
                        <x-select.option label="
                        {{ $employee->user->surname ?? ''}} {{ $employee->user->name ?? ''}} {{ $employee->user->patronymic ?? ''}} {{ $employee->user->position->name ?? ''}}" 
                        value="{{ $employee->id }}" />
                    @endforeach
                </x-select>
            </div> --}}
            <div class="field col-span-6">
                <x-select
                label="Оборудование"
                placeholder="Оборудование"
                wire:model="equipment_id">
                    @foreach ($equipments as $equipment)
                        <x-select.option label=" {{ $equipment->name }} " 
                        value="{{ $equipment->id }}" />
                    @endforeach
                </x-select>
            </div>
            @if($equipment_id)
            <div class="field col-span-6">
                <x-select
                label="Исполнитель"
                placeholder="Исполнитель"
                wire:model.defer="executor_id">
                    @foreach ($performers as $performer)
                        <x-select.option label="
                        {{ $performer->user->surname ?? ''}} {{ $performer->user->name ?? ''}} {{ $performer->user->patronymic ?? ''}} {{ $performer->user->position->name ?? ''}}" 
                        value="{{ $performer->id }}" />
                    @endforeach
                </x-select>
            </div>
            @endif
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button flat label="Закрыть" wire:click="$emit('closeModal')" />
            <x-button wire:click="store()" primary label="Добавить" />
        </div>
    </x-slot>
</x-card>