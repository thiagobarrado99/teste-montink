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
        ])
        
        @include('sidebarItem', [
            'item_title' => 'Pedidos',
            'item_url' => route('orders.index'),
            'item_icon' => 'fa-box',
        ])

        @include('sidebarItem', [
            'item_title' => 'Cupons',
            'item_url' => route('coupons.index'),
            'item_icon' => 'fa-tag',
        ])
        
        @include('sidebarItem', [
            'item_title' => 'Clientes',
            'item_url' => route('clients.index'),
            'item_icon' => 'fa-users',
        ])
    </ul>
</div>