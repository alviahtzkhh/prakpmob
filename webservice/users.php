<?php
//koneksi ke database employee
require_once "koneksi.php";
//query ke table employee
$sql = "select * from users";
$result = mysqli_query($con, $sql) or die("Error in Selecting " . mysqli_error($con));
//pembuatan array
$emparray = array();
while($row =mysqli_fetch_assoc($result)){
    $emparray[] = $row;
}
//pembuatan json
echo json_encode($emparray);
//tutup koneksi
mysqli_close($con);
?>