<?php 
include 'admin/db_connect.php';

$id = $_GET['id'];

$qry = $conn->query("SELECT * FROM product_list WHERE id = $id");

if (!$qry) {
    echo $conn->error;
    exit;
}
if($qry->num_rows > 0){
    $prod = $qry->fetch_assoc();
}else{
    echo "Not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $prod['name'] ?> | Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; padding: 20px; margin: 0; color: #333; }
        .product-card { background: white; border-radius: 12px; max-width: 450px; margin: 20px auto; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .product-img { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        .product-title { font-size: 22px; font-weight: 700; margin: 10px 0; color: #222; }
        .product-description { color: #6c757d; font-size: 14px; line-height: 1.6; margin-bottom: 20px; min-height: 50px; }
        
        .qty-control { display: flex; align-items: center; justify-content: center; background: #f1f3f5; border-radius: 8px; padding: 5px; margin-bottom: 20px; }
        .qty-btn { background: white; border: 1px solid #dee2e6; width: 40px; height: 40px; cursor: pointer; font-size: 20px; border-radius: 6px; transition: all 0.2s; }
        .qty-btn:hover { background: #e9ecef; }
        .qty-input { width: 60px; border: none; background: transparent; text-align: center; font-size: 18px; font-weight: 600; outline: none; }
        

        .qty-input::-webkit-inner-spin-button, .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

        .btn-add-cart { background: #28a745; color: white; border: none; padding: 16px; width: 100%; cursor: pointer; font-size: 16px; font-weight: 600; border-radius: 8px; transition: background 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-add-cart:hover { background: #218838; }
        .btn-add-cart:disabled { background: #6c757d; cursor: not-allowed; opacity: 0.8; }
        
        .loading-spinner { display: none; width: 18px; height: 18px; border: 3px solid rgba(255,255,255,.3); border-radius: 50%; border-top-color: #fff; animation: spin 1s ease-in-out infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="product-card">
    <img src="assets/img/<?php echo $prod['img_path'] ?>" class="product-img" alt="<?php echo $prod['name'] ?>">
    
    <h2 class="product-title"><?php echo $prod['name'] ?></h2>
    <p class="product-description"><?php echo nl2br($prod['description']) ?></p>
    
    <div class="qty-control">
        <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
        <input type="number" id="qty" class="qty-input" value="1" min="1" readonly>
        <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
    </div>
    
    <button class="btn-add-cart" id="addBtn">
        <div class="loading-spinner" id="spinner"></div>
        <span id="btnText">Add to Car</span>
    </button>
</div>

<script>

function updateQty(val) {
    var qty = parseInt($('#qty').val());
    var newVal = qty + val;
    if(newVal >= 1) $('#qty').val(newVal);
}

$(document).ready(function() {
    $('#addBtn').click(function() {
        var btn = $(this);
        var spinner = $('#spinner');
        var btnText = $('#btnText');
        var qty = $('#qty').val();
        var pid = '<?php echo $id; ?>';
        
        btn.prop('disabled', true);
        spinner.show();
        btnText.text('Add...');
        
        $.ajax({
            url: 'admin/ajax.php?action=add_to_cart',
            method: 'POST',
            data: { pid: pid, qty: qty },
            error: err => {
                console.log(err);
                alert("Error to save.");
                resetBtn();
            },
            success: function(resp) {
                if(resp == 1) {

                    btn.css('background', '#007bff').text('Sucesso!');
                    
                    setTimeout(() => {
                        if(window.parent && window.parent.location) {
                            window.parent.location.reload();
                        } else {
                            location.reload();
                        }
                    }, 800);
                } else {
                    alert('Error: ' + resp);
                    resetBtn();
                }
            }
        });        

        function resetBtn() {
            btn.prop('disabled', false);
            spinner.hide();
            btnText.text('Addd to car');
        }
    });
});

</script>

</body>
</html>