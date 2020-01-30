<?php
$uploads="uploads";
function set_message($msg)
{
    if(!empty($msg))
    {
        $_SESSION['message']=$msg;
    }
    else
    {
        $msg="";
    }
}


function display_message()
{
    if(isset($_SESSION['message']))
    {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
function redirect($location)
{
    header("Location: $location");
}


function query($sql)
{
    global $connection;
    return mysqli_query($connection,$sql);
}

function confirm($result)
{
    global $connection;
    if(!$result)
    {
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}
function fetch_array($result)
{
    return mysqli_fetch_array($result);
}

function last_id()
{
    global $connection;
    return mysqli_insert_id($connection);
}

//get products

function get_products()//treba da se slike prikazuju preko F-je $image=display_image($row['image']);, a u src=../resources/$image
{
    $query= query("SELECT* FROM products");
    confirm($query);
    while($row=fetch_array($query))
    {
        $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?product_id={$row['product_id']}"><img src="{$row['image']}" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['price']}</h4>
                    <h4><a href="item.php?product_id={$row['product_id']}">{$row['titlle']}</a>
                    </h4>
                    <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                    <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
                </div>
                
            </div>
        </div>
DELIMETER;
        echo $product;
    }
}

/* function get_categories()
{
    
    $sql="SELECT * FROM categories";
    $result= query($sql);
        

    while($row=fetch_array($result))
    {
        $categories_link= <<<DELIMETER
        <a href='category.php?id={$row['id']}' class='list-group-item'>{$row['cat_title']}
DELIMETER;

    echo $categories_link; 
    }
    
                    
}
*/


function get_product()
{
    $query= query("SELECT* FROM products WHERE category_id=" .escape($_GET['id']). " ");
    confirm($query);
    while($row=fetch_array($query))
    {
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="{$row['image']}" alt="">
            <div class="caption">
                <h3>{$row['titlle']}</h3>
                <p>{$row['short_description']}</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $product;
    }
}

function get_product_in_shop()
{
    $query= query("SELECT* FROM products");
    confirm($query);
    while($row=fetch_array($query))
    {
        $product = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <img src="{$row['image']}" alt="">
            <div class="caption">
                <h3>{$row['titlle']}</h3>
                <p>{$row['short_description']}</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="cart.php?product_id={$row['product_id']}" class="btn btn-default">More Info</a>
                </p>
            </div>
        </div>
    </div>
DELIMETER;
        echo $product;
    }
}

function login_user()
{
    if(isset($_POST['submit']))
    {
        $username=escape($_POST['username']);
        $password=escape($_POST['password']);

    $query=query("SELECT * FROM users WHERE username='{$username}' AND password='{$password}'");
    confirm($query);
        if(mysqli_num_rows($query)==0)
        {
            set_message("Smth is wrong");
            redirect('login.php');
        }
        else
        {
            $_SESSION['username']=$username;
            set_message("Welcome to admin {$username}");
            redirect('admin');
        }
    }
}

function send_message()
{
    if(isset($_POST['submit']))
    {
        $to="some89@hotmail.com";
        $from_name=escape($_POST['name']);
        $email=escape($_POST['email']);
        $subject=escape($_POST['subject']);
        $message=escape($_POST['message']);

        $headers="From: {$from_name}{$email}";

        $result= mail($to,$subject,$message,$headers);

        if(!$result)
        {
            set_message("We could not sent your message");
            redirect("contact.php");
        }
        else
        {
            set_message("Your message has been sent");
            redirect("contact.php");
        }
    }

}
/********************BACK END FUNCTIONs******************/


function display_orders()
{
    $query=query("SELECT * FROM orders");
    confirm($query);
    while($row=fetch_array($query))
    {
        $orders=<<<DELIMETER
        <tr>
        <td>{$row['order_id']}</td>
        <td>{$row['order_amount']}</td>
        <td>{$row['order_transaction']}</td>
        <td>{$row['order_currency']}</td>
       <td>{$row['order_status']}</td>
       <td><a class="btn btn-danger href="../../resources/templates/backend/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;
        return $orders;

    }
}

/**************************************Categories in admin **************************************/

function show_categories_in_admin()
{
    $query=query("SELECT * FROM categories");
    confirm($query);
    while($row=fetch_array($query))
    {
        $category=<<<DELIMETER
        <tr>
        <td>{$row['id']}</td>
        <td>{$row['cat_title']}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_category.php?id={$row['id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;
    echo $category;
    }
}

function add_category()
{
    if(isset($_POST['add_category']))
    {
        $cat_title=escape($_POST['category_title']);

        if(empty($cat_title)|| $cat_title == " ")
        {
            echo "This filed cannot be empty";
        }
        else
        {
        $query=query("INSERT INTO categories(cat_title) VALUES('{$cat_title}')");
        confirm($query);
        set_message('You added a category');
        }

        
    }
}

/******************admin users *******************/

function display_users_in_admin()
{
    $query=query("SELECT * FROM users");
    confirm($query);
    while($row=fetch_array($query))
    {
        $user=<<<DELIMETER
        <tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td><a class="btn btn-success" href="../../resources/templates/backend/add_user.php?id={$row['id']}"><span class="glyphicon glyphicon-plus"></span></a></td>
        <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_user.php?id={$row['id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;
    echo $user;
    }
}

function add_user()
{
    if(isset($_POST['add_user']))
    {
        $username=escape($_POST['username']);
        $password=escape($_POST['password']);
        /*
        $user_photo=escape($_FILES['file']['name']);
        $photo_temp=escape($_FILES['file']['tmp_name']);
        move_uploaded_file($photo_temp, UPLOAD_DIRECTORY. DS.$user_photo)
        */

        $query=query("INSERT INTO users(username,password)
        VALUES('{$username}','{$password}')");
        confirm($query);
        set_message("USER CREATED");
        redirect("index.php?users");
    }
}

/******************Reports ***************/

function display_reports()
{
    $query=query("SELECT * FROM reports");
    confirm($query);
    while($row=fetch_array($query))
    {
        $report=<<<DELIMETER
        <tr>
        <td>{$row['report_id']}</td>
        <td>{$row['product_id']}</td>
        <td>{$row['order_id']}</td>
        <td>{$row['product_title']}</td>
        <td>{$row['product_price']}</td>
        <td>{$row['product_quantity']}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;
    echo $report;
    }
}

/********************admin products ************************/

function display_products()
{
    $query=query("SELECT products.*,categories.cat_title 
    FROM products
    INNER JOIN categories
    ON products.category_id=categories.id");
    confirm($query);
    while($row=fetch_array($query))
    {
        $image=display_image($row['image']);
        $product=<<<DELIMETER
        <tr>
        <td>{$row['product_id']}</td>
        <td><a href="index.php?edit_product&id={$row['product_id']}"><img src="../../resources/$image"></a></td>
        <td>{$row['titlle']}</td>
        <td>{$row['cat_title']}</td>
        <td>{$row['price']}</td>
        <td>{$row['product_quantity']}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/backend/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        
    </tr>
DELIMETER;
    echo $product;
    }
}

/**
 * Adding products in Admin
 */

 function display_image($picture)
 {
     global $uploads;
     return $uploads . DS . $picture;
 }

 function add_product()
 {
     if(isset($_POST['publish']))
     {
        $titlle             =escape($_POST['product_title']);
        $categori_id        =escape($_POST['product_category"']);
        $price              =escape($_POST['product_price']);
        $product_quantity   =escape($_POST['product_quantity']);
        $description        =escape($_POST['product_description']);
        $short_description  =escape($_POST['short_description']);
        $image              =escape($_FILES['file']['name']);
        $image_temp_locat   =escape($_FILES['file']['tmp_name']);

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);



        $query=query("INSERT INTO products(titlle, category_id,price, product_quantity, description, short_description,image)
        VALUES('{$titlle}','{$categori_id}','{$price}','{$product_quantity}','{$description}','{$short_description}','{$image}')");

        confirm($query);
        $last_id=last_id();

        set_message("New Product with ID {$last_id} was Added");
        redirect('index.php?products');
        
     }
     
     
 }
function show_categories_add_product()
{
    $sql="SELECT * FROM categories";
     $result= query($sql);
     confirm($result);
     

          while($row=fetch_array($result)) 
          {
             $categories_options= <<<DELIMETER
             <option name="categori_id" value="{$row['id']}">{$row['cat_title']}</option>
DELIMETER;
echo $categories_options;
          }
         
}

function edit_product()
 {
     if(isset($_POST['update']))
     {
        $titlle             =escape($_POST['product_title']);
        $category_id        =escape($_POST['product_category']);
        $price              =escape($_POST['product_price']);
        $product_quantity   =escape($_POST['product_quantity']);
        $description        =escape($_POST['product_description']);
        $short_description  =escape($_POST['short_description']);
        $image              =escape($_FILES['file']['name']);
        $image_temp_locat   =escape($_FILES['file']['tmp_name']);

        if(empty($image))
        {
            $get_pic=query("SELECT image FROM products WHERE product_id=".escape($_GET['id']). " ");
            cofirm($get_pic);

            while($pic=fetch_array($get_pic))
            {
                $image=$pic['image'];
            }
        }

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);



        $query="UPDATE products SET ";
        $query.="titlle             ='{$titlle}'                , ";
        $query.="category_id        ='{$category_id}'           , ";
        $query.="price              ='{$price}'                 , ";
        $query.="product_quantity   ='{$product_quantity}'      , ";
        $query.="description        ='{$description}'           , ";
        $query.="short_description  ='{$short_description}'     , ";
        $query.="image              ='{$image}'                   ";
        $query.="WHERE product_id=" . escape($_GET['id']);

        $send_update_query= query($query);
        confirm($send_update_query);
    
        set_message("Product has been Updated");
        redirect('index.php?products');
        
     }
     
     
 }
 function show_product_category_title($category_id){


    $category_query = query("SELECT * FROM categories WHERE id = '{$category_id}' ");
    confirm($category_query);
    
    while($category_row = fetch_array($category_query)) {
    
    return $category_row['cat_title'];
    
    }
    
    
    
    }


    /******************************* Slides Function***************************/

    
    function add_slides()
    {

    }

    function get_current_slides()
    {

    }


    function get_active()
    {
        
    }


    function get_slides()
    {
        $query=query("SELECT * FROM slides");
        confirm($query);

        while($row=fetch_array($query))
        {
            $slides=<<<DELIMETER
            <div class="item">
              <img class="slide-image" src="../resources/uploads/{row['slide_image']}" alt="">
           </div>
DELIMETER;
            echo $slides;
        }

    }

    function get_slides_thumbnails()
    {

    }
?>