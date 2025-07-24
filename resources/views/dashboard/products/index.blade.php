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
    function EditInventory(id)
    {
        $("#inventory_modal").modal("show");
        $("#inventory_modal_list").html("<i class='fas fa-spinner fa-spin'></i> Carregando...");

        var jqxhr = $.ajax(`/dashboard/products/${id}`)
            .done(function(data) {
                $("#inventory_modal_list").html(``);
                if(data.products.length > 0)
                {
                    data.products.forEach(element => {
                        $("#inventory_modal_list").append(`<div class='row'>
                            <div class="col-sm-8 mb-2">
                                <label class="w-100">
                                    Nome*
                                    <input class="w-100 form-control" type="text" maxlength="64" required name="products[${element.id}][name]" value="${element.name}">
                                </label>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label class="w-100">
                                    Estoque*
                                    <input class="w-100 form-control" type="number" step="1" min="0" max="9999999" name="products[${element.id}][quantity]" value="${element.inventory.quantity}">
                                </label>
                            </div>        
                        </div>`);
                    });
                }else{
                    $("#inventory_modal_list").append(`<div class='row'>
                        <div class="col-sm-8 mb-2">
                            <label class="w-100">
                                Nome*
                                <input class="w-100 form-control" type="text" maxlength="64" required name="products[${data.id}][name]" value="${data.name}">
                            </label>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <label class="w-100">
                                Estoque*
                                <input class="w-100 form-control" type="number" step="1" min="0" max="9999999" name="products[${data.id}][quantity]" value="${data.inventory.quantity}">
                            </label>
                        </div>        
                    </div>`);
                }
                
            });
    }
    function EditProduct(id)
    {
        $("#edit_modal").modal("show");
        $("#edit_modal_body").html("<i class='fas fa-spinner fa-spin'></i> Carregando...");
        $("#edit_form").attr("action", `{{ route('products.index') }}/${id}`);

        var jqxhr = $.ajax(`/dashboard/products/${id}`)
            .done(function(data) {
                $("#edit_modal_body").html(`<div class="row">
                    <div class="col-sm-8 mb-2">
                        <label class="w-100">
                            Nome*
                            <input class="w-100 form-control" type="text" maxlength="64" required name="name" value="${data.name}">
                        </label>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <label class="w-100">
                            Preço*
                            <input class="w-100 form-control mask-money" type="text" name="price" value="${String(data.price).replace(".", ",")}">
                        </label>
                    </div>        
                </div>
                <div class="row">
                    <div class="col-md-8 mb-2">
                        <label class="w-100">
                            Descrição
                            <input class="w-100 form-control" type="text" maxlength="256" name="description" value="${data.description}">
                        </label>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="w-100">
                            Foto
                            <input class="w-100 form-control" type="file" name="picture">
                        </label>
                    </div>
                </div>
                `);
                applyMoneyMask();
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
                        ($model->description ? "<br>".$model->description : "") .
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
        '<button onclick="EditInventory(\''.$model->id.'\');" title="'.(count($model->products) > 0 ? "Estoque & Variações" : "Estoque" ).'" class="btn mx-1 btn-sm btn-secondary text-white"><i class="fas fa-fw '.(count($model->products) > 0 ? "fa-clone" : "fa-box" ).'"></i></button>' .
        '<a href="'.route("products.history", ["id" => $model->id]).'" title="Histórico" class="btn mx-1 btn-sm btn-info"><i class="fas text-white fa-fw fa-history"></i></a>' . 
        '<button onclick="EditProduct(\''.$model->id.'\');" title="Editar" class="btn mx-1 btn-sm btn-primary"><i class="fas fa-fw fa-pen"></i></button>' . 
        '<button onclick="Delete(\''.$model->id.'\');" title="Excluir" class="btn mx-1 btn-sm btn-danger"><i class="fas fa-fw fa-trash-can"></i></button>'; 
    },
])
<div class="modal fade" id="inventory_modal" tabindex="-1" role="dialog" aria-labelledby="inventory_modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estoque</h5>
            </div>
            <form action="{{ route('products.massUpdate') }}" method="post">
                @csrf
                <div id="inventory_modal_list" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-danger">Voltar</button>
                    <input type="submit" class="btn btn-success" value="Confirmar alterações">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar produto</h5>
            </div>
            <form id="edit_form" method="post" enctype="multipart/form-data">
                @method("PUT")
                @csrf
                <div id="edit_modal_body" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-danger">Voltar</button>
                    <input type="submit" class="btn btn-success" value="Confirmar alterações">
                </div>
            </form>
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
