 <?php 
 $cid= $_GET['id'] ?? "";
 if(empty($cid)){
    throw new ErrorException("Error: This page requires a category ID.");
 }
 $category_qry = $conn->query("SELECT * FROM category_list where id = $cid");
 if (!$category_qry) {
    print $conn->error;
 }

 if($category_qry->num_rows > 0){
    $data = $category_qry->fetch_assoc();

 }else{
    throw new ErrorException("Error: This page requires a category ID.");
 }
 
 ?>

 <style>

:root {
    --primary-red: #dc3545;
    --primary-red-dark: #b02a37;
    --dark: #000000;
    --gray: #6c757d;
    --light: #f8f9fa;
}

/* Masthead / Cabeçalho */
.masthead {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/img/bg-pizza.jpg');
    background-size: cover;
    background-position: center;
    min-height: 60vh;
    display: flex;
    align-items: center;
    position: relative;
}

.masthead h1 {
    font-size: 4rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.masthead hr {
    width: 80px;
    height: 3px;
    background: var(--primary-red);
    opacity: 1;
    margin: 20px auto;
}

/* Seção do Menu */
.page-section {
    padding: 60px 0;
    background: var(--light);
}

.page-section h1 {
    color: var(--dark);
    font-weight: 800;
    position: relative;
    display: inline-block;
}

.page-section h1 b {
    color: var(--primary-red);
}

/* Cards de produtos */
.menu-item {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    background: white;
    height: 100%;
}

.menu-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(220,53,69,0.15);
}

#item-img-holder {
    height: 220px;
    overflow: hidden;
}

#item-img-holder img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.menu-item:hover #item-img-holder img {
    transform: scale(1.1);
}

.menu-item .card-body {
    padding: 1.25rem;
}

.menu-item .card-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--dark);
}

.menu-item .card-text {
    font-size: 0.85rem;
    color: var(--gray);
    line-height: 1.4;
    margin-bottom: 1rem;
}

.truncate {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Botão View */
.btn-outline-dark {
    border-radius: 50px;
    padding: 6px 20px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid var(--dark);
    color: var(--dark);
    background: transparent;
}

.btn-outline-dark:hover {
    background: var(--primary-red);
    border-color: var(--primary-red);
    color: white;
    transform: scale(1.02);
}

/* Paginação */
.paginate-btns {
    background: white;
    border-radius: 50px;
    padding: 5px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.paginate-btns .btn {
    border-radius: 50px;
    margin: 0 3px;
    padding: 8px 16px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    color: var(--gray);
    background: white;
}

.paginate-btns .btn:hover:not(.disabled) {
    background: var(--primary-red);
    border-color: var(--primary-red);
    color: white;
}

.paginate-btns .btn.active {
    background: var(--primary-red);
    border-color: var(--primary-red);
    color: white;
    box-shadow: 0 2px 8px rgba(220,53,69,0.3);
}

.paginate-btns .disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.paginate-btns .ellipsis {
    background: transparent;
    border: none;
    cursor: default;
}

.paginate-btns .ellipsis:hover {
    background: transparent;
    color: var(--gray);
}

/* Responsivo */
@media (max-width: 992px) {
    .masthead {
        min-height: 40vh;
    }
    
    .masthead h1 {
        font-size: 2.5rem;
    }
    
    .page-section h1 {
        font-size: 2rem;
    }
    
    #item-img-holder {
        height: 180px;
    }
}

@media (max-width: 768px) {
    .masthead h1 {
        font-size: 1.8rem;
    }
    
    .page-section {
        padding: 40px 0;
    }
    
    .page-section h1 {
        font-size: 1.6rem;
    }
    
    #item-img-holder {
        height: 200px;
    }
    
    .paginate-btns .btn {
        padding: 5px 10px;
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .masthead {
        min-height: 30vh;
    }
    
    .masthead h1 {
        font-size: 1.4rem;
    }
    
    .page-section h1 {
        font-size: 1.3rem;
    }
    
    .menu-item .card-title {
        font-size: 1rem;
    }
    
    .btn-outline-dark {
        padding: 5px 15px;
        font-size: 0.7rem;
    }
}

/* Animações */
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

.menu-item {
    animation: fadeInUp 0.5s ease-out forwards;
    opacity: 0;
}

.menu-item:nth-child(1) { animation-delay: 0.05s; }
.menu-item:nth-child(2) { animation-delay: 0.1s; }
.menu-item:nth-child(3) { animation-delay: 0.15s; }
.menu-item:nth-child(4) { animation-delay: 0.2s; }
.menu-item:nth-child(5) { animation-delay: 0.25s; }
.menu-item:nth-child(6) { animation-delay: 0.3s; }
.menu-item:nth-child(7) { animation-delay: 0.35s; }
.menu-item:nth-child(8) { animation-delay: 0.4s; }

/* Scrollbar personalizada */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: var(--primary-red);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-red-dark);
}
</style>

 <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-center mb-4 page-title">
                    	<h1 class="text-white"><?= $data['name'] ?? "" ?></h1>
                        <hr class="divider my-4 bg-dark" />

                    </div>
                    
                </div>
            </div>
        </header>
	<section class="page-section" id="menu">
        <h1 class="text-center text-cursive" style="font-size:3em"><b><?= $data['name'] ?? "" ?>'s Menu</b></h1>
        <div class="d-flex justify-content-center">
            <hr class="border-dark" width="5%">
        </div>
        <div class="row mx-0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="menu-field" class="card-deck px-2 py-3 justify-content-center">
                        <?php 
                            include 'admin/db_connect.php';
                            $limit = 10;
                            $page = (isset($_GET['_page']) && $_GET['_page'] > 0) ? $_GET['_page'] - 1 : 0 ;
                            $offset = $page > 0 ? $page * $limit : 0;
                            $all_menu =$conn->query("SELECT id FROM  product_list")->num_rows;
                            $page_btn_count = ceil($all_menu / $limit);
                            $qry = $conn->query("SELECT * FROM  product_list where category_id = '{$cid}' order by name asc Limit $limit OFFSET $offset ");
                            while($row = $qry->fetch_assoc()):
                            ?>
                            <div class="col-lg-3 mb-3">
                            <div class="card menu-item  rounded-0">
                                <div class="position-relative overflow-hidden" id="item-img-holder">
                                    <img src="assets/img/<?php echo $row['img_path'] ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body rounded-0">
                                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                                <p class="card-text truncate"><?php echo $row['description'] ?></p>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-outline-dark view_prod btn-block" data-id=<?php echo $row['id'] ?>><i class="fa fa-eye"></i> View</button>
                                    
                                </div>
                                </div>
                                
                            </div>
                            </div>
                            <?php endwhile; ?>
                </div>
            </div>
        </div>

        <div class="row mx-0">
            <div class="w-100 mx-4 d-flex justify-content-center">
                <div class="btn-group paginate-btns">

                    <a class="btn btn-default border border-dark" <?php echo ($page == 0)? 'disabled' :'' ?> href="./?_page=<?php echo ($page) ?>">Prev.</a>

                    <?php for($i = 1; $i <= $page_btn_count; $i++): ?>
                    <?php if($page_btn_count > 10): ?>

                        <?php if($i = $page_btn_count && !in_array($i, range( ($page - 3), ($page + 3) ) )): ?>
                            <a class="btn btn-default border border-dark ellipsis">...</a>
                        <?php endif; ?>
                

                        <?php if($i == 1 || $i == $page_btn_count || (in_array($i, range( ($page - 3), ($page + 3) ) )) ): ?>
                            <a class="btn btn-default border border-dark <?php echo ($i == ($page + 1)) ? 'active' : '';  ?>" href = "./?_page=<?php echo $i ?>"><?php echo $i; ?></a>
                            <?php if($i == 1 && !in_array($i, range( ($page - 3), ($page + 3) ) )): ?>
                                <a class="btn btn-default border border-dark ellipsis">...</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <a class="btn btn-default border border-dark <?php echo ($i == ($page + 1)) ? 'active' : '';  ?>" href = "./?_page=<?php echo $i ?>"><?php echo $i; ?></a>
                    <?php endif; ?>

                    <?php endfor; ?>
                    <a class="btn btn-default border border-dark" <?php echo (($page+1) == $page_btn_count)? 'disabled' :'' ?> href="./?_page=<?php echo ($page+2) ?>">Next</a>

                </div>
            </div>
        </div>

    </section>
    <script>
        
        $('.view_prod').click(function(){
            uni_modal_right('Product Details','view_prod.php?id='+$(this).attr('data-id'))
        })
    </script>
    <?php if(isset($_GET['_page'])): ?>
        <script>
            $(function(){
                document.querySelector('html').scrollTop = $('#menu').offset().top - 100
            })
        </script>
    <?php endif; ?>
	
