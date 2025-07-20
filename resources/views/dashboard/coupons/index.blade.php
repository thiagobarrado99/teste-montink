@extends('layouts.dashboard')

@section('header')
<i class="fas fa-tag"></i> Cupons <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Criar cupom</a>
@endsection

@section('content')
<script>
    function Delete(id)
    {
        Swal.fire({
            title: 'Você realmente deseja excluir esse cupom?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Voltar',
            denyButtonColor: "#0d6efd",
            confirmButtonColor: "#dc3545"
            }).then((result) => {
            if (result.isConfirmed) {
                $("#delete_form").attr("action", `{{ route('coupons.index') }}/${id}`);
                $("#delete_form").submit();
            } else if (result.isDenied) {

            }
        });
    }
</script>
@include('dataTable', [
    'table_id' => 'table_coupons',
    'models' => $data,
    'column_defs' => '[{"targets": [0, 1, 3, 4], "responsivePriority": 90}, {"targets": [2, 5], "responsivePriority": 1}]',
    'columns' => [
        "id" => [
            "header" => "ID"
        ],
        "name" => [
            "header" => "Informações",
            "model_function" => function ($model) { 
                return "Nome: " . $model->name .
                        "<br>Código: <span class='fw-bold'>" . $model->code . "</span>" . 
                        ($model->max_uses ? "<br>Usos: " . $model->total_uses . "/" . $model->max_uses : "<br>Usos: " . $model->total_uses) .
                        "<br><span style='font-size: 80%; line-height: 80%;'>Criado por: " . $model->user->name . "</span>";
            }
        ],
        "minimum_price" => [
            "header" => "Valor minimo",
            "model_function" => function ($model) { return $model->minimumFormatted(); }
        ],
        "is_percentage" => [
            "header" => "Tipo",
            "model_function" => function ($model) { return $model->is_percentage ? "Porcentagem" : "Fixo"; }
        ],
        "discount_value" => [
            "header" => "Desconto",
            "model_function" => function ($model) { return $model->discountFormatted(); }
        ],
        "expires_at" => [
            "header" => "Expira em",
            "model_function" => function ($model) { return date_create($model->expires_at)->format("d/m/Y H:i:s"); }
        ]
    ],
    'action_column' => function ($model){ return '
    <a href="'.route("coupons.edit", ["coupon" => $model->id]).'" title="Editar" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
    <button onclick="Delete(\''.$model->id.'\');" title="Excluir" class="btn btn-sm btn-danger"><i class="fas fa-trash-can"></i></button>
    '; },
])
<form id="delete_form" action="{{ route('coupons.index') }}/delete" method="post">
    @csrf
    @method("DELETE")
</form>
@endsection

@section('footer')
<p class="text-muted mb-0">Os dados são atualizados junto com a pagina.</p>
@endsection
