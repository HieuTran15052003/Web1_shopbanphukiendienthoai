<?php
include('../../config/config.php');
// Lấy và xử lý dữ liệu từ form
$tenbaiviet = mysqli_real_escape_string($mysqli, $_POST['tenbaiviet']);
$tomtat = mysqli_real_escape_string($mysqli, $_POST['tomtat']);
$noidung = mysqli_real_escape_string($mysqli, $_POST['noidung']);
$tinhtrang = intval($_POST['tinhtrang']);
$danhmuc = intval($_POST['danhmuc']);

// Xử lý upload file
$hinhanh = $_FILES['hinhanh']['name'];
$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
$file_ext = strtolower(pathinfo($hinhanh, PATHINFO_EXTENSION));
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

if (isset($_POST['thembaiviet'])) {
    // Kiểm tra loại file ảnh
    if (in_array($file_ext, $allowed_ext)) {
        // Đổi tên file để tránh trùng
        $target_file = uniqid() . '_' . $hinhanh;  // Lưu file với tên duy nhất
        $target_path = 'uploads/' . $target_file;  // Đường dẫn thư mục uploads

        // Tiến hành upload file vào thư mục uploads
        if (move_uploaded_file($hinhanh_tmp, $target_path)) {
            // Câu truy vấn SQL sử dụng prepared statements
            $sql_them = "INSERT INTO article (tenbaiviet, hinhanh, tomtat, noidung, tinhtrang, id_danhmuc) 
                         VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql_them);
            $stmt->bind_param("ssssii", $tenbaiviet, $target_file, $tomtat, $noidung, $tinhtrang, $danhmuc);
            
            if ($stmt->execute()) {
                // Điều hướng khi thêm bài viết thành công
                header('Location: ../../indexad.php?action=article_management&query=more');
                exit;
            } else {
                echo "Lỗi: Không thể thêm bài viết.";
            }
        } else {
            echo "Lỗi: Không thể upload hình ảnh.";
        }
    } else {
        echo "Lỗi: Chỉ cho phép các định dạng ảnh JPG, JPEG, PNG, GIF.";
    }
}elseif (isset($_POST['suabaiviet'])) {    
    if (!empty($_FILES['hinhanh']['name'])) {
        move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);

        $sql_update = "UPDATE article SET 
            tenbaiviet='".$tenbaiviet."',
            hinhanh='".$hinhanh."',
            tomtat='".$tomtat."',
            noidung='".$noidung."',
            tinhtrang='".$tinhtrang."',
            id_danhmuc='".$danhmuc."'
            WHERE id = '$_GET[idbaiviet]'
        ";
        //Xóa hình ảnh cũ
        $sql = "SELECT * FROM article WHERE id = '$_GET[idbaiviet]' LIMIT 1";
        $query = mysqli_query($mysqli,$sql);
        while($row = mysqli_fetch_array($query)) {
            unlink('uploads/'.$row['hinhanh']);
        }
    }else{
        $sql_update = "UPDATE article SET 
            tenbaiviet='".$tenbaiviet."',
            tomtat='".$tomtat."',
            noidung='".$noidung."',
            tinhtrang='".$tinhtrang."',
            id_danhmuc='".$danhmuc."'
            WHERE id = '$_GET[idbaiviet]'
        ";
    }
    mysqli_query($mysqli,$sql_update);
    header('Location: ../../indexad.php?action=article_management&query=more');    
} else {  
    if (isset($_GET['idbaiviet'])) {
        $id = intval($_GET['idbaiviet']); // Lọc dữ liệu đầu vào
        $sql = "SELECT * FROM article WHERE id = ? LIMIT 1";  
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id); // Sử dụng prepared statement
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            if (file_exists('uploads/' . $row['hinhanh'])) {
                unlink('uploads/' . $row['hinhanh']); // Kiểm tra trước khi xóa file
            }
        }
    
        // Xóa bài viết
        $sql_xoa = "DELETE FROM article WHERE id = ?";
        $stmt_xoa = $mysqli->prepare($sql_xoa);
        $stmt_xoa->bind_param("i", $id);
        $stmt_xoa->execute();
    
        // Điều hướng sau khi xóa
        header('Location: ../../indexad.php?action=article_management&query=more');  
        exit;
    } else {
        // Xử lý khi không có id được truyền
        echo "Không có bài viết để xóa.";
    }
}  
?>