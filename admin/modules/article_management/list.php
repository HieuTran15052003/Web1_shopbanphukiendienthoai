<?php  
include('config/config.php');  

// Câu truy vấn SQL tối ưu
$sql_lietke_bv = "
    SELECT article.id, article.tenbaiviet, article.hinhanh, article.tomtat, article.noidung, 
           article.tinhtrang, article_directory.tendanhmuc_baiviet 
    FROM article 
    JOIN article_directory ON article.id_danhmuc = article_directory.id_baiviet 
    ORDER BY article.id DESC
";
$query_lietke_bv = mysqli_query($mysqli, $sql_lietke_bv);
?>  
<div class="category-container">
    <div class="header-actions mb-3">
        <h2 class="d-inline-block">Liệt kê bài viết</h2>
        <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addArticleModal">
            <span class="icon-plus"><i class="fas fa-plus"></i></span>
            <span class="button-text">Thêm bài viết</span>
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark"> 
                <tr>
                    <th>ID</th>
                    <th>Tên bài viết</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Tóm tắt</th>
                    <th>Nội dung</th>
                    <th>Tình trạng</th>
                    <th>Quản lý</th>
                </tr>
            </thead>  

            <?php  
            if (mysqli_num_rows($query_lietke_bv) > 0) {  
                $i = 0;  
                while ($row = mysqli_fetch_assoc($query_lietke_bv)) {  
                    $i++;
            ?>  
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($row['tenbaiviet']); ?></td>
                <td>
                <?php 
                // Kiểm tra xem hình ảnh có tồn tại trong thư mục uploads không
                $imagePath = 'modules/article_management/uploads/' . $row['hinhanh'];
                if (file_exists($imagePath)) { 
                ?>
                    <img src="<?php echo $imagePath; ?>" width="150px" alt="Hình ảnh bài viết">
                <?php } else { ?>
                    <img src="modules/article_management/uploads/default.jpg" width="150px" alt="Hình ảnh không có sẵn">
                <?php } ?>
                </td>
                <td><?php echo $row['tendanhmuc_baiviet']; ?></td>
                <td><?php echo $row['tomtat']; ?></td>
                <td><?php echo $row['noidung']; ?></td>
                <td><?php echo $row['tinhtrang'] == 1 ? 'Kích hoạt' : 'Ẩn'; ?></td>
                <td class="action-buttons">
                    <a class="btn btn-sm btn-danger"
                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" 
                    href="modules/article_management/handle.php?idbaiviet=<?php echo $row['id']; ?>"><i class="fas fa-trash"></i>Xóa</a>
                    <a class="btn btn-sm btn-warning" 
                    href="?action=article_management&query=fix&idbaiviet=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i>Sửa</a>
                </td>
            </tr>  
            <?php  
                }  
            } else {  
                echo "<tr><td colspan='8'>Không có bài viết nào.</td></tr>";  
            }  
            ?>  
        </table>
    </div>
</div>
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Thêm bài viết mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modules/article_management/handle.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Thông tin cơ bản -->
                    <div class="mb-3 row">
                        <label for="tenbaiviet" class="col-sm-3 col-form-label">Tên bài viết</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tenbaiviet" name="tenbaiviet" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="hinhanh" class="col-sm-3 col-form-label">Hình ảnh</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*" required>
                            <div id="preview" class="mt-2"></div>
                        </div>
                    </div>
                    <!-- Mô tả sản phẩm -->
                    <div class="mb-3">
                        <label for="tomtat" class="form-label">Tóm tắt</label>
                        <textarea class="form-control" id="tomtat" name="tomtat" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="noidung" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="noidung" name="noidung" rows="5"></textarea>
                    </div>
                    <!-- Phân loại -->
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="danhmuc" class="form-label">Danh mục bài viết</label>
                            <select class="form-select" id="danhmuc" name="danhmuc" required>
                                <option value="">Chọn danh mục</option>
                                <?php
                                    $sql_danhmuc = "SELECT * FROM article_directory ORDER BY id_baiviet DESC";
                                    $result = $mysqli->query($sql_danhmuc);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row_danhmuc = $result->fetch_assoc()) {
                                ?>
                                            <option value="<?php echo htmlspecialchars($row_danhmuc['id_baiviet']); ?>">
                                                <?php echo htmlspecialchars($row_danhmuc['tendanhmuc_baiviet']); ?>
                                            </option>
                                <?php
                                        }
                                        $result->free();
                                    } else {
                                        echo "<option value=''>Không có danh mục nào</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="tinhtrang" class="form-label">Trạng thái</label>
                            <select class="form-select" id="tinhtrang" name="tinhtrang" required>
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Kích hoạt</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" name="thembaiviet" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
