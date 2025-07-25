@extends('layouts.index')

@section('content')
@php
$total = 0;
@endphp
<script>
    function RemoveFromCart(sender, id)
    {
        $(sender).toggleClass("disabled", true);
        $(sender).html("<i class='fas fa-spinner fa-spin'></i>&nbsp;Removendo...");

        $("#remove_form").attr("action", `/products/${id}`);
        $("#remove_form").submit();
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
        @php
        $total += $cart[$product->id]["quantity"] * $product->price;
        @endphp
        <tr class="border-top border-bottom">
            <td>{{ $cart[$product->id]["quantity"] }}x {{ ($product->product ? $product->product->name.">".$product->name : $product->name) }}</td>
            <td>{{ money_format($cart[$product->id]["quantity"] * $product->price) }}</td>
            <td><button onclick="RemoveFromCart(this, '{{ $product->id }}')" role="button" class="w-100 btn btn-danger">Remover</button></td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="mt-4 fw-bold text-end">Total: {{ money_format($total) }}</p>
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
