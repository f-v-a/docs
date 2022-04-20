<?php

namespace App\Http\Livewire\Tables;

use App\Models\User;
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

final class UserTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'users.id';
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
        return User::query()
        ->leftjoin('positions', 'users.position_id', '=', 'positions.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->select('users.*', 'positions.name as position', 'roles.name as role');
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
            'role' => [
                'name'
            ],
            'position' => [
                'name'
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
            ->addColumn('name')
            ->addColumn('surname')
            ->addColumn('patronymic')
            ->addColumn('login')
            ->addColumn('role_id')
            ->addColumn('phone')
            ->addColumn('email');
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
                ->makeInputRange('users.id')
                ->hidden(true, false),

            Column::add()
                ->title('Фамилия')
                ->field('surname')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Имя')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Отчество')
                ->field('patronymic')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Логин')
                ->field('login')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Роль')
                ->sortable()
                ->field('role')
                ->searchable(),

            Column::add()
                ->title('Должность')
                ->sortable()
                ->field('position')
                ->searchable(),

            Column::add()
                ->title('Телефон')
                ->sortable()
                ->field('phone')
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Email')
                ->sortable()
                ->field('email')
                ->searchable()
                ->hidden(true, false),
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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
        if(auth()->user()->is_admin) {
            return [
                Button::add('edit')
                    ->caption('✏️')
                    ->class('bg-inherit')
                    ->openModal('users.update', ['id' => 'id']),

                Button::add('destroy')
                    ->caption('❌')
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
     * PowerGrid User Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($user) => $user->id === 1)
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
     * PowerGrid User Update.
     *
     * @param array<string,string> $data
     */

    public function header(): array
    {
        if(auth()->user()->is_admin) {
            return [
                Button::add('create')
                    ->caption(__('Добавить'))
                    ->class('cursor-pointer block bg-indigo-500 text-white border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                    ->openModal('users.store', []),
            ];
        } else {
            return [];
        }
    }

    public function destroy(array $data): void
    {
        $deleted = User::findOrFail($data['id'])->delete();
    }

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = User::query()->findOrFail($data['id'])
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
