<?php
$host = "localhost";
$dbname = "login_system";
$username = "root";
$password = "";

// nwhf fkcv hcnx slby

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
?>
<?php
$mysqli = new mysqli("localhost","root","","login_system");

// Check connection
if ($mysqli->connect_errno) {
  echo "Kết nối lỗi" . $mysqli->connect_error;
  exit();
} 
?>