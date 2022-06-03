<?php

namespace App\Http\Livewire;

use App\Models\mst_project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use NumberFormatter;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class MstProject extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public bool $showUpdateMessages = true;

    public string $primaryKey = 'idproject';

    public string $sortField = 'idproject';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                //->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            
            Header::make()->showSearchInput(),
            Header::make()->showToggleColumns(), 
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
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
     * @return Builder<\App\Models\mst_project>
     */
    public function datasource(): Builder
    {
        return mst_project::query();
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
    public function addColumns(): PowerGridEloquent
    {

        $fmt = new NumberFormatter('pt_PT', NumberFormatter::CURRENCY);

        return PowerGrid::eloquent()
            ->addColumn('projectname')
            ->addColumn('description', function (mst_project $model) {
                return \Illuminate\Support\Str::words($model->description, 8);
            })
            ->addColumn('rateperhour', function (mst_project $model) use ($fmt) {
                return $fmt->formatCurrency($model->rateperhour, "USD");
                //return $model->rateperhour . ' USD';
            })
            //   ->addColumn('rateperhour_uppercase', function (mst_project $model) {
            //     return strtoupper($model->rateperhour);
            //   })
            ->addColumn('since_at_formatted', fn (mst_project $model) => Carbon::parse($model->since_at)->format('d/m/Y H:i:s'))
            ->addColumn('created_at_formatted', fn (mst_project $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (mst_project $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
    }

    public function update(array $data ): bool
    {
        //Clean price_BRL R$ 4.947,70 --> 44947.70 and saves in database field 'price'

        try {
            $updated = mst_project::query()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value']
                ]);
        } catch (QueryException $exception) {
            $updated = false;
        }

        return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success' => [
                '_default_message' => __('Data has been updated successfully!'),
                'price_BRL'        => 'Brazilian price changed!',
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
            Column::make('PROJECTNAME', 'projectname')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('DESCRIPTION', 'description')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('RATEPERHOUR', 'rateperhour')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::add()
                ->title('RATEPERHOUR')
                ->field('rateperhour')
                ->editOnClick(),

            Column::make('SINCE AT', 'since_at_formatted', 'since_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

            // Column::make('CREATED AT', 'created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

            // Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

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
     * PowerGrid mst_project Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
        Button::add('order-dish')
        ->caption('Order')
        ->class('bg-blue-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        ->emit('order-dish', ['dishId' => 'id']), 
        //    Button::make('edit', 'Edit')
        //     ->target(target:'')
        //     ->caption(__(key:'Edit'))
        //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
        //         ->route(route:'project/edit', ['mst_project' => 'idproject']),

        //    Button::make('destroy', 'Delete')
        //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        //        ->route('mst_project.destroy', ['mst_project' => 'idproject'])
        //        ->method('delete')
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
     * PowerGrid mst_project Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($mst_project) => $mst_project->id === 1)
                ->hide(),
        ];
    }
    */
}
