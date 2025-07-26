@extends('layouts.index')

@section('content')
<script>
    function RemoveFromCart(sender, id)
    {
        $(sender).toggleClass("disabled", true);
        $(sender).html("<i class='fas fa-spinner fa-spin'></i>&nbsp;Removendo...");

        $("#remove_form").attr("action", `/products/${id}`);
        $("#remove_form").submit();
    }

    function CheckCoupon()
    {
        $("#coupon_code").attr("readonly", true);
        $("#coupon_btn").html("Aplicando...");
        $("#coupon_btn").toggleClass("disabled", true);

        $("#coupon_form").submit();
    }
</script>
<h1 class="mb-4">Carrinho de compras</h1>
<p>Confirme os itens da sua compra:</p>
<table class="w-100">
    <colgroup>
        <col style="width: 60%">
        <col style="width: 20%">
        <col style="width: 20%">
    </colgroup>
    <thead>
        <th>Produto</th>
        <th>Preço</th>
        <th>Ações</th>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr class="border-top border-bottom">
            <td>{{ $cart[$product->id]["quantity"] }}x {{ ($product->product ? $product->product->name.">".$product->name : $product->name) }}</td>
            <td>{{ money_format($cart[$product->id]["quantity"] * $product->price) }}</td>
            <td><button onclick="RemoveFromCart(this, '{{ $product->id }}')" role="button" class="w-100 btn btn-danger">Remover</button></td>
        </tr>
    @endforeach
    </tbody>
</table>
<form id="coupon_form" action="/coupon" method="post">
    @csrf
    <div class="mt-4 fw-bold text-end">
        Cupom de desconto:
        <input id="coupon_code" name="code" class="form-control d-inline-block" style="width: auto;" type="text" maxlength="16" @if($coupon) value="{{ $coupon }}" @endif />
        <button id="coupon_btn" onclick="CheckCoupon();" class="btn btn-primary"><i class="fas fa-fw fa-check"></i> Aplicar</button>
    </div>
</form>
<p class="mb-1 fw-bold text-end">Frete: {{ money_format($shipping) }}</p>
@if($coupon_discount)
<p class="mb-1 fw-bold text-success text-end">Cupom: -{{ money_format($coupon_discount) }}</p>
@endif
<p class="mb-1 fw-bold text-end">Total: {{ money_format($total) }}</p>
<hr class="my-3">
<div class="row justify-content-end">
    <div class="col-sm-3">
        <a href="/" class="w-100 btn btn-success"><i class="fas fa-fw fa-plus"></i> Adicionar mais itens</a>
    </div>
    <div class="col-sm-6">
        &nbsp;
    </div>
    <div class="col-sm-3">
        @if(count($products) > 0)
        <a href="{{ route('cart.shipping') }}" class="w-100 btn btn-primary"><i class="fas fa-fw fa-truck"></i> Preencher endereço</a>
        @endif
    </div>
</div>

<form id="remove_form" method="POST" action="{{ route('cart') }}/-1" class="d-none">
    @csrf
    @method("DELETE")
</form>
@endsection
