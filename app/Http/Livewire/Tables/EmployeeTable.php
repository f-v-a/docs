<?php

namespace App\Http\Livewire\Tables;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class EmployeeTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'employees.id';
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

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'destroy',
            ]);
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
        return Employee::query()
        ->leftjoin('users', 'employees.user_id', '=', 'users.id')
        ->leftjoin('positions', 'users.position_id', '=', 'positions.id')
        ->select('employees.*', 
        'positions.name as position',
        'users.surname as surname',
        'users.name as name',
        'users.patronymic as patronymic',
        'users.email as email',
        'users.phone as phone');
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
            'user' => [
                'surname', 'name', 'patronymic', 'email', 'phone',

                'position' => [
                    'name'
                ],
            ]
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
            ->addColumn('user_id')
            ->addColumn('gender')
            ->addColumn('birthday_formatted', function(Employee $model) { 
                return Carbon::parse($model->birthday)->format('d/m/Y');
            })
            ->addColumn('cabinet_number');
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
                ->makeInputRange('employees.id')
                ->hidden(true, false),

            Column::add()
                ->title('??????????????')
                ->field('surname')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('??????')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('????????????????')
                ->field('patronymic')
                ->sortable()
                ->searchable(),

                Column::add()
                ->title('??????????????????')
                ->field('position')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('??????????????')
                ->field('phone')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Email')
                ->field('email')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('?????????? ????????????????')
                ->field('cabinet_number')
                ->sortable()
                ->searchable(),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Employee Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
        if(auth()->user()->is_admin) {
            return [
                Button::add('edit')
                    ->caption('??????')
                    ->class('bg-inherit')
                    ->openModal('employees.update', ['id' => 'id']),

                Button::add('destroy')
                    ->caption('???')
                    ->class('bg-inherit')
                    ->emit('destroy', ['id' => 'id'])
                    ->method('delete')
            ];
        } else {
            return [];
        }
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Employee Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($employee) => $employee->id === 1)
                ->hide(),
        ];
    }
    */

    public function destroy(array $data): void
    {
        $deleted = Employee::findOrFail($data['id'])->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid Employee Update.
     *
     * @param array<string,string> $data
     */


    public function header(): array
    {
        if(auth()->user()->is_admin) {
            return [
                Button::add('create')
                    ->caption(__('????????????????'))
                    ->class('cursor-pointer block bg-indigo-500 text-white border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                    ->openModal('employees.store', []),
            ];
        } else {
            return [];
        }
    }

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Employee::query()->findOrFail($data['id'])
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
