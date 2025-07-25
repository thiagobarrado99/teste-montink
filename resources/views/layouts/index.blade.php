@php
$cart = session('cart', []);
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montink - Moda com Estilo</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="/styles/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <script type="module" src="https://kit.fontawesome.com/11551bd62e.js" crossorigin="anonymous"></script>
    <script src="/scripts/jquery.min.js"></script>
    <style>
        body {
            padding-top: 80px;
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white;
        }
        .logo {
            height: 40px;
        }
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .product-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        .cart-popup {
            position: fixed;
            top: 80px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            display: none;
        }
        .stock-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .in-stock {
            color: #28a745;
        }
        .low-stock {
            color: #ffc107;
        }
        .out-of-stock {
            color: #dc3545;
        }
        .btn-primary {
            background-color: #212529;
            border-color: #212529;
        }
        .btn-primary:hover {
            background-color: #343a40;
            border-color: #343a40;
        }
    </style>
</head>
<body>
    <!-- Fixed Header -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/logopreta.png" alt="Montink" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="/login">
                            <i class="fas fa-user-cog me-1"></i> Painel Admin
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="cartButton">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-primary rounded-pill" id="cartCount">{{ count($cart) }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Popup -->
    <div class="cart-popup p-3" id="cartPopup">
        <h5 class="mb-3">Seu Carrinho</h5>
        <div id="cartItems">
            @if(count($cart) > 0)
            @foreach ($cart as $product)
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <span class="fw-bold">{{ $product["name"] }}</span>
                    <br>
                    <small>x{{ $product["quantity"] }}</small>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-muted">Seu carrinho está vazio</p>
            @endif
        </div>
        <hr>
        <a href="{{ route('cart') }}" class="btn btn-primary w-100">Finalizar Compra</a>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield("content")
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sobre a Montink</h5>
                    <p>Esta página inteira é apenas um projeto de Mini ERP, criado para o teste técnico da empresa Montink.</p>
                </div>
                <div class="col-md-3">
                    <h5>Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Link super interessante</a></li>
                        <li><a href="#" class="text-white">Melhor link do mundo</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> thiagobarrado99@gmail.com</li>
                        <li><i class="fas fa-phone me-2"></i> (11) 12345-6789</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Thiago de Souza. <a href="https://theiagod.com" target="_blank" class="fw-bold">theiagod.com</a> Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- jQuery and Bootstrap JS -->
    <script src="/scripts/popper.min.js"></script>
    <script src="/scripts/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {           
            $.ajaxSetup({
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            // Toggle cart popup
            $('#cartButton').click(function(e) {
                e.preventDefault();
                $('#cartPopup').toggle();
            });
            
            // Close cart when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('#cartButton, #cartPopup').length) {
                    $('#cartPopup').hide();
                }
            });
        });
    </script>
    @include('sweetalert::alert')
</body>
</html>