<x-card title="Добавить данные">
    <div class="grid grid-cols-6 gap-4" x-data="{ indefinitely: false}">
        <div class="grid grid-cols-6 gap-4 col-span-6">
            <div class="field col-span-6">
                <x-textarea wire:model.defer="description" label="Описание" placeholder="Описание задачи" />
            </div>
            <div class="field col-span-6">
                <ul class="flex flex-row justify-center flex-wrap pb-2">
                    <li class = "flex flex-col items-center text-center w-2/12 pb-2">
                        <label for="january" class="w-full text-gray-700 text-sm font-semibold pb-2">Янв</label>
                        <x-checkbox id="january" md wire:model.defer="january" value="1" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12 pb-2">
                        <label for="february" class="w-full text-gray-700 text-sm font-semibold pb-2">Фев</label>
                        <x-checkbox id="february" md wire:model.defer="february" value="2" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12 pb-2">
                        <label for="march" class="w-full text-gray-700 text-sm font-semibold pb-2">Март</label>
                        <x-checkbox id="march" md wire:model.defer="march" value="3" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12 pb-2">
                        <label for="april" class="w-full text-gray-700 text-sm font-semibold pb-2">Апр</label>
                        <x-checkbox id="april" md wire:model.defer="april" value="4" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12 pb-2">
                        <label for="may" class="w-full text-gray-700 text-sm font-semibold pb-2">Май</label>
                        <x-checkbox id="may" md wire:model.defer="may" value="5" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12 pb-2">
                        <label for="june" class="w-full text-gray-700 text-sm font-semibold pb-2">Июнь</label>
                        <x-checkbox id="june" md wire:model.defer="june" value="6" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12">
                        <label for="july" class="w-full text-gray-700 text-sm font-semibold pb-2">Июль</label>
                        <x-checkbox id="july" md wire:model.defer="july" value="7" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12">
                        <label for="august" class="w-full text-gray-700 text-sm font-semibold pb-2">Авг</label>
                        <x-checkbox id="august" md wire:model.defer="august" value="8" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12">
                        <label for="september" class="w-full text-gray-700 text-sm font-semibold pb-2">Сен</label>
                        <x-checkbox id="september" md wire:model.defer="september" value="9" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12">
                        <label for="october" class="w-full text-gray-700 text-sm font-semibold pb-2">Окт</label>
                        <x-checkbox id="october" md wire:model.defer="october" value="10" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12">
                        <label for="november" class="w-full text-gray-700 text-sm font-semibold pb-2">Нояб</label>
                        <x-checkbox id="november" md wire:model.defer="november" value="11" />
                    </li>
                        <li class = "flex flex-col items-center text-center w-2/12">
                        <label for="december" class="w-full text-gray-700 text-sm font-semibold pb-2">Дек</label>
                        <x-checkbox id="december" md wire:model.defer="december" value="12" />
                    </li>
                </ul>

                <label for="periodicity" class="w-full text-gray-700 text-sm font-semibold pb-2">Повторять каждые</label>
                <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                    <x-inputs.maskable placeholder="0" wire:model.defer="periodicity" mask="##" suffix="дн в мес"/>
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
                    :max="now()->addYears(3)"
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
            @if ($equipment_id)
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