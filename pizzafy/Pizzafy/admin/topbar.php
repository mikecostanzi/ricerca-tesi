<style>

    :root {
        --primary: #dc3545;
        --primary-dark: #b02a37;
        --secondary: #dc3545;
        --secondary-dark: #dc3545;
        --success: #28a745;
        --light: #f8f9fa;
        --dark: #343a40;
    }
    
    body {
        background: #f0f2f5 !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .topbar {
        background: var(--secondary-dark);
        padding: 8px 0;
        color: white;
        font-size: 13px;
    }
    
    .topbar a {
        color: white;
        text-decoration: none;
    }
    
    #topNavBar {
        background: #dc3545 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 0 !important;
    }
    
    .logo {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: transform 0.3s;
    }
    
    .logo:hover {
        transform: scale(1.05);
    }
    
    .logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .brand-title {
        font-family: 'Dancing Script', cursive;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
    }
    
    .brand-title a {
        color: white;
        text-decoration: none;
    }
    
    .brand-title small {
        font-size: 0.7rem;
        opacity: 0.85;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.12);
        padding: 6px 18px;
        border-radius: 50px;
        transition: all 0.3s;
    }
    
    .user-info:hover {
        background: rgba(255,255,255,0.2);
    }
    
    .user-info a {
        color: white;
        text-decoration: none;
    }
    
    /* Main Content */
    main#view-panel {
        min-height: calc(100vh - 140px);
        padding: 20px;
        margin-top: 76px;
    }
    
    /* Toast */
    .toast {
        position: fixed;
        top: 85px;
        right: 20px;
        z-index: 9999;
        min-width: 280px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        border: none;
    }
    
    .toast-body {
        padding: 12px 20px;
        font-weight: 500;
        border-radius: 12px;
    }
    
    .toast.bg-success .toast-body {
        background: linear-gradient(135deg, var(--success), #1e7e34);
        color: white;
    }
    
    .toast.bg-danger .toast-body {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }
    
    /* Modais */
    .modal-content {
        border-radius: 16px;
        border: none;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    
    .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border-bottom: none;
        padding: 15px 20px;
    }
    
    .modal-header .modal-title {
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .modal-header .close {
        color: white;
        opacity: 1;
        text-shadow: none;
    }
    
    .modal-footer .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        border-radius: 50px;
        padding: 8px 25px;
    }
    
    .modal-footer .btn-secondary {
        border-radius: 50px;
        padding: 8px 25px;
        background: #6c757d;
        border: none;
    }
    
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 99999;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    #preloader:after {
        content: '';
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    #preloader2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 99998;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    #preloader2:after {
        content: '';
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255,255,255,0.3);
        border-top: 3px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        z-index: 99;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.2);
    }
    
    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        transform: translateY(-3px);
        background: var(--primary-dark);
        color: white;
    }
    
    @media (max-width: 768px) {
        main#view-panel {
            padding: 15px;
            margin-top: 70px;
        }
        
        .brand-title {
            font-size: 1rem;
        }
        
        .brand-title small {
            display: none;
        }
        
        .logo {
            width: 40px;
            height: 40px;
        }
        
        .user-info span {
            display: none;
        }
        
        .user-info {
            padding: 5px 12px;
        }
        
        .toast {
            left: 20px;
            right: 20px;
            min-width: auto;
        }
    }
    
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-dark);
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .table thead {
        background: var(--secondary);
        color: white;
    }
    
    .table thead th {
        font-weight: 600;
        padding: 12px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,53,69,0.3);
    }
    
    .form-control {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(220,53,69,0.1);
    }
</style>

<nav class="navbar navbar-dark bg-primary fixed-top " id="topNavBar" style="padding:0">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
      <div class="row align-items-center">
        <div class="col-md-1 float-left" style="display: flex;">
          <div class="logo">
            <img src="./../assets/defaults/pizza-logo.png" alt="<?php echo $_SESSION['setting_name']; ?> - Brand Logo">
          </div>
        </div>
        <div class="col-md-9 float-left">
          <h4 style="font-family: 'Dancing Script', cursive !important;" class="text-light"><a href="./../" class="text-reset"><b><?php echo $_SESSION['setting_name']; ?> - Admin Site</b></a></h4>
        </div>
        <div class="col-md-2 float-right">
          <a href="ajax.php?action=logout" class="text-light"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
        </div>
      </div>
    </div>
  </div>
  
</nav>