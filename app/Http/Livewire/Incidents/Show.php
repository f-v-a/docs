<?php

namespace App\Http\Livewire\Incidents;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Executor;
use App\Models\Incident;
use App\Models\IncidentHistory;
use LivewireUI\Modal\ModalComponent;

class Show extends ModalComponent
{
    
    public $selectedId, $equipment_id, $executor_id, $creator_id, $description, $influence, $conclusion, $condition;

    public function mount($id)
    { 
        $editIncident = Incident::findOrFail($id);
        $this->selectedId = $id;
        $this->description = $editIncident->description;
        $this->equipment_id = $editIncident->equipment_id;
        $this->creator_id = $editIncident->creator_id;
        $this->influence = $editIncident->influence;
        $this->executor_id = $editIncident->executor_id;
        $this->conclusion = $editIncident->conclusion;
    }

    public function render()
    {
        // $this->equipments = Equipment::get();
        // $this->employees = Employee::get();
        // $this->performers = Executor::get();
        $this->incident = Incident::find($this->selectedId);
        $this->histories = IncidentHistory::where('incident_id', $this->selectedId)->get();

        return view('livewire.incidents.show');
    }
    
}
