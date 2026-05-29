<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('/assets/img/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Hati-hati dengan overflow hidden, pastikan memang dibutuhkan */
            overflow: hidden;
        }
         .alert-danger {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 15px 20px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        width: 80%;
        max-width: 400px;
        text-align: center;
        animation: fadeIn 0.3s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; top: 0; }
        to { opacity: 1; top: 20px; }
    }
        .text-danger {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }
    input:invalid {
        border-color: #dc3545;
    }
    input:focus:invalid {
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
    }
    </style>
</head>
<body >

    <div class="container ">
        
      
                <?= $contents; ?>
    </div>
    <script>
    $(document).ready(function() {
        // Hilangkan alert setelah 5 detik
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 5000);
        
        // Fokus ke field yang error
        <?php if (form_error('username')): ?>
            $('input[name="username"]').focus();
        <?php elseif (form_error('password')): ?>
            $('input[name="password"]').focus();
        <?php endif; ?>
    });
</script>

<script>
    // Hilangkan alert setelah 5 detik
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-danger');
        alerts.forEach(alert => {
            alert.style.animation = 'fadeOut 0.3s';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
</script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

</body>

</html>