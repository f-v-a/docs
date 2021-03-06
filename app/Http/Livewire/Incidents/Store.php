<?php

namespace App\Http\Livewire\Incidents;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Incident;
use App\Models\IncidentHistory;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $description, $influence, $equipment_id, $executor_id, $creator_id;

    public function render()
    {
        $this->employee = Employee::where('user_id', auth()->user()->id)->value('cabinet_number');

        if (auth()->user()->is_user) {
            $this->equipments = Equipment::where('cabinet_number', $this->employee)
                ->where('status', '!=', 'Списано')
                ->get();
        } else {
            $this->employees = Employee::get();
            if ($this->creator_id != null) {
                $this->equipments = Equipment::where('status', '!=', 'Списано')
                    ->where('cabinet_number', Employee::find($this->creator_id)->cabinet_number)
                    ->get();
            }
        }

        return view('livewire.incidents.store');
    }

    private function resetInput()
    {
        $this->creator_id = null;
        $this->equipment_id = null;
        $this->description = null;
        $this->influence = null;
    }

    public function store()
    {
        $equipment = Incident::where('equipment_id', $this->equipment_id)->value('equipment_id');

        $incidentCondition = Incident::where('equipment_id', $this->equipment_id)
            ->orderBy('id', 'desc')->value('condition');

        // dd($incidentCondition);

        if ($equipment != $this->equipment_id || ($equipment == $this->equipment_id && $incidentCondition == 'Завершен')) {
            if (auth()->user()->is_admin) {
                $this->validate([
                    'creator_id' => 'required',
                    'equipment_id' => 'required',
                    'influence' => 'required',
                ]);

                $newIncident = Incident::create([
                    'equipment_id' => $this->equipment_id,
                    'creator_id' => $this->creator_id,
                    'influence' => $this->influence,
                    'description' => $this->description,
                    'condition' => 'Выбор исполнителя',
                ]);
                IncidentHistory::create([
                    'user_id' => $this->creator_id,
                    'incident_id' => Incident::orderByDesc('id')->limit(1)->value('id'),
                    'condition' => 'Выбор исполнителя',
                ]);
            }
            if (auth()->user()->is_user) {
                $this->validate([
                    'equipment_id' => 'required',
                    'influence' => 'required',
                ]);

                $newIncident = Incident::create([
                    'equipment_id' => $this->equipment_id,
                    'creator_id' => Employee::where('user_id', auth()->user()->id)->value('id'),
                    'influence' => $this->influence,
                    'description' => $this->description,
                    'condition' => 'Выбор исполнителя',
                ]);
                IncidentHistory::create([
                    'user_id' => auth()->user()->id,
                    'incident_id' => Incident::orderByDesc('id')->limit(1)->value('id'),
                    'condition' => 'Выбор исполнителя',
                ]);
            }

            if ($this->influence == 'Критичное') {
                $updateEquipment = Equipment::findOrFail($this->equipment_id);
                $updateEquipment->update([
                    'status' => 'Выведено из эксплуатации'
                ]);
            }

            if ($newIncident) {
                $this->forceClose()->closeModal();
                $this->emitTo('tables.incidents-table', 'refresh');
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
                $this->resetInput();
            }
        } else {
            $this->forceClose()->closeModal();
            $this->notification()->error(
                $title = 'Ошибка',
                $description = 'Инцидент уже существует'
            );
            $this->resetInput();
        }
    }
}
