<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Menu Principal -->
    <h6 class="category-title">Menu Principal</h6>
    <ul class="nav flex-column">
        @include('sidebarItem', [
            'item_title' => 'Dashboard',
            'item_url' => route('dashboard'),
            'item_icon' => 'fa-tachometer-alt',
        ])

        @include('sidebarItem', [
            'item_title' => 'Produtos',
            'item_url' => route('products.index'),
            'item_icon' => 'fa-tshirt',
            'item_create_url' => route("products.create"),
        ])
        
        @include('sidebarItem', [
            'item_title' => 'Pedidos',
            'item_url' => route('orders.index'),
            'item_icon' => 'fa-box'
        ])

        @include('sidebarItem', [
            'item_title' => 'Cupons',
            'item_url' => route('coupons.index'),
            'item_icon' => 'fa-tag',
            'item_create_url' => route("coupons.create"),
        ])
        
        @include('sidebarItem', [
            'item_title' => 'Clientes',
            'item_url' => route('clients.index'),
            'item_icon' => 'fa-users'
        ])
        
        @include('sidebarItem', [
            'item_title' => 'Regras de envio',
            'item_url' => route('shipping.index'),
            'item_icon' => 'fa-truck'
        ])
    </ul>
</div>