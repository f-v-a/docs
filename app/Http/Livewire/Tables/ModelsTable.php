<?php

namespace App\Http\Livewire\Tables;

use App\Models\EquipmentModel;
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

final class ModelsTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'equipment_models.id';
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
            ->showExportOption('otchet', ['excel', 'csv']);
    }

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'destroy',
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
        return EquipmentModel::query()
            ->leftjoin('equipment_types', 'equipment_models.type_id', '=', 'equipment_types.id')
            ->select('equipment_models.*', 'equipment_types.name as type');
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
            'type' => [
                'name',
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
            ->addColumn('name')
            ->addColumn('type_id')
            ->addColumn('manufacturer');
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
        if (auth()->user()->is_admin) {
            return [
                Column::add()
                    ->title('ID')
                    ->field('id', 'equipment_models.id')
                    ->makeInputRange('equipment_models.id')
                    ->hidden(true, false),

                Column::add()
                    ->title('Наименование')
                    ->field('name')
                    ->sortable()
                    ->searchable()
                    ->editOnClick(),

                Column::add()
                    ->title('Тип оборудования')
                    ->sortable()
                    ->searchable()
                    ->field('type'),

                Column::add()
                    ->title('Производитель')
                    ->field('manufacturer')
                    ->sortable()
                    ->searchable(),
            ];
        } else {
            return [
                Column::add()
                    ->title('ID')
                    ->field('id', 'equipment_models.id')
                    ->makeInputRange('equipment_models.id')
                    ->hidden(true, false),

                Column::add()
                    ->title('Наименование')
                    ->field('name')
                    ->sortable()
                    ->searchable(),

                Column::add()
                    ->title('Тип оборудования')
                    ->field('type'),

                Column::add()
                    ->title('Производитель')
                    ->field('manufacturer')
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid EquipmentModel Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        if (auth()->user()->is_admin) {
            return [
                Button::add('edit')
                    ->caption('✏️')
                    ->class('bg-inherit')
                    ->openModal('models.update', ['id' => 'id']),

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
     * PowerGrid EquipmentModel Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($equipment-model) => $equipment-model->id === 1)
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
     * PowerGrid EquipmentModel Update.
     *
     * @param array<string,string> $data
     */

    public function header(): array
    {
        if (auth()->user()->is_admin) {
            return [
                Button::add('create')
                    ->caption(__('Добавить'))
                    ->class('cursor-pointer block bg-indigo-500 text-white border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                    ->openModal('models.store', []),
            ];
        } else {
            return [];
        }
    }

    function refresh()
    {
        $this->fillData();
    }

    public function destroy(array $data): void
    {
        $deleted = EquipmentModel::findOrFail($data['id'])->delete();
    }

    public function update(array $data): bool
    {
        try {
            $updated = EquipmentModel::query()->findOrFail($data['id'])
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
}
