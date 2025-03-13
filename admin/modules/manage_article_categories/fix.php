<?php  
include('config/config.php');  

try {  
    // Kiểm tra vào đầu vào  
    if (!isset($_GET['idbaiviet']) || !is_numeric($_GET['idbaiviet'])) {  
        throw new Exception("ID không hợp lệ");  
    }  
    $id = (int)$_GET['idbaiviet'];  
    
    // Câu truy vấn SQL  
    $sql_sua_danhmucbv = "SELECT * FROM article_directory WHERE id_baiviet = :idbaiviet LIMIT 1";  
    
    // Chuẩn bị và thực thi  
    $stmt = $conn->prepare($sql_sua_danhmucbv);  
    $stmt->bindParam(':idbaiviet', $id, PDO::PARAM_INT);  
    $stmt->execute();  
    
    // Lấy dữ liệu  
    $query_sua_danhmucbv = $stmt->fetch(PDO::FETCH_ASSOC);  
    
    if (!$query_sua_danhmucbv) {  
        throw new Exception("Không tìm thấy danh mục");  
    }  
    
} catch (Exception $e) {  
    echo "Lỗi: " . $e->getMessage();  
    exit();  
}  
?>  

<div class="edit-form">
    <h2>Sửa danh mục bài viết</h2>

    <form method="POST" action="modules/manage_article_categories/handle.php?idbaiviet=<?php echo htmlspecialchars($_GET['idbaiviet']); ?>">
        <div class="form-responsive">
            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td>Tên danh mục bài viết</td>
                    <td>
                        <input type="text" name="tendanhmucbaiviet" size="30"
                               value="<?php echo htmlspecialchars($query_sua_danhmucbv['tendanhmuc_baiviet']); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <div>Vui lòng nhập đầy đủ trước khi sửa danh mục bài viết</div>
                    </td>
                    <td>
                        <input type="submit" name="suadanhmucbaiviet" value="Cập nhật danh mục bài viết">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
