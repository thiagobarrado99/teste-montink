@extends('layouts.dashboard')

@section('header')
    <i class="fas fa-tshirt"></i> Novo produto
@endsection

@section('content')
<script>
    function CreateVariation()
    {
        let randId = randomString(16);
        $("#variation_list").append(`<div id="variation_${randId}" class="row mb-1">
            <div class="col-md-8 mb-2">
                <label class="w-100">
                    Nome*
                    <input class="w-100 form-control" type="text" maxlength="64" required name="variations[${randId}][name]">
                </label>
            </div>
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Estoque inicial
                    <input class="w-100 form-control" type="number" step="1" min="0" max="9999999" name="variations[${randId}][quantity]" value="0">
                </label>
            </div>        
            <div class="col-md-1 mb-2">
                Ações<br>
                <button onclick="RemoveVariation('${randId}')" class="btn btn-danger"><i class="fas fa-fw fa-trash-can"></i></button>
            </div>        
        </div>`);
        CheckVariations();
    }

    function RemoveVariation(variation_id)
    {
        $(`#variation_${variation_id}`).remove();
        CheckVariations();
    }

    function CheckVariations(){
        if($("#variation_list").children().length > 0)
        {
            $("#main_inventory").toggleClass("disabled", true);
            $("#main_inventory").prop("disabled", true);
        }else{
            $("#main_inventory").toggleClass("disabled", false);
            $("#main_inventory").prop("disabled", false);
        }
    }
</script>
<form id="create_form" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-2">
            <label class="w-100">
                Nome*
                <input class="w-100 form-control" type="text" maxlength="128" required name="name">
            </label>
        </div>
        <div class="col-md-3 mb-2">
            <label class="w-100">
                Preço*
                <input class="w-100 form-control mask-money" type="text" required name="price">
            </label>
        </div>
        <div class="col-md-3 mb-2">
            <label class="w-100">
                Estoque inicial
                <input id="main_inventory" class="w-100 form-control" type="number" step="1" min="0" max="9999999" name="quantity" value="0">
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mb-2">
            <label class="w-100">
                Descrição
                <input class="w-100 form-control" type="text" maxlength="256" name="description">
            </label>
        </div>
        <div class="col-md-4 mb-2">
            <label class="w-100">
                Foto
                <input class="w-100 form-control" type="file" name="picture">
            </label>
        </div>
    </div>
    <p class="fw-bold mt-4">Variações <button onclick="CreateVariation();" role="button" type="button" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Criar variação</button></p>
    <div id="variation_list">            
    </div>
    <hr>
    <div class="row mt-4">
        <div class="col-md-6">
            <a href="{{ route('products.index') }}" class="btn btn-danger w-100">Voltar</a>
        </div>
        <div class="col-md-6">
            <input type="submit" class="btn btn-success w-100" value="Criar produto">
        </div>
    </div>
</form>
@endsection

@section('footer')
    <p class="text-muted mb-0">Campos marcados com * são obrigatórios.</p>
@endsection
