<?php require_once('config.php'); ?>

<?php
if(isset($_GET['add'])) 
{
    $query= query("SELECT * FROM products WHERE product_id=" .escape($_GET['add']). " ");

    confirm($query);
    while($row=fetch_array($query))
    {
        if($row['product_quantity']>=$_SESSION['product_' . $_GET['add']])
        {
            $_SESSION['product_' . $_GET['add']]+=1;
            redirect("../public/checkout.php");
        }
        else
        {
            set_message("Sorry we have just " . $row['product_quantity']. " " . "available!" );
            redirect("../public/checkout.php");
        }
    }

}

if(isset($_GET['remove']))
{
    $_SESSION['product_' . $_GET['remove']]--;
    if($_SESSION['product_' . $_GET['remove']]<1)
    {
        unset($_SESSION['total_price']);
        unset($_SESSION['total_quantity']);
        redirect("../public/checkout.php");
    }
    else
    {
        redirect("../public/checkout.php");
    }
}

if(isset($_GET['delete']))
{
    $_SESSION['product_' . $_GET['delete']]='0';

    unset($_SESSION['total_price']);
    unset($_SESSION['total_quantity']);
    redirect("../public/checkout.php");
}

function cart()
{
    $total=0;
    $total_quantity=0;
    $item_name=1;
    $item_number=1;
    $amount=1;
    $quantity=1;
    

    /*
    foreach ($_SESSION as $name=>$value)

    za svaki product_1=20, product_1=name, 20 =value
    */

    foreach ($_SESSION as $name=>$value)
    {

        if($value > 0)//ako nista nismo dodali u kartu, nista ne prikazujemo
        {
            if(substr($name,0,8)=="product_")
            {

                //trazimo id sesije
            $length=strlen($name-8);
            $id=substr($name,8,$length);

            $query=query("SELECT * FROM products WHERE product_id=" .escape($id). " ");
            confirm($query);
            while($row=fetch_array($query))
            {
                $sub=$row['price']*$value;
                $total_quantity+=$value;
                $product=<<<DELIMETER
                <tr>
                        <td>{$row['titlle']}</td>
                        <td>{$row['price']}</td>
                        <td>{$value}</td>
                        <td>&#36;{$sub}</td>
                        <td>
                            <a class="btn btn-warning" href="../resources/cart.php?remove={$row['product_id']}"><span class="glyphicon glyphicon-minus"></span></a>   
                            <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>  
                            <a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a>
                         </td>
                      
                    </tr>
                        <input type="hidden" name="item_name_{$item_name}" value="{$row['titlle']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_{$amount}" value="{$row['price']}">
                        <input type="hidden" name="quantity_{$quantity}" value="{$value}">
DELIMETER;
        $item_name++;
        $item_number++;
        $amount++;
        $quantity++;
        echo $product;
        $total+=$sub;
            }
            $_SESSION['total_price']=$total;
            $_SESSION['total_quantity']=$total_quantity;
            }
     }


    }
        

}
function show_paypal()
{
    if(isset($_SESSION['total_quantity']) && ($_SESSION['total_quantity']>=1)) 
    {
        $paypal_button=<<<DELIMETER
        <input type="image" name="upload" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif">
DELIMETER;
return $paypal_button;
    }
}


function reports()//function process_transaction()
{
   if(isset($_GET['tx']))
    {

      $amount=$_GET['amt'];
      $currency=$_GET['cc'];
      $transaction=$_GET['tx'];
      $status=$_GET['st'];
      $total=0;
      $item_quantity=0;
   
    foreach ($_SESSION as $name=>$value)
    {

        if($value > 0)//ako nista nismo dodali u kartu, nista ne prikazujemo
        {
            if(substr($name,0,8)=="product_")
            {

                //trazimo id sesije
            $length=strlen($name-8);
            $id=substr($name,8,$length);

            $send_order=query("INSERT INTO orders(order_amount, order_transaction, order_currency, order_status)
            VALUES('{$amount}', '{$transaction}','{$currency}','{$status}')");
            $last_id=last_id();
            confirm($send_order);

            $query=query("SELECT * FROM products WHERE product_id=" .escape($id). " ");
            confirm($query);
            while($row=fetch_array($query))
            {
                $product_price=$row['price'];
                $product_title=$row['titlle'];
                $sub=$row['price']*$value;
                $item_quantity+=$value;
            }
            $insert_report=query("INSERT INTO reports(product_id, order_id,product_title, product_price, product_quantity)
            VALUES('{$id}', '{$last_id}', '{$product_title}', '{$product_price}', '{$value}')");
            confirm($insert_report);
            }
        }


    }
    session_destroy();     
 }
 else
{
    redirect('index.php');
}

}

   