<?php
include('../../config/config.php');
// Lấy và xử lý dữ liệu từ form
$thongtinlienhe = $_POST['thongtinlienhe'];
$id = $_GET['id'];
if (isset($_POST['submitlienhe'])) {    
    $sql_update = "UPDATE contact SET thongtinlienhe='".$thongtinlienhe."' WHERE id = '$id' ";
    mysqli_query($mysqli,$sql_update);
    header('Location: ../../indexad.php?action=management_web&query=update');    
}
?>