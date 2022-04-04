<?php

namespace App\Http\Livewire\Incidents;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Executor;
use App\Models\Incident;
use App\Models\IncidentHistory;
use App\Models\User;
use Carbon\Carbon;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Update extends ModalComponent
{
    use Actions;

    public $selectedId, $equipment_id, $executor_id, $creator_id, $description, $influence, $date_completion, $contractor, $conclusion, $condition, $agreement;

    public function mount($id, $contractor_id)
    { 
        $editIncident = Incident::findOrFail($id);
        $this->selectedId = $id;
        $this->description = $editIncident->description;
        $this->equipment_id = $editIncident->equipment_id;
        $this->creator_id = $editIncident->creator_id;
        $this->influence = $editIncident->influence;
        $this->executor_id = $editIncident->executor_id;
        $this->contractor = $contractor_id;
        $this->condition = $editIncident->condition;
    }
    
    private function resetInput() {
        $this->equipment_id = null;
        $this->creator_id = null;
        $this->executor_id = null;
        $this->description = null;
        $this->influence = null;
    }
    
    public function render()
    {
        $this->equipments = Equipment::get();
        $this->employees = Employee::get();
        $this->performers = Executor::where('contractor_id', $this->contractor)
        ->orWhere('contractor_id', null)->get();

        return view('livewire.incidents.update');
    }

    public function update() {
        if(auth()->user()->is_admin || auth()->user()->is_chief) {
            $this->validate([
                'creator_id' => 'required',
                'influence' => 'required',
                'equipment_id' => 'required',
                'executor_id' => 'required',
            ]);

            if($this->selectedId) {
                $updateIncident = Incident::find($this->selectedId);

                $updateIncident->update([
                    'executor_id' => $this->executor_id,
                    'condition' => 'На согласовании',
                ]);

                IncidentHistory::create([
                    'user_id' => auth()->user()->id,
                    'condition' => 'На согласовании',
                    'incident_id' => Incident::find($this->selectedId)->value('id'),
                ]);
                
                $this->forceClose()->closeModal();
                $this->resetInput();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
            }
        }

        if(auth()->user()->is_performer) {
            $this->validate([
                'conclusion' => 'required',
            ]);

            if($this->selectedId) {
                $updateIncident = Incident::find($this->selectedId);

                $updateIncident->update([
                    'conclusion' => $this->conclusion,
                    'condition' => 'На проверке',
                    'updated_at' => Carbon::now(),
                ]);

                IncidentHistory::create([
                    'user_id' => auth()->user()->id,
                    'condition' => 'На проверке',
                    'incident_id' => Incident::find($this->selectedId)->value('id'),
                    'conclusion' => $this->conclusion,
                ]);
                
                $this->forceClose()->closeModal();
                $this->resetInput();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
            }
        }
    }

    public function reject() {
        if($this->selectedId) {
            if(auth()->user()->is_performer)
                $updateIncident = Incident::find($this->selectedId);

                $updateIncident->update([
                    'conclusion' => $this->conclusion,
                    'condition' => 'Отклонен исполнителем',
                    'updated_at' => Carbon::now(),
                ]);

                IncidentHistory::create([
                    'user_id' => auth()->user()->id,
                    'condition' => 'Отклонен исполнителем',
                    'conclusion' => $this->conclusion,
                    'incident_id' => $updateIncident->id,
                ]);

                $this->forceClose()->closeModal();
                $this->resetInput();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
        }
    }

    public function agreement($agr) {
        if($this->selectedId) {

                $updateIncident = Incident::find($this->selectedId);
                if($agr == 0) {
                    $updateIncident->update([
                        'condition' => 'Смена исполнителя',
                    ]);
                    IncidentHistory::create([
                        'condition' => 'Смена исполнителя',
                        'conclusion' => $this->conclusion,
                        'user_id' => auth()->user()->id,
                        'incident_id' => $updateIncident->id
                    ]);
                }
                else {
                    $this->validate([
                        'conclusion' => 'required',
                    ]);
                    
                    $updateIncident->update([
                        'condition' => 'Завершен',
                        'date_completion' => Carbon::now(),
                    ]);
                    IncidentHistory::create([
                        'condition' => 'Завершен',
                        'conclusion' => $this->conclusion,
                        'user_id' => auth()->user()->id,
                        'incident_id' => $updateIncident->id
                    ]);
                }
                $this->forceClose()->closeModal();
                $this->resetInput();
                $this->notification()->success(
                    $title = 'Успешно',
                    $description = 'Данные успешно сохранены'
                );
            } 
        }
    }
