@extends('layouts.index')

@section('content')
<script>
    $(document).ready(function(){
        $("#zipcode").on("keyup", function() {
            if ($("#zipcode").val().length == 8)
            {
                let cep = $("#zipcode").val();
                var jqxhr = $.ajax({
                        url: `/cep/${cep}`,
                        method: 'get'
                    })
                    .done(function(data) {
                        $("input[name='state']").val(data.estado);
                        $("input[name='city']").val(data.localidade);
                        $("input[name='neighborhood']").val(data.bairro);
                        $("input[name='address']").val(data.logradouro);
                    });
            }
        });
    });
</script>
<h1 class="mb-4">Dados e endereço para entrega</h1>
<form method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label class="w-100">
                Nome*
                <input class="w-100 form-control" type="text" maxlength="256" required name="name">
            </label>
        </div>
        <div class="col-md-6">
            <label class="w-100">
                CPF
                <input class="w-100 form-control" type="text" maxlength="16" name="tax_id">
            </label>
        </div>
        <div class="col-md-6">
            <label class="w-100">
                Email*
                <input class="w-100 form-control" type="email" maxlength="256" required name="email">
            </label>
        </div>
        <div class="col-md-6">
            <label class="w-100">
                Telefone*
                <input class="w-100 form-control" type="number" maxlength="16" required name="phone">
            </label>
        </div>
    </div>
    <hr>
        <div class="row">
        <div class="col-md-3">
            <label class="w-100">
                CEP*
                <input id="zipcode" class="w-100 form-control" type="number" maxlength="8" required name="zipcode">
            </label>
        </div>
        <div class="col-md-4">
            <label class="w-100">
                Estado*
                <input class="w-100 form-control" readonly type="text" name="state">
            </label>
        </div>
        <div class="col-md-5">
            <label class="w-100">
                Cidade*
                <input class="w-100 form-control" readonly type="text" name="city">
            </label>
        </div>
        <div class="col-md-4">
            <label class="w-100">
                Bairro*
                <input class="w-100 form-control" type="text" maxlength="256" required name="neighborhood">
            </label>
        </div>
        <div class="col-md-6">
            <label class="w-100">
                Rua*
                <input class="w-100 form-control" type="text" maxlength="256" required name="address">
            </label>
        </div>
        <div class="col-md-2">
            <label class="w-100">
                N°*
                <input class="w-100 form-control" type="text" maxlength="16" required name="number">
            </label>
        </div>
    </div>
    <hr class="my-3">
    <div class="row justify-content-end">
        <div class="col-sm-3">
            <a href="{{ route('cart') }}" class="w-100 btn btn-primary"><i class="fas fa-fw fa-shopping-cart"></i> Voltar ao carrinho</a>
        </div>
        <div class="col-sm-6">
            &nbsp;
        </div>
        <div class="col-sm-3">
            <button type="submit" href="/shipping" class="w-100 btn btn-success"><i class="fas fa-fw fa-check"></i> Finalizar pedido</a>
        </div>
    </div>
</form>
@endsection
