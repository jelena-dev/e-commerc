<?php
require_once("../../config.php");

if(isset($_GET['id']))
{
    $query=query("DELETE FROM users WHERE id=" .escape($_GET['id']). " ");
    confirm($query);
    SET_MESSAGE("User Deleted");
    redirect("../../../public/admin/index.php?users");

}
else
{
    redirect("../../../public/admin/index.php?users");
}