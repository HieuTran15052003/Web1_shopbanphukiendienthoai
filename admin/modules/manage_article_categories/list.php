<?php  
// Giả sử bạn đã bao gồm tệp config.php với kết nối PDO ở đó  
include('config/config.php');  

try {  
    // Câu truy vấn SQL   
    // Đảm bảo rằng bạn lấy thông tin cần thiết từ bảng article_directory  
    $sql_lietke_danhmucbv = "SELECT * FROM article_directory ORDER BY id_baiviet DESC";  

    // Chuẩn bị câu truy vấn  
    $stmt = $conn->prepare($sql_lietke_danhmucbv);  
    
    // Thực thi câu truy vấn  
    $stmt->execute();  

    // Lấy tất cả kết quả  
    $query_lietke_danhmucbv = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {  
    echo "Lỗi: " . $e->getMessage(); // Hiển thị lỗi nếu có  
}  
?>  
<div class="category-container">
    <div class="header-actions mb-3">
        <h2 class="d-inline-block">Liệt kê danh mục bài viết</h2>
        <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addArticleCategoryModal">
            <span class="icon-plus"><i class="fas fa-plus"></i></span>
            <span class="button-text">Thêm danh mục bài viết</span>
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục bài viết</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <?php  
            // Đếm số lượng danh mục  
            $i = 0;  
            foreach ($query_lietke_danhmucbv as $row) {  
                $i++;  
            ?>  
                <tr>  
                    <td><?php echo htmlspecialchars($row['id_baiviet']); ?></td> <!-- Hiển thị ID của danh mục bài viết -->  
                    <td><?php echo htmlspecialchars($row['tendanhmuc_baiviet']); ?></td> <!-- Đảm bảo rằng cột tên danh mục chính xác -->  
                    <td class="action-buttons">
                        <a href="?action=manage_article_categories&query=fix&idbaiviet=<?php echo htmlspecialchars($row['id_baiviet']); ?>" 
                            class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="modules/manage_article_categories/handle.php?query=xoa&idbaiviet=<?php echo htmlspecialchars($row['id_baiviet']); ?>" 
                            class="btn btn-sm btn-danger" 
                            onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    </td>  
                </tr>  
            <?php  
            }  
            ?>  
        </table>
    </div>
</div>
<div class="modal fade" id="addArticleCategoryModal" tabindex="-1" aria-labelledby="addArticleCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleCategoryModalLabel">Thêm danh mục bài viết mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modules/manage_article_categories/handle.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tendanhmucbaiviet" class="form-label">Tên danh mục bài viết</label>
                        <input type="text" class="form-control" id="tendanhmucbaiviet" name="tendanhmucbaiviet"  required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button name="themdanhmucbaiviet" type="submit" class="btn btn-primary">Thêm danh mục</button>
                </div>
            </form>
        </div>
    </div>
</div>  