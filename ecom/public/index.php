<?php require_once('../resources/config.php'); ?>
<?php require_once(TEMPLATE_FRONTEND . DS . 'header.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

          <?php require_once(TEMPLATE_FRONTEND . DS . 'side_nav.php'); ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        
                        <?php require_once(TEMPLATE_FRONTEND . DS . 'slider.php'); ?>
                </div>

                <div class="row">
                    

               <?php get_products();?>

                    
                   

                </div><!--ROW ends here-->

            </div>

        </div>

    </div>
    <!-- /.container -->
    <?php require_once(TEMPLATE_FRONTEND . DS . 'footer.php'); ?>

   