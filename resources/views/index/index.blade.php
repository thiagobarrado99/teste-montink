@extends('layouts.index')

@section('content')
<script>
    function SelectVariant(sender, id)
    {
        $("#variant_modal").modal("show");
        $("#variant_modal_body").html("<i class='fas fa-spinner fa-spin'></i> Carregando...");

        var jqxhr = $.ajax(`/products/${id}`)
            .done(function(data) {
                console.log(data);
                $("#variant_modal_body").html('');
                if(data.products.length > 0)
                {
                    let first = true;
                    data.products.forEach(element => {
                        if(element.inventory.quantity > 0)
                        {
                            $("#variant_modal_body").append(`<p>
                                <label><input type="radio" `+(first ? "checked" : "")+` name="variation" value="${element.id}">&nbsp;${element.name}<br><span class="text-success">${element.inventory.quantity} em estoque</span></label>
                            </p>`);
                            first = false;
                        }else{
                            $("#variant_modal_body").append(`<p>
                                <label><input type="radio" disabled>&nbsp;${element.name}<br><span class="text-danger">Sem estoque</span></label>
                            </p>`);
                        }
                    });
                }else{
                    setTimeout(function(){
                        $("#variant_modal").modal("hide");
                    }, 500);
                }
            });
    }

    function AddToCart(sender, id)
    {
        $(sender).toggleClass("disabled", true);
        $(sender).html("<i class='fas fa-spinner fa-spin'></i>&nbsp;Adicionando...");

        $.ajax({
            url: `/products/${id}`,
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        }).done(function(data) {
            console.log(data);
            $('#cartCount').html(data.length);

            if (data.length === 0) {
                $('#cartItems').html('<p class="text-muted">Seu carrinho está vazio</p>');
                return;
            }
            
            let itemsHtml = '';
            
            data.forEach(item => {               
                itemsHtml += `
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <span class="fw-bold">${item.name}</span>
                            <br>
                            <small>x${item.quantity}</small>
                        </div>
                    </div>
                `;
            });
            
            $('#cartItems').html(itemsHtml);

            Swal.fire({
                toast: true,
                position: 'bottom-end', // top, top-start, top-end, center, bottom, etc.
                icon: 'success',     // success, error, warning, info, question
                title: `Produto adicionado ao carrinho!`,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

        })
        .fail(function(){
            Swal.fire({
                toast: true,
                position: 'bottom-end', // top, top-start, top-end, center, bottom, etc.
                icon: 'error',     // success, error, warning, info, question
                title: `Não temos mais estoque desse produto!`,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        })
        .always(function(){
            $(sender).toggleClass("disabled", false);
            $(sender).html("Adicionar ao Carrinho");
            $("#variant_modal").modal("hide");
        });
    }
</script>
<h1 class="mb-4">Nossos Produtos</h1>
<div class="row">
    @foreach($products as $product)
        @php
        $variations = count($product->products);
        $stock = ($variations > 0 ? $product->products->sum(fn($item) => $item->inventory?->quantity ?? 0) : $product->inventory->quantity);
        @endphp
        <div class="col-md-4 col-sm-6">
            <div class="card product-card">
                <img src="{{ ($product->picture ? Storage::disk('public')->url($product->picture) : '/placeholder.webp') }}" class="card-img-top product-img" alt="Camiseta Básica">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ money_format($product->price) }}</h6>
                        @if($stock > 0)
                        <span class="stock-info in-stock">Em estoque: {{ $stock }}</span>
                        @else
                        <span class="stock-info out-of-stock">Fora de estoque</span>
                        @endif
                    </div>
                    @if($stock > 0)
                    @if($variations > 0)
                    <button class="btn btn-primary w-100 mt-2" onclick="SelectVariant(this, '{{ $product->id }}');">Escolher variação ({{ count($product->products) }})</button>
                    @else
                    <button class="btn btn-primary w-100 mt-2" onclick="AddToCart(this, '{{ $product->id }}');">Adicionar ao Carrinho</button>
                    @endif
                    @else
                    <button class="btn btn-secondary w-100 mt-2" disabled>Indisponível</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="modal fade" id="variant_modal" tabindex="-1" role="dialog" aria-labelledby="variant_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escolha a variação</h5>
            </div>
            <div id="variant_modal_body" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Voltar</button>
                <button onclick="AddToCart(this, $(`input[name='variation']:checked`).val());" type="button" role="button" class="btn btn-success">Adicionar ao carrinho</button>
            </div>
        </div>
    </div>
</div>
@endsection
