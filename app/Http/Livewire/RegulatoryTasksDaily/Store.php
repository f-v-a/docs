<?php

namespace App\Http\Livewire\RegulatoryTasksDaily;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Executor;
use App\Models\RegulatoryTask;
use Carbon\Carbon;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $end_date, $start_date, $equipment_id, $executor_id, $employee_id, $periodicity, $description, $indefinitely = false;

    public function resetInput()
    {
        $this->executor_id = null;
        $this->employee_id = null;
        $this->equipment_id = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->description = null;
        $this->periodicity = null;
        $this->status = null;
        $this->indefinitely = null;
    }

    public function store()
    {

        $this->validate([
            'description' => 'required',
            'executor_id' => 'required',
            'equipment_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'nullable|after:start_date',
        ]);

        if ($this->indefinitely) {
            $newRegular = RegulatoryTask::create([
                'description' => $this->description,
                'executor_id' => $this->executor_id,
                'employee_id' => auth()->user()->id,
                'equipment_id' => $this->equipment_id,
                'status' => true,
                'start_date' => $this->start_date,
                'periodicity' => $this->periodicity,
                'dates' => 'custom',
                'end_date' => 'Бессрочно',
            ]);

            if ($newRegular) {
                $this->forceClose()->closeModal();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
                $this->resetInput();
            }
        } else {
            $newRegular = RegulatoryTask::create([
                'description' => $this->description,
                'executor_id' => $this->executor_id,
                'employee_id' => auth()->user()->id,
                'equipment_id' => $this->equipment_id,
                'status' => true,
                'start_date' => $this->start_date,
                'periodicity' => $this->periodicity,
                'dates' => 'custom',
                'end_date' => $this->end_date,
            ]);

            if ($newRegular) {
                $this->forceClose()->closeModal();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
                $this->resetInput();
            }
        }
    }

    public function render()
    {
        if ($this->equipment_id) {
            $this->performers = Executor::where('contractor_id', Equipment::find($this->equipment_id)->contractor_id)
                ->orWhere('contractor_id', null)
                ->get();
        }
        $this->equipments = Equipment::get();

        return view('livewire.regulatory-tasks-daily.store');
    }
}
