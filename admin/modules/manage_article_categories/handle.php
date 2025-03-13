<?php
include('../../config/config.php');  
// Lấy dữ liệu từ form  
$tendanhmucbaiviet = $_POST['tendanhmucbaiviet'];  

if (isset($_POST['themdanhmucbaiviet'])) {  
    // Lấy dữ liệu từ biểu mẫu và loại bỏ khoảng trắng   
    $tendanhmucbaiviet = trim($_POST['tendanhmucbaiviet']);  

    // Kiểm tra dữ liệu đầu vào  
    if (!empty($tendanhmucbaiviet)) {  
        try {  
            // Câu truy vấn SQL  
            $sql_them = "INSERT INTO article_directory(tendanhmuc_baiviet) VALUES (:tendanhmucbaiviet)";  

            // Chuẩn bị câu truy vấn  
            $stmt = $conn->prepare($sql_them);  
            $stmt->bindParam(':tendanhmucbaiviet', $tendanhmucbaiviet);  
            $stmt->execute();
            header('Location: ../../indexad.php?action=manage_article_categories&query=more');  
            exit;
        } catch (PDOException $e) {  
            echo "Lỗi: " . $e->getMessage();  
        }  
    } 
}elseif (isset($_POST['suadanhmucbaiviet'])) {  
    // Khởi tạo các biến  
    $tendanhmucbaiviet = isset($_POST['tendanhmucbaiviet']) ? trim($_POST['tendanhmucbaiviet']) : '';    

    // Kiểm tra xem các trường cần thiết có được điền đầy đủ hay không  
    if (!empty($tendanhmucbaiviet) && isset($_GET['idbaiviet']) && is_numeric($_GET['idbaiviet'])) {  
        try {  
            // Chuẩn bị câu lệnh cập nhật SQL với các ký tự thay thế  
            $sql_update = "UPDATE article_directory SET tendanhmuc_baiviet = :tendanhmucbaiviet WHERE id_baiviet = :idbaiviet";  
            $stmt = $conn->prepare($sql_update);  
            $stmt->bindParam(':tendanhmucbaiviet', $tendanhmucbaiviet);  
            $stmt->bindParam(':idbaiviet', $_GET['idbaiviet'], PDO::PARAM_INT);  // Liên kết ID đúng cách  
            $stmt->execute();   
            // Chuyển hướng sau khi đã xử lý  
            header('Location: ../../indexad.php?action=manage_article_categories&query=more');  
            exit;  
        } catch (PDOException $e) {  
            // Hiển thị thông báo lỗi nếu có ngoại lệ  
            echo "Lỗi: " . $e->getMessage();  
        }  
    }
}elseif (isset($_GET['query']) && $_GET['query'] == 'xoa') {  
    // Đảm bảo có ID khi xóa  
    if (isset($_GET['idbaiviet']) && is_numeric($_GET['idbaiviet'])) {  
        $id = $_GET['idbaiviet']; // Lấy ID đúng từ GET  

        try {  
            // Câu truy vấn SQL để xóa  
            $sql_xoa = "DELETE FROM article_directory WHERE id_baiviet = :id";  
            $stmt = $conn->prepare($sql_xoa);  
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);  
            $stmt->execute(); 
            header('Location: ../../indexad.php?action=manage_article_categories&query=more');  
            exit;  
        } catch (PDOException $e) {  
            // Thông báo lỗi  
            echo "Lỗi: " . $e->getMessage();  
        }  
    }  
}
?>