@extends('layouts.dashboard')

@section('header')
<i class="fas fa-history"></i> Histórico de estoque
@endsection

@section('content')

@if(count($data->products) > 0)
@foreach($data->products as $product)
<h4 class="fw-bold">{{ $data->name }} ➡️ {{ $product->name }}</h4>
@include('dataTable', [
    'table_id' => 'table_history',
    'searching' => "false",
    'paging' => "false",
    'info' => "false",
    'order' => "0",
    'order_type' => "desc",
    'models' => $product->inventory->inventoryHistory,
    'column_defs' => '[{"targets": [0, 2], "responsivePriority": 90}, {"targets": [1, 3], "responsivePriority": 1}]',
    'columns' => [
        "created_at" => [
            "header" => "Data",
            "model_function" => function ($model) { 
                return date_create($model->created_at)->format("d/m/Y H:i:s");
            }
        ],
        "user" => [
            "header" => "Responsável",
            "model_function" => function ($model) { 
                return ($model->user ? $model->user->name : "Sistema");
            }
        ],
        "quantity" => [
            "header" => "Quantidade",
            "model_function" => function ($model) { 
                return "<span class='fw-bold ".($model->quantity > 0 ? "text-success" : "text-danger")."'>" . $model->quantity . "</span>";
            }
        ],
        "description" => [
            "header" => "Descrição"
        ],
    ]
])
<hr>
@endforeach
@else
<h4 class="fw-bold">{{ $data->name }}</h4>
@include('dataTable', [
    'table_id' => 'table_history',
    'searching' => "false",
    'paging' => "false",
    'info' => "false",
    'order' => "0",
    'order_type' => "desc",
    'models' => $data->inventory->inventoryHistory,
    'column_defs' => '[{"targets": [0, 2], "responsivePriority": 90}, {"targets": [1, 3], "responsivePriority": 1}]',
    'columns' => [
        "created_at" => [
            "header" => "Data",
            "model_function" => function ($model) { 
                return date_create($model->created_at)->format("d/m/Y H:i:s");
            }
        ],
        "user" => [
            "header" => "Responsável",
            "model_function" => function ($model) { 
                return ($model->user ? $model->user->name : "Sistema");
            }
        ],
        "quantity" => [
            "header" => "Quantidade",
            "model_function" => function ($model) { 
                return "<span class='fw-bold ".($model->quantity > 0 ? "text-success" : "text-danger")."'>" . $model->quantity . "</span>";
            }
        ],
        "description" => [
            "header" => "Descrição"
        ],
    ]
])
@endif

@endsection

@section('footer')
<p class="text-muted mb-0">Os dados são atualizados junto com a pagina.</p>
@endsection
