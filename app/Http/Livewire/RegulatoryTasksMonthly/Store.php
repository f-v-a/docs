<?php

namespace App\Http\Livewire\RegulatoryTasksMonthly;

use App\Models\Equipment;
use App\Models\Executor;
use App\Models\RegulatoryTask;
use Illuminate\Support\Arr;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Store extends ModalComponent
{
    use Actions;

    public $end_date, $start_date, $equipment_id, $executor_id, $periodicity, $description, $indefinitely = false, $inputArr, $outputArr = [],
        $january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december;

    private function resetInput()
    {
        $this->executor_id = null;
        $this->equipment_id = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->description = null;
        $this->periodicity = null;
        $this->status = null;
        $this->indefinitely = null;
    }

    public function check()
    {
        $this->inputArr = [
            $this->january, $this->february, $this->march, $this->april, $this->may, $this->june, $this->july,
            $this->august, $this->september, $this->october, $this->november, $this->december,
        ];

        foreach ($this->inputArr as $key => $array) {
            if (!empty($array)) {
                $this->outputArr = Arr::add($this->outputArr, $key, $array);
            }
        }
        $this->inputArr = null;

        return implode(',', $this->outputArr);
    }

    public function store()
    {
        $this->validate([
            'description' => 'required',
            'executor_id' => 'required',
            'equipment_id' => 'required',
            'start_date' => 'required',
        ]);

        if ($this->indefinitely == false) {
            $this->validate([
                'end_date' => 'required|after:start_date',
            ]);

            $newRegular = RegulatoryTask::create([
                'description' => $this->description,
                'executor_id' => $this->executor_id,
                'equipment_id' => $this->equipment_id,
                'status' => true,
                'start_date' => $this->start_date,
                'periodicity' => $this->periodicity,
                'dates' => $this->check(),
                'end_date' => $this->end_date,
            ]);

            if ($newRegular) {
                $this->forceClose()->closeModal();
                $this->notification()->success(
                    $title = '??????????????',
                    $description = '???????????? ?????????????? ??????????????????'
                );
                $this->resetInput();
            }
        }

        if ($this->indefinitely) {
            $this->validate([
                'end_date' => 'nullable|after:start_date',
            ]);

            $newRegular = RegulatoryTask::create([
                'description' => $this->description,
                'executor_id' => $this->executor_id,
                'equipment_id' => $this->equipment_id,
                'status' => true,
                'start_date' => $this->start_date,
                'periodicity' => $this->periodicity,
                'dates' => $this->check(),
                'end_date' => '??????????????????',
            ]);

            if ($newRegular) {
                $this->forceClose()->closeModal();
                $this->notification()->success(
                    $title = '??????????????',
                    $description = '???????????? ?????????????? ??????????????????'
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


        return view('livewire.regulatory-tasks-monthly.store');
    }
}
