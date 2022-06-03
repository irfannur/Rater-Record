<?php

namespace App\Http\Livewire;

use App\Models\mst_project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use NumberFormatter;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Detail, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class MstProject extends PowerGridComponent
{
    use ActionButton;
    var $projectname;
    var $rateperhour;
    var $description;

    public array $perPageValues = [0, 5, 10, 1000, 5000];

    public bool $showUpdateMessages = true;

    public string $primaryKey = 'idproject';

    public string $sortField = 'idproject';

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'rowActionEvent',
                'bulkActionEvent',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */
    public function rowActionEvent(array $data): void
    {
        //dd($data);
        $message = 'You have clicked #' . $data['id'];

        $this->dispatchBrowserEvent('showAlert', ['message' => $message]);
    }

    public function bulkActionEvent(): void
    {
        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);

            return;
        }

        $ids = implode(', ', $this->checkboxValues);

        $this->dispatchBrowserEvent('showAlert', ['message' => 'You have selected IDs: ' . $ids]);
    }

    public function header(): array
    {
        return [
            Button::add('bulk-demo')
                ->caption(__('Bulk Action'))
                ->class('cursor-pointer block bg-indigo-500 text-white border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->emit('bulkActionEvent', [])
        ];
    }
    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped('d0d3d8')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Header::make()->showToggleColumns(), 
            Footer::make()
                ->showPerPage(10, $this->perPageValues)
                ->showRecordCount(),
            Detail::make()
                ->view('components.detail')
                ->options(['name' => 'Luan'])
                ->showCollapseIcon(),
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
            })
            ->addColumn('since_at_formatted', fn (mst_project $model) => Carbon::parse($model->since_at)->format('d/m/Y H:i:s'));
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
        $canEdit = true;

        return [

            Column::make('PROJECTNAME', 'projectname')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick($canEdit),

            Column::make('DESCRIPTION', 'description')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick($canEdit),

            Column::make('RATEPERHOUR', 'rateperhour')
                ->sortable()
                ->searchable()
                ->makeInputText()
                ->editOnClick($canEdit),

            Column::make('SINCE AT', 'since_at_formatted', 'since_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

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
    /*
    public function actions(): array
    {
        return [
            Button::make('info', 'Click me')
                ->class('bg-indigo-500 hover:bg-indigo-600 cursor-pointer text-white px-3 py-2 text-sm rounded-md')
                ->emit('rowActionEvent', ['id' => 'id']),
                //->route('project.edit', ['id' => 'sssds'])
        ];
    }
    */

    
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn btn-primary btn-sm')
               ->route('project.edit', ['id' => 'idproject']),

        //    Button::make('destroy', 'Delete')
        //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        //        ->route('mst_project.destroy', ['mst_project' => 'id'])
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

    // public function onUpdatedEditable(string $id, string $field, string $value): void
    // {
    //     //dd($id);
    //     mst_project::query()->find($id)->update([
    //         $field => $value,
    //     ]);
    // }

    public function onUpdatedEditable(string $id, string $field, string $value): void
    {
        //Clean price_BRL R$ 4.947,70 --> 44947.70 and saves in database field 'price'

        try {
            if ($field == 'rateperhour') {
                $value = \Illuminate\Support\Str::of($value)
                    ->replace('.', '')
                    ->replace(',', '.')
                    ->replaceMatches('/[^Z0-9\.]/', '');
            }

            $updated = mst_project::query()->find($id)
                ->update([
                    $field => $value
                ]);
        } catch (QueryException $exception) {
            $updated = false;
        }   

        //if ($updated) {
            $this->fillData();
        //}
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

    public function template(): ?string
    {
        return null;
    }
}
