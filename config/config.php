<?php 
define("KEY_TOKEN","APR.wqc-354*");
define("MONEDA","$");

session_start();
$nun_cart = 0;
if (isset($_SESSION['carrito']['producto'])) {
            $nun_cart= count($_SESSION['carrito']['producto']);
        }
?>