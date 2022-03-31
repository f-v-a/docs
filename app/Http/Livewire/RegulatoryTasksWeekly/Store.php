<?php

namespace App\Http\Livewire\RegulatoryTasksWeekly;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Executor;
use App\Models\RegulatoryTask;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;
use Illuminate\Support\Arr;

class Store extends ModalComponent
{
    use Actions;

    public $end_date, $start_date, $equipment_id, $executor_id, $employee_id, $periodicity, $description, $indefinitely = false,
    $monday, $tuesday, $wednesday, $thirsday, $friday, $saturday, $sunday, $inputArr, $outputArr = [];

    private function resetInput() {
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

    public function check() {
        $this->inputArr = [
            $this->monday, $this->tuesday, $this->wednesday , $this->thirsday, $this->friday, $this->saturday, $this->sunday
        ];

        foreach($this->inputArr as $key => $array) {
            if(!empty($array)) {
                $this->outputArr = Arr::add($this->outputArr, $key , $array);
            }
        }

        $this->inputArr = null;

        return implode(',', $this->outputArr);
    }


    public function store() {
        $this->validate([
            'description' => 'required',
            'executor_id' => 'required',
            'employee_id' => 'required',
            'equipment_id' => 'required',
            'start_date' => 'required',
        ]);

        if($this->indefinitely == false) {
            $newRegular = RegulatoryTask::create([
                'description' => $this->description,
                'executor_id' => $this->executor_id,
                'employee_id' => $this->employee_id,
                'equipment_id' => $this->equipment_id,
                'status' => true,
                'start_date' => $this->start_date,
                'periodicity' => $this->periodicity,
                'dates' => $this->check(),
                'end_date' => $this->end_date,
            ]);
            
            if($newRegular) {
                $this->forceClose()->closeModal();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
                $this->resetInput();
            }
        }
        
        if($this->indefinitely) {
            $newRegular = RegulatoryTask::create([
                'description' => $this->description,
                'executor_id' => $this->executor_id,
                'employee_id' => $this->employee_id,
                'equipment_id' => $this->equipment_id,
                'status' => true,
                'start_date' => $this->start_date,
                'periodicity' => $this->periodicity,
                'dates' => $this->check(),
                'end_date' => 'Бессрочно',
            ]);

            if($newRegular) {
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
        $this->employees = Employee::get();
        $this->performers = Executor::get();
        $this->equipments = Equipment::get();

        return view('livewire.regulatory-tasks-weekly.store');
    }
}
