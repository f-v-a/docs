<?php

namespace App\Http\Livewire\Tables;

use App\Models\Employee;
use App\Models\Executor;
use App\Models\Incident;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class CompletedIncidentsTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showToggleColumns()
            ->showExportOption('download', ['excel', 'csv']);
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
        if(auth()->user()->is_performer) {
            return Incident::where('condition', '=', 'Завершен')
            ->where('executor_id', Executor::where('user_id', (auth()->id()))->value('id'))
            ->join('equipment', 'incidents.equipment_id', '=', 'equipment.id')
            ->leftjoin('executors', 'incidents.executor_id', '=', 'executors.id')
            ->leftjoin('users', 'executors.user_id', '=', 'users.id')
            ->select('incidents.*', 'equipment.name as equipmentname',
            'users.name as name', 'equipment.contractor_id as contractor');
        } 
        if(auth()->user()->is_user) {
            return Incident::where('condition', '=', 'Завершен')
            ->where('cabinet_number', Employee::where('user_id', (auth()->id()))->first()->cabinet_number ?? '')
            ->join('equipment', 'incidents.equipment_id', '=', 'equipment.id')
            ->leftjoin('executors', 'incidents.executor_id', '=', 'executors.id')
            ->leftjoin('users', 'executors.user_id', '=', 'users.id')
            ->select('incidents.*', 'equipment.name as equipmentname',
            'users.name as name', 'equipment.contractor_id as contractor');
        }
        if(auth()->user()->is_admin || auth()->user()->is_chief) {
            return Incident::where('condition', '=', 'Завершен')
            ->join('equipment', 'incidents.equipment_id', '=', 'equipment.id')
            ->leftjoin('executors', 'incidents.executor_id', '=', 'executors.id')
            ->leftjoin('users', 'executors.user_id', '=', 'users.id')
            ->select('incidents.*', 'equipment.name as equipmentname',
            'users.name as name', 'equipment.contractor_id as contractor');
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
        return [];
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
            ->addColumn('influence')
            ->addColumn('equipment_id')
            ->addColumn('executor_id')
            ->addColumn('description')
            ->addColumn('creator_id')
            ->addColumn('condition')
            ->addColumn('date_completion_formatted', function(Incident $model) { 
                return Carbon::parse($model->date_completion)->format('d/m/Y');
            })
            ->addColumn('created_at_formatted', function(Incident $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(Incident $model) { 
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });
            // ->addColumn('date_completion_formatted', function(Incident $model) { 
            //     return Carbon::parse($model->date_completion)->format('d/m/Y H:i:s');
            // });
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
            ->makeInputRange(),

            Column::add()
                ->title('Влияние на прием')
                ->field('influence')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Оборудование')
                ->field('equipmentname'),

            Column::add()
                ->title('Мастер')
                ->field('name'),

            Column::add()
                ->title('Завершен')
                ->field('date_completion_formatted', 'date_completion')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('date_completion'),

            Column::add()
                ->title('Статус')
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
       return [
            Button::add('more')
                ->caption('👁️')
                ->class('bg-inherit')
                ->openModal('incidents.show', ['id' => 'id']),
        ];
    }
    

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

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($incident) => $incident->id === 1)
                ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid Incident Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Incident::query()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

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
    */
}
