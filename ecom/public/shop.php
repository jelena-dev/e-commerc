<?php require_once('../resources/config.php'); ?>
<?php require_once(TEMPLATE_FRONTEND . DS . 'header.php'); ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header>
            <h1>Shop</h1>

        </header>

        <hr>

        
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

        <?php get_product_in_shop(); ?>


        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php require_once(TEMPLATE_FRONTEND . DS . 'footer.php'); ?>