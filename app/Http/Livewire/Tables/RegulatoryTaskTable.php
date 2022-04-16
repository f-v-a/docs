<?php

namespace App\Http\Livewire\Tables;

use App\Models\RegulatoryTask;
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

final class RegulatoryTaskTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'regulatory_tasks.id';
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
            ->showExportOption('download', ['excel', 'csv']) :
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
                'more'
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
        return RegulatoryTask::leftjoin('executors', 'regulatory_tasks.executor_id', '=', 'executors.id')
            ->leftjoin('equipment', 'regulatory_tasks.equipment_id', '=', 'equipment.id')
            ->leftjoin('users', 'executors.user_id', '=',  'users.id')
            ->select(
                'regulatory_tasks.*',
                'equipment.name as equipment.name',
                'equipment.serial_number',
                'users.name as name'
            );
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
            'equipment' => ['name'],
            'employee', 'executors' => [
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
            ->addColumn('description')
            ->addColumn('status')
            ->addColumn('start_date_formatted', function (RegulatoryTask $model) {
                return Carbon::parse($model->start_date)->format('d/m/Y');
            })
            ->addColumn('dates')
            ->addColumn('periodicity')
            ->addColumn('end_date')
            ->addColumn('executor_id')
            ->addColumn('equipment_id')
            ->addColumn('mode');
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
                ->makeInputRange('regulatory_tasks.id')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Описание')
                ->field('description')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Активно')
                ->field('status')
                ->toggleable(true, 'Да', 'Нет')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Дата начала')
                ->field('start_date_formatted', 'start_date')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Даты')
                ->field('dates')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Периодичность')
                ->field('periodicity')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Дата конца')
                ->field('end_date')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Мастер')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Оборудование')
                ->field('equipment.name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Серийный номер')
                ->field('serial_number')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Режим')
                ->field('mode')
                ->sortable()
                ->searchable()
                ->hidden(true, false),
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
     * PowerGrid RegulatoryTask Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('regulatory-task.edit', ['regulatory-task' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('regulatory-task.destroy', ['regulatory-task' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid RegulatoryTask Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($regulatory-task) => $regulatory-task->id === 1)
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
     * PowerGrid RegulatoryTask Update.
     *
     * @param array<string,string> $data
     */


    // public function update(array $data): bool
    // {
    //     try {
    //         $updated = RegulatoryTask::query()->findOrFail($data['id'])
    //             ->update([
    //                 $data['field'] => $data['value'],
    //             ]);
    //     } catch (QueryException $exception) {
    //         $updated = false;
    //     }
    //     return $updated;
    // }

    // public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    // {
    //     $updateMessages = [
    //         'success'   => [
    //             '_default_message' => __('Data has been updated successfully!'),
    //             //'custom_field'   => __('Custom Field updated successfully!'),
    //         ],
    //         'error' => [
    //             '_default_message' => __('Error updating the data.'),
    //             //'custom_field'   => __('Error updating custom field.'),
    //         ]
    //     ];

    //     $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

    //     return (is_string($message)) ? $message : 'Error!';
    // }
}
