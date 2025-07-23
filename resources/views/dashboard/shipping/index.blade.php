@extends('layouts.dashboard')

@section('header')
<i class="fas fa-truck"></i> Regras de envio <button onclick="CreateRule()" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Criar regra</button>
@endsection

@section('content')
<script>
    function Delete(id)
    {
        Swal.fire({
            title: 'Você realmente deseja excluir essa regra de envio?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Voltar',
            denyButtonColor: "#0d6efd",
            confirmButtonColor: "#dc3545"
            }).then((result) => {
            if (result.isConfirmed) {
                $("#delete_form").attr("action", `{{ route('shipping.index') }}/${id}`);
                $("#delete_form").submit();
            } else if (result.isDenied) {

            }
        });
    }

    function CreateRule()
    {
        $("#create_modal").modal("show");
    }

    function ChangeType()
    {
        $("#range_unique").toggleClass("d-none", true);
        $("#range_between").toggleClass("d-none", true);

        $("#range_unique").find("input").prop("disabled", true);
        $("#range_between").find("input").prop("disabled", true);

        $("#range_less_than_text").toggleClass("d-none", true);
        $("#range_greater_than_text").toggleClass("d-none", true);
        $("#range_between_text").toggleClass("d-none", true);

        let type = $("#new_rule_type").val();
        switch(type){
            case "0": default:
                $("#range_unique").toggleClass("d-none", false);
                $("#range_less_than_text").toggleClass("d-none", false);
                $("#range_unique").find("input").prop("disabled", false);
                break;
            case "1":
                $("#range_unique").toggleClass("d-none", false);
                $("#range_greater_than_text").toggleClass("d-none", false);
                $("#range_unique").find("input").prop("disabled", false);
                break;
            case "2":
                $("#range_between").toggleClass("d-none", false);
                $("#range_between_text").toggleClass("d-none", false);
                $("#range_between").find("input").prop("disabled", false);
                break;
        }
    }
</script>
@include('dataTable', [
    'table_id' => 'table_shipping_rules',
    'models' => $data,
    'column_defs' => '[{"targets": [1, 2, 3], "responsivePriority": 90}, {"targets": [0, 4], "responsivePriority": 1}]',
    'columns' => [
        "id" => [
            "header" => "ID"
        ],
        "type" => [
            "header" => "Tipo",
            "model_function" => function ($model) { 
                return $model->typeLabel();
            }
        ],
        "range_start" => [
            "header" => "Faixa de valor",
            "model_function" => function ($model) { 
                if($model->type == 2)
                {
                    return "Inicio: " . money_format($model->range_start) . 
                        "<br>Fim: " . money_format($model->range_end);
                }
                return "Valor: " . money_format($model->range_start);
            }
        ],
        "price" => [
            "header" => "Valor do frete",
            "model_function" => function ($model) {
                return money_format($model->price);
            }
        ]
    ],
    'action_column' => function ($model){ return 
        '<button onclick="Delete(\''.$model->id.'\');" title="Excluir" class="btn mx-1 btn-sm btn-danger"><i class="fas fa-fw fa-trash-can"></i></button>'; 
    },
])
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="create_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar regra de envio</h5>
            </div>
            <form action="{{ route('shipping.store') }}" method="post">
                @csrf
                <div id="create_modal_body" class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="w-100">
                                Tipo de calculo*
                                <select id="new_rule_type" onchange="ChangeType()" class="w-100 form-control" name="type">
                                    @foreach (\App\Models\ShippingRule::$typeLabels as $key => $name)
                                        <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="w-100">
                                Valor do frete (vazio para frete grátis)
                                <input class="w-100 form-control mask-money" type="text" name="price" value="0">
                            </label>
                        </div>        
                    </div>
                    <hr>
                    <p id="range_less_than_text" class="fw-bold">Aplicar frete quando o valor do carrinho for menor ou igual a</p>
                    <p id="range_greater_than_text" class="fw-bold d-none">Aplicar frete quando o valor do carrinho for maior ou igual a</p>
                    <p id="range_between_text" class="fw-bold d-none">Aplicar frete quando o valor do carrinho estiver na faixa</p>
                    <div id="range_unique" class="row">
                        <div class="col-md-12 mb-2">
                            <label class="w-100">
                                Valor (Inclusivo, R$)
                                <input class="w-100 form-control mask-money" type="text" required name="range_start" value="0">
                            </label>
                        </div>
                    </div>
                    <div id="range_between" class="row d-none">
                        <div class="col-md-6 mb-2">
                            <label class="w-100">
                                Valor inicial (Inclusivo, R$)
                                <input class="w-100 form-control mask-money" type="text" disabled required name="range_start" value="0">
                            </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="w-100">
                                Valor final (Inclusivo, R$)
                                <input class="w-100 form-control mask-money" type="text" disabled required name="range_end" value="0">
                            </label>
                        </div>        
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-danger">Voltar</button>
                    <input type="submit" class="btn btn-success" value="Criar">
                </div>
            </form>
        </div>
    </div>
</div>
<form id="delete_form" action="{{ route('shipping.index') }}/delete" method="post">
    @csrf
    @method("DELETE")
</form>
@endsection

@section('footer')
<p class="text-muted mb-0">Os dados são atualizados junto com a pagina.</p>
@endsection
