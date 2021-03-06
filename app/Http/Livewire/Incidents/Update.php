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

    private function resetInput()
    {
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

    public function update()
    {
        if (auth()->user()->is_admin || auth()->user()->is_chief) {
            $this->validate([
                'creator_id' => 'required',
                'influence' => 'required',
                'equipment_id' => 'required',
                'executor_id' => 'required',
            ]);

            if ($this->selectedId) {
                $updateIncident = Incident::find($this->selectedId);

                $updateIncident->update([
                    'executor_id' => $this->executor_id,
                    'condition' => '???? ????????????????????????',
                ]);

                IncidentHistory::create([
                    'user_id' => auth()->user()->id,
                    'condition' => '???? ????????????????????????',
                    'incident_id' => $this->selectedId,
                ]);

                $this->forceClose()->closeModal();
                $this->emitTo('tables.incidents-table', 'refresh');
                $this->resetInput();
                $this->notification()->success(
                    $title = '??????????????',
                    $description = '???????????? ?????????????? ??????????????????'
                );
            }
        }

        if (auth()->user()->is_performer) {
            $this->validate([
                'conclusion' => 'required',
            ]);

            if ($this->selectedId) {
                $updateIncident = Incident::find($this->selectedId);

                $updateIncident->update([
                    'conclusion' => $this->conclusion,
                    'condition' => '???? ????????????????',
                    'updated_at' => Carbon::now(),
                ]);

                IncidentHistory::create([
                    'user_id' => auth()->user()->id,
                    'condition' => '???? ????????????????',
                    'incident_id' => $this->selectedId,
                    'conclusion' => $this->conclusion,
                ]);

                $this->forceClose()->closeModal();
                $this->emitTo('tables.incidents-table', 'refresh');
                $this->resetInput();
                $this->notification()->success(
                    $title = '??????????????',
                    $description = '???????????? ?????????????? ??????????????????'
                );
            }
        }
    }

    public function reject()
    {
        if ($this->selectedId) {
            if (auth()->user()->is_performer)
                $updateIncident = Incident::find($this->selectedId);

            $updateIncident->update([
                'conclusion' => $this->conclusion,
                'condition' => '???????????????? ????????????????????????',
                'updated_at' => Carbon::now(),
            ]);

            IncidentHistory::create([
                'user_id' => auth()->user()->id,
                'condition' => '???????????????? ????????????????????????',
                'conclusion' => $this->conclusion,
                'incident_id' => $updateIncident->id,
            ]);

            $this->forceClose()->closeModal();
            $this->emitTo('tables.incidents-table', 'refresh');
            $this->resetInput();
            $this->notification()->success(
                $title = '??????????????',
                $description = '???????????? ?????????????? ??????????????????'
            );
        }
    }

    public function agreement($agr)
    {
        if ($this->selectedId) {

            $updateIncident = Incident::find($this->selectedId);
            if ($agr == 0) {
                $updateIncident->update([
                    'condition' => '?????????? ??????????????????????',
                ]);
                IncidentHistory::create([
                    'condition' => '?????????? ??????????????????????',
                    'conclusion' => $this->conclusion,
                    'user_id' => auth()->user()->id,
                    'incident_id' => $updateIncident->id
                ]);
            } else {
                $this->validate([
                    'conclusion' => 'required',
                ]);

                $updateIncident->update([
                    'condition' => '????????????????',
                    'date_completion' => Carbon::now(),
                ]);
                IncidentHistory::create([
                    'condition' => '????????????????',
                    'conclusion' => $this->conclusion,
                    'user_id' => auth()->user()->id,
                    'incident_id' => $updateIncident->id
                ]);
            }
            $this->forceClose()->closeModal();
            $this->emitTo('tables.incidents-table', 'refresh');
            $this->resetInput();
            $this->notification()->success(
                $title = '??????????????',
                $description = '???????????? ?????????????? ??????????????????'
            );
        }
    }
}
