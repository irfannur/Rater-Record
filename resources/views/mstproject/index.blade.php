@extends('layout.main')

@section('title', 'Project')

@section('content')

<div class="col-md-12">

{!! grid_view([
    'dataProvider' => $dataProvider,
    'useFilters' => false,
    'columnFields' => [
        [
            'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
            'field' => 'delete',
            'attribute' => 'id'
        ], 
        'idproject',
        'projectname',
        'rateperhour',
        [
            'label' => 'Actions', // Optional
            'class' => Itstructure\GridView\Columns\ActionColumn::class, // Required
            'actionTypes' => [ // Required
                'view',
                'edit' => function ($data) {
                    return '/admin/pages/' . $data->id . '/edit';
                },
                [
                    'class' => Itstructure\GridView\Actions\Delete::class, // Required
                    'url' => function ($data) { // Optional
                        return '/admin/pages/' . $data->id . '/delete';
                    },
                    'htmlAttributes' => [ // Optional
                        'target' => '_blank',
                        'style' => 'color: yellow; font-size: 8px;',
                        'onclick' => 'return window.confirm("Are you sure you want to delete?");'
                    ]
                ]
            ]
        ]
    ]
]) !!}

    <ul>
    @foreach($projects as $p) 

    <li>{{$p->projectname}}</li>

    @endforeach
    </ul>
</div>

@endsection