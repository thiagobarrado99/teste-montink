@extends('layouts.index')

@section('content')
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
                    <button class="btn btn-primary w-100 mt-2">Escolher variação ({{ count($product->products) }})</button>
                    @else
                    <button class="btn btn-primary w-100 mt-2 add-to-cart" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Adicionar ao Carrinho</button>
                    @endif
                    @else
                    <button class="btn btn-secondary w-100 mt-2" disabled>Indisponível</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
