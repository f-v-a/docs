<?php

namespace App\Http\Livewire\Tables;

use App\Models\Contractor;
use App\Models\Equipment;
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

final class EquipmentsTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;
    
    public string $primaryKey = 'equipment.id';
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
                'writtenOff',
                'decommissioned'
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
    public function datasource()
    {
        return Equipment::where('status', '!=', 'Списано')
        ->where('status', '!=', 'Выведено из эксплуатации')
        ->leftjoin('contractors', 'equipment.contractor_id', '=', 'contractors.id')
        ->select('equipment.*', 'contractors.name as contractor');
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
            'model' => [
                'name'
            ],
            'contractor' => [
                'name'
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
            ->addColumn('description')
            ->addColumn('cabinet_number')
            ->addColumn('manufacture_date_formatted', function(Equipment $model) { 
                return Carbon::parse($model->manufacture_date)->format('d/m/Y');
            })
            ->addColumn('buy_date_formatted', function(Equipment $model) { 
                return Carbon::parse($model->buy_date)->format('d/m/Y');
            })
            ->addColumn('commissioning_date_formatted', function(Equipment $model) { 
                return Carbon::parse($model->commissioning_date)->format('d/m/Y');
            })
            ->addColumn('warranty_period')
            ->addColumn('status')
            ->addColumn('model_id')
            ->addColumn('contractor_id')
            ->addColumn('price')
            ->addColumn('serial_number');
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
                ->makeInputRange('equipment.id')
                ->hidden(true, false),

            Column::add()
                ->title('Описание')
                ->field('description')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Наименование')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Серийный номер')
                ->field('serial_number')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('КонтрАгент')
                ->field('contractor')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('№ Кабинета')
                ->field('cabinet_number')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Цена')
                ->field('price')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Дата производства')
                ->field('manufacture_date_formatted')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Дата покупки')
                ->field('buy_date_formatted')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Начало использования')
                ->field('commissioning_date_formatted')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Гарантия(мес)')
                ->field('warranty_period')
                ->sortable()
                ->searchable()
                ->hidden(true, false),

            Column::add()
                ->title('Статус')
                ->field('status')
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
     * PowerGrid Equipment Action Buttons.
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
                    ->openModal('equipments.update', ['id' => 'id']),
            ];
        } else {
            return [];
        }
            // Button::add('destroy')
            //     ->caption('Delete')
            //     ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            //     ->route('equipment.destroy', ['equipment' => 'id'])
            //     ->method('delete')
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Equipment Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */
    
    // public function actionRules(): array
    // {
    //     return [

    //     ];
    // }


    public function header(): array
    {
        if(auth()->user()->is_admin) {
            return [
                Button::add('writtenOff')
                    ->caption(__('Списать оборудование'))
                    ->class('cursor-pointer block bg-indigo-500 text-white border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                    ->emit('writtenOff', ['id' => 'id']),

                Button::add('decommissioned')
                ->caption(__('Вывести из эксплуатации'))
                ->class('cursor-pointer block bg-indigo-500 text-white border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->emit('decommissioned', ['id' => 'id']),
            ];
        } else {
            return [];
        }
    }

    
    public function writtenOff(): bool
    {
        try {
            foreach($this->checkboxValues as $selectedCheckbox) {
                $updated = Equipment::query()->findOrFail($selectedCheckbox)
                ->update([
                    'status' => 'Списано',
                ]);
            }
        } catch (QueryException $exception) {
            $updated = false;
        }
        return $updated;
    }

    public function decommissioned(): bool
    {
        try {
            foreach($this->checkboxValues as $selectedCheckbox) {
                $updated = Equipment::query()->findOrFail($selectedCheckbox)
                ->update([
                    'status' => 'Выведено из эксплуатации',
                ]);
            }
        } catch (QueryException $exception) {
            $updated = false;
        }
        return $updated;
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
     * PowerGrid Equipment Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Equipment::query()->findOrFail($data['id'])
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
