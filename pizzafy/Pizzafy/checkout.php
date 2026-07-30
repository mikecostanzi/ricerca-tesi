<?php
session_start();
include 'admin/db_connect.php';

if(!isset($_SESSION['login_user_id'])) {
    header("Location: index.php");
    exit;
}

$chk = $conn->query("SELECT * FROM cart WHERE user_id = {$_SESSION['login_user_id']}");
if($chk->num_rows <= 0){
    echo "<script>alert('You don\'t have an Item in your cart yet.'); location.replace('./')</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Pizza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-center mb-4 page-title">
                    <h1 class="text-dark">Checkout</h1>
                    <hr class="divider my-4 bg-dark" />
                </div>
            </div>
        </div>
    </header>
    
    <div class="container mb-5">
        <div class="card">
            <div class="card-body">
                <form action="" id="checkout-frm">
                    <h4>Confirm Delivery Information</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Firstname</label>
                                <input type="text" name="first_name" required class="form-control" value="<?php echo $_SESSION['login_first_name'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Lastname</label>
                                <input type="text" name="last_name" required class="form-control" value="<?php echo $_SESSION['login_last_name'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="email" name="email" required class="form-control" value="<?php echo $_SESSION['login_email'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Contact</label>
                                <input type="text" name="mobile" required class="form-control" value="<?php echo $_SESSION['login_mobile'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Address</label>
                        <textarea cols="30" rows="3" name="address" required class="form-control"><?php echo $_SESSION['login_address'] ?? ''; ?></textarea>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-danger btn-block">Place Order</button>
                        <a href="index.php?page=home" class="btn btn-secondary">Back to Cart</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        $('#checkout-frm').submit(function(e){
            e.preventDefault();
            
            $.ajax({
                url: "admin/ajax.php?action=save_order",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'text',
                success: function(resp){
                    if(resp.trim() == '1'){
                        alert("Order successfully placed!");
                        window.location.href = 'index.php?page=home';
                    } else {
                        alert("Error: " + resp);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: " + error);
                }
            });
        });
    });
    </script>
</body>
</html>