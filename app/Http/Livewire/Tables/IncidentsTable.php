<?php

namespace App\Http\Livewire\Tables;

use App\Models\Employee;
use App\Models\Executor;
use App\Models\Incident;
use App\Models\IncidentHistory;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class IncidentsTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'incidents.id';
    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        (auth()->user()->is_admin || auth()->user()->is_chief) ?
            $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showToggleColumns()
            ->showExportOption('download', ['excel', 'csv'])
            :
            $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showToggleColumns();
    }

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'more',
                'confirm',
                'reject',
                'accept',
                'conclusion',
                'refresh',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\User>|null
     */
    public function datasource(): ?Builder
    {
        if (auth()->user()->is_performer) {
            return Incident::where('condition', '!=', '????????????????')
                ->where('executor_id', Executor::where('user_id', (auth()->id()))->value('id'))
                ->join('equipment', 'incidents.equipment_id', '=', 'equipment.id')
                ->leftjoin('executors', 'incidents.executor_id', '=', 'executors.id')
                ->leftjoin('users', 'executors.user_id', '=', 'users.id')
                ->select(
                    'incidents.*',
                    'equipment.name as equipmentname',
                    'users.name as name',
                    'equipment.contractor_id as contractor',
                    'equipment.serial_number as serial_number'
                );
        }
        if (auth()->user()->is_user) {
            return Incident::where('condition', '!=', '????????????????')
                ->where('cabinet_number', Employee::where('user_id', (auth()->id()))->first()->cabinet_number ?? '')
                ->join('equipment', 'incidents.equipment_id', '=', 'equipment.id')
                ->leftjoin('executors', 'incidents.executor_id', '=', 'executors.id')
                ->leftjoin('users', 'executors.user_id', '=', 'users.id')
                ->select(
                    'incidents.*',
                    'equipment.name as equipmentname',
                    'users.name as name',
                    'equipment.contractor_id as contractor',
                    'equipment.serial_number as serial_number'
                );
        }
        if (auth()->user()->is_admin || auth()->user()->is_chief) {
            return Incident::where('condition', '!=', '????????????????')
                ->leftjoin('equipment', 'incidents.equipment_id', '=', 'equipment.id')
                ->leftjoin('executors', 'incidents.executor_id', '=', 'executors.id')
                ->leftjoin('users', 'executors.user_id', '=', 'users.id')
                ->select(
                    'incidents.*',
                    'equipment.name as equipmentname',
                    'users.name as name',
                    'equipment.contractor_id as contractor',
                    'equipment.serial_number as serial_number'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [
            'equipment' => ['name', 'serial_number'],
            'employee', 'executor' => [
                'user' => 'surname', 'name', 'patronymic'
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            // ->addColumn('influence', function(Incident $model) {
            //     return $model->influence == '?????????? ?????????????? ???? ??????????' ? '????' : ($model->influence == '?????????????? ?????????????? ???? ??????????' ? '????' : '????');
            // })
            ->addColumn('influence')
            ->addColumn('equipment_id')
            ->addColumn('executor_id')
            ->addColumn('condition')
            ->addColumn('description')
            ->addColumn('creator_id');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->makeInputRange('incidents.id')
                ->hidden(true, false),

            Column::add()
                ->title('?????????????? ???? ??????????')
                ->field('influence')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('????????????????????????')
                ->field('equipmentname')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('???????????????? ??? ????-??')
                ->field('serial_number')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('????????????')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('????????????')
                ->field('condition')
                ->sortable()
                ->searchable(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Incident Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        if (auth()->user()->is_admin || auth()->user()->is_chief) {
            return [
                Button::add('selectPerformer')
                    ->caption('???')
                    ->class('bg-inherit')
                    ->openModal('incidents.update', ['id' => 'id', 'contractor_id' => 'contractor']),

                Button::add('more')
                    ->caption('???????')
                    ->class('bg-inherit')
                    ->openModal('incidents.show', ['id' => 'id']),

                Button::add('confirm')
                    ->caption(__('??????'))
                    ->class('bg-inherit')
                    ->emit('confirm', ['id' => 'id'])
                    ->method('put'),

                Button::add('reject')
                    ->caption(__('???'))
                    ->class('bg-inherit')
                    ->emit('reject', ['id' => 'id'])
                    ->method('put'),

                Button::add('conclusion')
                    ->caption('??????')
                    ->class('bg-inherit')
                    ->openModal('incidents.update', ['id' => 'id', 'contractor_id' => 'contractor']),

            ];
        } elseif (auth()->user()->is_performer) {
            return [
                Button::add('accept')
                    ->caption('??????')
                    ->class('bg-inherit')
                    ->emit('confirm', ['id' => 'id'])
                    ->method('put'),

                Button::add('conclusion')
                    ->caption('??????')
                    ->class('bg-inherit')
                    ->openModal('incidents.update', ['id' => 'id', 'contractor_id' => 'contractor']),
            ];
        }

        if (auth()->user()->is_user) {
            return [
                Button::add('more')
                    ->caption('???????')
                    ->class('bg-inherit')
                    ->openModal('incidents.show', ['id' => 'id'])
            ];
        }
    }

    // public function incidentId(array $data) {
    //     return $data['id'];
    // }




    // public function header(): array
    // {
    //     return [

    //     ];
    // }
    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Incident Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */


    public function actionRules(): array
    {
        if (auth()->user()->is_performer) {
            return [
                Rule::button('accept')
                    ->when(fn ($incident) => $incident->condition == '??????????'),

                Rule::button('accept')
                    ->when(fn ($incident) => $incident->condition == '????????????')
                    ->hide(),

                Rule::button('accept')
                    ->when(fn ($incident) => $incident->condition == '???????????????? ????????????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '???????????????? ????????????????????????')
                    ->hide(),

                Rule::button('accept')
                    ->when(fn ($incident) => $incident->condition == '???? ????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '???? ????????????????')
                    ->hide(),

                Rule::button('accept')
                    ->when(fn ($incident) => $incident->condition == '???? ??????????????????')
                    ->hide(),
                // Rule::button('conclusion')
                //     ->when(fn($incident) => $incident->condition == '??????????' || fn($incident) => $incident->condition == '???????????? ?? ????????????')
            ];
        }
        if (auth()->user()->is_user) {
            return [];
        }
        if (auth()->user()->is_admin || auth()->user()->is_chief) {
            return [
                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '?????????? ??????????????????????')
                    ->hide(),

                Rule::button('reject')
                    ->when(fn ($incident) => $incident->condition == '?????????? ??????????????????????')
                    ->hide(),

                Rule::rows()
                    ->when(fn ($incident) => $incident->condition == '???? ????????????????????????')
                    ->setAttribute('class', 'bg-green-500 text-white hover:text-black'),

                Rule::button('selectPerformer')
                    ->when(fn ($incident) => $incident->condition == '???? ????????????????????????')
                    ->hide(),

                Rule::button('reject')
                    ->when(fn ($incident) => $incident->condition == '???? ????????????????????????')
                    ->hide(),

                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '????????????????')
                    ->hide(),

                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '??????????')
                    ->hide(),

                Rule::button('reject')
                    ->when(fn ($incident) => $incident->condition == '??????????')
                    ->hide(),

                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '???????????????? ????????????????????????')
                    ->hide(),

                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '????????????')
                    ->hide(),

                Rule::button('reject')
                    ->when(fn ($incident) => $incident->condition == '????????????')
                    ->hide(),

                Rule::button('selectPerformer')
                    ->when(fn ($incident) => $incident->condition == '????????????')
                    ->hide(),

                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '???? ??????????????????')
                    ->hide(),

                Rule::button('selectPerformer')
                    ->when(fn ($incident) => $incident->condition == '???? ??????????????????')
                    ->hide(),

                Rule::button('reject')
                    ->when(fn ($incident) => $incident->condition == '???? ??????????????????')
                    ->hide(),

                Rule::button('confirm')
                    ->when(fn ($incident) => $incident->condition == '?????????? ??????????????????????')
                    ->hide(),

                Rule::button('reject')
                    ->when(fn ($incident) => $incident->condition == '?????????? ??????????????????????')
                    ->hide(),
                ////////////////////////////////

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '?????????? ??????????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '??????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '???????????????? ????????????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '???? ??????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '?????????? ??????????????????????')
                    ->hide(),

                Rule::button('conclusion')
                    ->when(fn ($incident) => $incident->condition == '???? ????????????????')
                    ->hide(),
                // Rule::button('selectPerformer')
                //     ->when(fn($incident) => $incident->condition == '??????????')
                //     ->hide(),   
                // Rule::rows()
                //     ->when(fn($incident) => $incident->condition == '????????????????')
                //     ->setAttribute('class', 'bg-green hover:text-black'),







                // Rule::button('confirm')
                //     ->when(fn($incident) => $incident->condition == '?????????? ??????????????????????')
                //     ->hide(),  

                // Rule::button('reject')
                //     ->when(fn($incident) => $incident->condition == '?????????? ??????????????????????')
                //     ->hide(), 

                // Rule::button('selectPerformer')
                //     ->when(fn($incident) => $incident->condition == '???? ????????????????')
                //     ->hide(), 

                // Rule::button('selectPerformer')
                //     ->when(fn($incident) => $incident->condition == '???? ??????????????????')
                //     ->hide(),  

                // Rule::button('reject')
                //     ->when(fn($incident) => $incident->condition == '???? ??????????????????')
                //     ->hide(), 



                // Rule::button('confirm')
                //     ->when(fn($incident) => $incident->condition == '???????????????? ????????????????????????')
                //     ->hide(),
                // 
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

    public function confirm(array $data): bool
    {
        try {
            if (auth()->user()->is_admin || auth()->user()->is_chief) {
                $updatedAgree = Incident::find($data['id'])
                    ->where('condition', '???? ????????????????????????')
                    ->update([
                        'condition' => '??????????',
                    ]);
                if ($updatedAgree) {
                    IncidentHistory::create([
                        'condition' => '??????????',
                        'user_id' => auth()->user()->id,
                        'incident_id' => $data['id']
                    ]);
                }
            }

            $updatedReview = Incident::find($data['id'])
                ->where('condition', '???? ????????????????')
                ->update([
                    'condition' => '????????????????',
                ]);

            if ($updatedReview) {
                IncidentHistory::create([
                    'condition' => '????????????????',
                    'user_id' => auth()->user()->id,
                    'incident_id' => $data['id']
                ]);
            }

            if (auth()->user()->is_performer) {
                $updated = Incident::find($data['id'])
                    ->update([
                        'condition' => '????????????'
                    ]);

                IncidentHistory::create([
                    'condition' => '????????????',
                    'user_id' => auth()->user()->id,
                    'incident_id' => $data['id']
                ]);
            }
        } catch (QueryException $exception) {
            $updated = false;
        }

        if ($updatedReview) {
            $this->fillData();
        }

        return $updatedReview;
    }

    public function reject(array $data): bool
    {
        $updated = Incident::find($data['id'])
            ->where('condition', '????????????????')
            ->update([
                'condition' => '????????????????',
                'date_completion' => Carbon::now(),
            ]);

        // $updated = Incident::find($data['id'])
        //     ->where('condition', '???? ????????????????????????')
        //     ->update([
        //         'condition' => '????????????????',
        //         'updated_at' => Carbon::now(),
        // ]);

        $updatedReview = Incident::find($data['id'])
            ->where('condition', '???? ????????????????')
            ->update([
                'condition' => '???? ??????????????????',
            ]);
        if ($updatedReview) {
            IncidentHistory::create([
                'condition' => '???? ??????????????????',
                'user_id' => auth()->user()->id,
                'incident_id' => $data['id']
            ]);
        }

        $updatedClose = Incident::find($data['id'])
            ->where('condition', '???????????????? ????????????????????????')
            ->update([
                'condition' => '????????????????',
            ]);

        if ($updatedClose) {
            $this->fillData();
            IncidentHistory::create([
                'condition' => '????????????????',
                'user_id' => auth()->user()->id,
                'incident_id' => $data['id'],
            ]);
        }

        return $updatedClose;
    }

    function refresh()
    {
        $this->fillData();
    }

    /**
     * PowerGrid Incident Update.
     *
     * @param array<string,string> $data
     */


    // public function update(array $data ): bool
    // {
    //    try {
    //        $updated = Incident::query()->find($data['id'])
    //             ->update([
    //                 $data['field'] => $data['value'],
    //             ]);
    //    } catch (QueryException $exception) {
    //        $updated = false;
    //    }
    //    return $updated;
    // }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
}
