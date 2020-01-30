<?php
require_once("../../config.php");

if(isset($_GET['id']))
{
    $query=query("DELETE FROM categories WHERE id=" .escape($_GET['id']). " ");
    confirm($query);
    SET_MESSAGE("Category Deleted");
    redirect("../../../public/admin/index.php?categories");

}
else
{
    redirect("../../../public/admin/index.php?categories");
}