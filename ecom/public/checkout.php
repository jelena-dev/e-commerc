<?php require_once('../resources/config.php'); ?>
<?php require_once(TEMPLATE_FRONTEND . DS . 'header.php'); ?>


    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">

<h4 class="text-center bg-danger"><?php display_message(); ?></h4>
      <h1>Checkout</h1>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="business" value="sb-q8ibb607793@business.example.com"><!--mejl sa paypala-->
  <input type="hidden" name="currency_code" value="US">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <?php cart(); ?>
            
        </tbody>
    </table>
   <?php echo show_paypal(); ?>
</form>
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"><?php 
if(!isset($_SESSION['total_quantity']))
{
    $_SESSION['total_quantity']=0; 
    echo $_SESSION['total_quantity'];
    
}
echo $_SESSION['total_quantity']; 
?>
</span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">&#36;<?php 
if(!isset($_SESSION['total_price']))
{
    $_SESSION['total_price']=0; 
    echo $_SESSION['total_price'];
    
}
echo $_SESSION['total_price'];
 ?>
</span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->

 <?php require_once(TEMPLATE_FRONTEND . DS . 'footer.php'); ?>