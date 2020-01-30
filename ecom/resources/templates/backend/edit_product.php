
<?php

edit_product();
if(isset($_GET['id']))
{
    $query=query("SELECT * FROM products WHERE product_id= " . escape($_GET['id']) . " ");
    confirm($query);

    while($row=fetch_array($query))
    {
        $titlle             =escape($row['titlle']);
        $category_id        =escape($row['category_id']);
        $price              =escape($row['price']);
        $product_quantity   =escape($row['product_quantity']);
        $description        =escape($row['description']);
        $short_description  =escape($row['short_description']);
        $image              =escape($row['image']); 
    }
}

?>




<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product
   </h1>

   <form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control" value="<?=$titlle; ?>" >
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?=$description; ?></textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" name="product_price" class="form-control" size="60" value="<?=$price; ?>" >
      </div>
    </div>




    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="update">
    </div>


     <!-- Product Categories-->

    <div class="form-group">
         <label for="product-title">Product Category</label>
          <hr>
        <select name="product_category" id="" class="form-control">
            <option value="<?=$category_id?>"><?=show_product_category_title($category_id)?></option>
            <?php show_categories_add_product(); ?>
           
        </select>


</div>





    <!-- Product Brands-->


    <div class="form-group">
      <label for="product-title">Product Quantity</label>
         <input type="number" class="form-control" name="product_quantity" value="<?=$product_quantity; ?>" >
         </select>
    </div>


<!-- Product Tags -->


    <div class="form-group">
          <label for="product-title">Short Description</label>
          <textarea name="short_description" id=""  class="form-control"><?=$short_description; ?></textarea>
          <hr>
        
    </div>

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file"><br>
        <img src="<?=$image; ?>">

      
    </div>



</aside><!--SIDEBAR-->


    
</form>



                



            </div>
            <!-- /.container-fluid -->

       
