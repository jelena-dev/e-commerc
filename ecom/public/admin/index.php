<?php require_once('../../resources/config.php'); ?>
<?php require_once(TEMPLATE_BACKEND . DS . 'header.php'); ?>

<?php
if(!isset($_SESSION['username']))
{
    redirect("../../public");
}

?>
        <div id="page-wrapper">

            <div class="container-fluid">

               

               <?php
               if($_SERVER['REQUEST_URI']=="/ecom/public/admin/" || $_SERVER['REQUEST_URI']=="/ecom/public/admin/index.php")
               {
                require_once(TEMPLATE_BACKEND .DS.  'admin_content.php');
               }
               if(isset($_GET['orders']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'orders.php');
               }

               if(isset($_GET['products']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'products.php');
               }

               if(isset($_GET['add_product']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'add_product.php');
               }

               if(isset($_GET['categories']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'categories.php');
               }

               if(isset($_GET['users']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'users.php');
               }
               if(isset($_GET['add_user']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'add_user.php');
               }
               if(isset($_GET['edit_user']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'edit_user.php');
               }
               if(isset($_GET['reports']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'reports.php');
               }
               if(isset($_GET['edit_product']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'edit_product.php');
               }

               if(isset($_GET['slides']))
               {
                require_once(TEMPLATE_BACKEND .DS. 'slides.php');
               }

               ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php require_once(TEMPLATE_BACKEND . DS . 'footer.php'); ?>
