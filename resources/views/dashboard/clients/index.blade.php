@extends('layouts.dashboard')

@section('header')
<i class="fas fa-users"></i> Clientes
@endsection

@section('content')

@include('dataTable', [
    'table_id' => 'table_clients',
    'models' => $data,
    'column_defs' => '[{"targets": [1, 2], "responsivePriority": 90}, {"targets": [0, 3], "responsivePriority": 1}]',
    'columns' => [
        "id" => [
            "header" => "ID"
        ],
        "name" => [
            "header" => "Informações",
            "model_function" => function ($model) { 
                return "Nome: " . $model->name .
                        ($model->tax_id ? "<br>Documento: " . $model->tax_id : "") .
                        ($model->email ? "<br>Email: " . $model->email : "") .
                        ($model->phone ? "<br>Telefone: " . $model->phone : "");
            }
        ],
        "address" => [
            "header" => "Endereço",
            "model_function" => function ($model) {
                return $model->address . ", " . $model->number . 
                        "<br>".$model->neighborhood . 
                        "<br>".$model->city . " - " . $model->state .
                        "<br>".$model->zipcode;
            }
        ]
    ],
    'action_column' => function ($model){ return ''; },
])
@endsection

@section('footer')
<p class="text-muted mb-0">Os dados são atualizados junto com a pagina.</p>
@endsection
