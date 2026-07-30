<!-- Masthead -->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1 class="text-white">Welcome <?php echo $_SESSION['setting_name']; ?></h1>
                <hr class="divider my-4 bg-dark" />
                <a class="btn btn-danger btn-xl js-scroll-trigger" href="#menu">
                    <i class="fas fa-utensils"></i> Place Order Now
                </a>
            </div>
        </div>
    </div>
</header>

<section class="page-section" id="menu">
    <div class="container">
        <h1 class="text-center" style="font-size: 3em; font-weight: 700;">
            <span class="text-danger">Our</span> Menu
        </h1>
        <div class="d-flex justify-content-center">
            <hr class="border-danger" width="10%" style="height: 3px;">
        </div>
        
        <div id="menu-field" class="row g-4 mt-2 justify-content-center">
            <?php 
            include 'admin/db_connect.php';
            
            $limit = 8;
            $current_page = isset($_GET['_page']) ? (int)$_GET['_page'] : 1;
            $offset = ($current_page - 1) * $limit;
            
            $total_items = $conn->query("SELECT id FROM product_list")->num_rows;
            $total_pages = ceil($total_items / $limit);
            
            $qry = $conn->query("SELECT * FROM product_list ORDER BY `name` ASC LIMIT $limit OFFSET $offset");
            
            while($row = $qry->fetch_assoc()):
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="assets/img/<?php echo $row['img_path'] ?>" 
                             class="card-img-top w-100 h-100 object-fit-cover" 
                             alt="<?php echo $row['name'] ?>"
                             style="transition: transform 0.3s; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold"><?php echo $row['name'] ?></h5>
                        <p class="card-text text-muted small truncate"><?php echo substr($row['description'], 0, 80) ?>...</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-danger fw-bold fs-5">R$ <?php echo number_format($row['price'], 2, ',', '.') ?></span>
                            <button class="btn btn-sm btn-danger view_prod" data-id="<?php echo $row['id'] ?>">
                                <i class="fas fa-eye"></i> Ver detalhes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <?php if($total_pages > 1): ?>
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <!-- Botão Anterior -->
                    <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?_page=<?php echo $current_page - 1; ?>#menu" 
                           <?php echo ($current_page <= 1) ? 'tabindex="-1"' : ''; ?>>
                            <i class="fas fa-chevron-left"></i> Anterior
                        </a>
                    </li>
                    
                    <?php if($current_page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="?_page=1#menu">1</a>
                        </li>
                        <?php if($current_page > 4): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php for($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link <?php echo ($i == $current_page) ? 'bg-danger border-danger' : ''; ?>" 
                               href="?_page=<?php echo $i; ?>#menu">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if($current_page < $total_pages - 2): ?>
                        <?php if($current_page < $total_pages - 3): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="?_page=<?php echo $total_pages; ?>#menu">
                                <?php echo $total_pages; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?_page=<?php echo $current_page + 1; ?>#menu"
                           <?php echo ($current_page >= $total_pages) ? 'tabindex="-1"' : ''; ?>>
                            Próximo <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
$(document).ready(function() {

    $('.view_prod').click(function() {
        var id = $(this).attr('data-id');
        uni_modal_right('Detalhes do Produto', 'view_prod.php?id=' + id);
    });
    

    $('.js-scroll-trigger').click(function(e) {
        e.preventDefault();
        var target = $(this.hash);
        if(target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 800);
        }
    });
});

<?php if(isset($_GET['_page'])): ?>
$(function() {
    setTimeout(function() {
        var menu = $('#menu');
        if(menu.length) {
            $('html, body').animate({
                scrollTop: menu.offset().top - 70
            }, 500);
        }
    }, 100);
});
<?php endif; ?>
</script>

<style>

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
    
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    
    .pagination .page-link {
        color: #dc3545;
    }
    
    .pagination .page-link:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    
    @media (max-width: 768px) {
        .col-lg-3 {
            margin-bottom: 1rem;
        }
    }
</style>