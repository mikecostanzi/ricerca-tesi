<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();
include('header.php');
include('admin/db_connect.php');

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach ($query as $key => $value) {
    if(!is_numeric($key))
        $_SESSION['setting_'.$key] = $value;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['setting_name'] ?> | E-commerce Pizza</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #dc3545;
            --primary-dark: #b02a37;
            --dark: #000000;
            --gray: #6c757d;
            --light: #f8f9fa;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            overflow-x: hidden;
        }

        body.dark-mode {
            background: #1a1a1a;
            color: #fff;
        }

        body.dark-mode .card,
        body.dark-mode .navbar,
        body.dark-mode footer {
            background: #2d2d2d !important;
            color: #fff !important;
        }

        .navbar {
            background: rgba(0,0,0,0.95) !important;
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: var(--transition);
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, var(--primary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent !important;
        }

        .hero {
            height: 90vh;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            opacity: 0.1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
        }

        .hero .highlight {
            color: var(--primary);
        }

        .typing-text {
            font-size: 1.5rem;
            border-right: 3px solid var(--primary);
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            animation: typing 3s steps(30, end) forwards, blink 1s infinite;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink {
            0%, 100% { border-color: transparent; }
            50% { border-color: var(--primary); }
        }

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            transform-style: preserve-3d;
        }

        .product-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .product-card .card-img {
            height: 250px;
            overflow: hidden;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        .product-card .card-body {
            padding: 1.5rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .glass-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .offcanvas-cart {
            position: fixed;
            right: -400px;
            top: 0;
            width: 400px;
            height: 100vh;
            background: white;
            z-index: 1050;
            transition: var(--transition);
            box-shadow: -5px 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .offcanvas-cart.open {
            right: 0;
        }

        body.dark-mode .offcanvas-cart {
            background: #2d2d2d;
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .dark-mode-toggle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: var(--transition);
        }

        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }

        .cart-float {
            position: fixed;
            bottom: 20px;
            right: 90px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            transition: var(--transition);
        }

        .cart-float:hover {
            transform: scale(1.1);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #000;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .offcanvas-cart {
                width: 100%;
                right: -100%;
            }
            
            .typing-text {
                font-size: 1rem;
                white-space: normal;
                animation: none;
                border-right: none;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toast-modern {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #000;
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1100;
            transform: translateX(-120%);
            transition: var(--transition);
        }

        .toast-modern.show {
            transform: translateX(0);
        }
    </style>
</head>

<body>

    <div class="dark-mode-toggle" onclick="toggleDarkMode()">
        <i class="fas fa-moon" style="color: white; font-size: 1.5rem;"></i>
    </div>

    <div class="cart-float" onclick="toggleCart()">
        <i class="fas fa-shopping-cart" style="color: white; font-size: 1.5rem;"></i>
        <span class="cart-count item_count">0</span>
    </div>

    <div class="offcanvas-cart" id="cartOffcanvas">
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-shopping-cart"></i> My Cart</h4>
                <button class="btn btn-sm btn-danger" onclick="toggleCart()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="cart-items">
                <p class="text-center text-muted">Your cart is empty.</p>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                <strong id="cart-total">R$ 0,00</strong>
            </div>
            <button class="btn btn-primary w-100 mt-3" onclick="checkout()">
                <i class="fas fa-credit-card"></i> Complete Purchase
            </button>
        </div>
    </div>

    <div class="toast-modern" id="liveToast">
        <i class="fas fa-check-circle" style="color: #4CAF50;"></i>
        <span id="toastMessage">Product added to cart!</span>
    </div>

    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="./">
                <i class="fas fa-store"></i> <?php echo $_SESSION['setting_name'] ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?page=home">Home</a></li>
                    <?php 
                    $categories = $conn->query("SELECT * FROM `category_list` order by `name` asc");
                    if($categories->num_rows > 0):
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu">
                            <?php while($row = $categories->fetch_assoc()): ?>
                                <li><a class="dropdown-item" href="index.php?page=category&id=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=about">Sobre</a></li>
                    <?php if(isset($_SESSION['login_user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="admin/ajax.php?action=logout2">
                            <i class="fas fa-user"></i> <?= $_SESSION['login_first_name'] ?> <i class="fas fa-sign-out-alt"></i>
                        </a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="javascript:void(0)" id="login_now">Sign in</a></li>
                        <li class="nav-item"><a class="nav-link" href="./admin">Administrator</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<div class="modal fade" id="confirm_modal" tabindex="-1" aria-labelledby="confirm_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm_modal_label">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirm">Continue</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uni_modal" tabindex="-1" aria-labelledby="uni_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uni_modal_label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit" onclick="submitModalForm()">Salve Now</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uni_modal_right" tabindex="-1" aria-labelledby="uni_modal_right_label" aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uni_modal_right_label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

    <section class="hero">
        <div class="hero-content">
            <h1 data-aos="fade-up">
                Werlcome <span class="highlight"><?php echo $_SESSION['setting_name'] ?></span>
            </h1>
            <div class="typing-text" data-aos="fade-up" data-aos-delay="200">
                The best products at the best prices!
            </div>
            <button class="btn btn-danger btn-lg mt-4" data-aos="fade-up" data-aos-delay="400" onclick="scrollToProducts()">
                <i class="fas fa-shopping-bag"></i> Buy Now
            </button>
        </div>
    </section>

    <?php 
    $page = isset($_GET['page']) ? $_GET['page'] : "home";
    include $page.'.php';
    ?>

    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <h5><i class="fas fa-store"></i> <?php echo $_SESSION['setting_name'] ?></h5>
                    <p class="text-muted">Your trusted store with the best products and prices.</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <h5>Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php?page=home" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="index.php?page=about" class="text-muted text-decoration-none">About</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Terms of Use</a></li>
                    </ul>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <h5>Contato</h5>
                    <p class="text-muted"><i class="fas fa-envelope"></i> clara.rodriguez.ebook@gmail.com</p>
                    <p class="text-muted"><i class="fas fa-phone"></i> (11) 99999-9999</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center text-muted">
                Copyright © <?= date("Y") ?> - <?= $_SESSION['setting_name'] ?>
            </div>
        </div>
    </footer>

    <?php include('footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
<script>

function loadCart() {
    $.ajax({
        url: 'admin/ajax.php?action=get_cart_items',
        method: 'GET',
        dataType: 'json',
        success: function(resp) {
            var items = resp.items || [];
            var total = 0;
            var itemCount = 0;
            var cartContainer = $('#cart-items');
            var totalContainer = $('#cart-total');
            
            if(items.length === 0) {
                cartContainer.html('<p class="text-center text-muted">Seu carrinho está vazio</p>');
                totalContainer.text('R$ 0,00');
                $('.item_count').text('0');
                return;
            }
            
            cartContainer.empty();
            items.forEach(function(item) {
                var subtotal = parseFloat(item.price) * parseInt(item.qty);
                total += subtotal;
                itemCount += parseInt(item.qty);
                cartContainer.append(`
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <div>
                            <strong class="d-block">${item.name}</strong>
                            <small class="text-muted">${item.qty} x R$ ${parseFloat(item.price).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</small>
                        </div>
                        <div class="text-end">
                            <span class="d-block">R$ ${subtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                            <button class="btn btn-sm text-danger" onclick="removeFromCart(${item.cart_id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
            });
            
            totalContainer.text('R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2}));
            $('.item_count').text(itemCount);
        },
        error: function() {
            console.log('Erro ao carregar carrinho');
        }
    });
}

function removeFromCart(cartId) {
    $.ajax({
        url: 'admin/ajax.php?action=delete_cart',
        method: 'POST',
        data: {id: cartId},
        success: function(resp) {
            if(resp.trim() == '1') {
                loadCart();
                showToast('Item removido do carrinho!', 'success');
            }
        }
    });
}

function toggleCart() {
    $('#cartOffcanvas').toggleClass('open');
    if($('#cartOffcanvas').hasClass('open')) {
        loadCart();
    }
}

function showToast(message, type) {
    var toast = $('#liveToast');
    var toastMessage = $('#toastMessage');
    var icon = toast.find('i');
    
    toastMessage.text(message);
    
    if(type === 'error') {
        icon.css('color', '#dc3545');
        icon.removeClass('fa-check-circle').addClass('fa-exclamation-circle');
    } else {
        icon.css('color', '#4CAF50');
        icon.removeClass('fa-exclamation-circle').addClass('fa-check-circle');
    }
    
    toast.addClass('show');
    setTimeout(function() {
        toast.removeClass('show');
    }, 3000);
}

function addToCartFromModal(pid, qty) {
    $.ajax({
        url: 'admin/ajax.php?action=add_to_cart',
        method: 'POST',
        data: {pid: pid, qty: qty},
        dataType: 'text',
        success: function(resp) {
            if(resp.trim() == '1') {
                loadCart();
                $('#uni_modal_right').modal('hide');
                showToast('Produto adicionado ao carrinho!', 'success');
            } else {
                showToast('Erro ao adicionar produto!', 'error');
            }
        },
        error: function() {
            showToast('Erro de conexão!', 'error');
        }
    });
}

function checkout() {
    window.location.href = 'checkout.php';
}

$(document).ready(function() {
    loadCart();
    
    if(localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        $('.dark-mode-toggle i').removeClass('fa-moon').addClass('fa-sun');
    }
});

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    var isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDark);
    var icon = $('.dark-mode-toggle i');
    if(isDark) {
        icon.removeClass('fa-moon').addClass('fa-sun');
    } else {
        icon.removeClass('fa-sun').addClass('fa-moon');
    }
}

function scrollToProducts() {
    $('.product-section').length && $('html, body').animate({
        scrollTop: $('.product-section').offset().top - 70
    }, 800);
}
</script>
   
   
</body>

<?php $conn->close() ?>
</html>

<?php 
$overall_content = ob_get_clean();
echo $overall_content;
?>