@extends('layouts.dashboard')

@section('header')
<i class="fas fa-tshirt"></i> Produtos <a href="{{ route('products.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Criar produto</a>
@endsection

@section('content')
<script>
    function Delete(id)
    {
        Swal.fire({
            title: 'Você realmente deseja excluir esse produto?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Voltar',
            denyButtonColor: "#0d6efd",
            confirmButtonColor: "#dc3545"
            }).then((result) => {
            if (result.isConfirmed) {
                $("#delete_form").attr("action", `{{ route('products.index') }}/${id}`);
                $("#delete_form").submit();
            } else if (result.isDenied) {

            }
        });
    }
    function ShowVariations(id)
    {
        $("#variations_modal").modal("show");
        $("#variations_modal_list").html("<i class='fas fa-spinner fa-spin'></i> Carregando...");

        var jqxhr = $.ajax(`/dashboard/products/${id}`)
            .done(function(data) {
                $("#variations_modal_list").html(`<div class='row'>
                    <div class='fw-bold col-sm-8'>Nome</div>
                    <div class='fw-bold col-sm-4'>Estoque</div>
                </div>`);
                data.products.forEach(element => {
                    $("#variations_modal_list").append(`<div class='row border-top'>
                        <div class='col-sm-8'>${element.name}</div>
                        <div class='col-sm-4'>${element.inventory.quantity}</div>
                    </div>`);
                });
            });
    }
</script>

@include('dataTable', [
    'table_id' => 'table_products',
    'models' => $data,
    'column_defs' => '[{"targets": [1, 2, 3], "responsivePriority": 90}, {"targets": [0, 4], "responsivePriority": 1}]',
    'columns' => [
        "id" => [
            "header" => "ID"
        ],
        "name" => [
            "header" => "Informações",
            "model_function" => function ($model) { 
                return $model->name .
                        (count($model->products) > 0 ? "<br>Variações: " . count($model->products) : "") .
                        "<br><span style='font-size: 80%; line-height: 80%;'>Criado por: " . $model->user->name . "</span>";
            }
        ],
        "inventory" => [
            "header" => "Estoque total",
            "model_function" => function ($model) { 
                return (count($model->products) > 0 ? $model->products->sum(fn($item) => $item->inventory?->quantity ?? 0) : $model->inventory->quantity);
            }
        ],
        "address" => [
            "header" => "Preço",
            "model_function" => function ($model) {
                return money_format($model->price);
            }
        ]
    ],
    'action_column' => function ($model){ return 
    (count($model->products) > 0 ? '<button onclick="ShowVariations(\''.$model->id.'\');" role="button" type="button" title="Variações" class="btn mx-1 btn-sm btn-info text-white"><i class="fas fa-fw fa-clone"></i></button>' : '') .
    '<a href="'.route("products.edit", ["product" => $model->id]).'" title="Editar" class="btn mx-1 btn-sm btn-primary"><i class="fas fa-fw fa-pen"></i></a>' . 
    '<button onclick="Delete(\''.$model->id.'\');" title="Excluir" class="btn mx-1 btn-sm btn-danger"><i class="fas fa-fw fa-trash-can"></i></button>
    '; },
])
<div class="modal fade" id="variations_modal" tabindex="-1" role="dialog" aria-labelledby="variations_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Variações</h5>
            </div>
            <div id="variations_modal_list" class="modal-body text-center">

            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal" class="btn btn-danger">Voltar</button>
            </div>
        </div>
    </div>
</div>
<form id="delete_form" action="{{ route('products.index') }}/delete" method="post">
    @csrf
    @method("DELETE")
</form>
@endsection

@section('footer')
<p class="text-muted mb-0">Os dados são atualizados junto com a pagina.</p>
@endsection
