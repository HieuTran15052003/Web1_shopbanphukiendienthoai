<?php     
    $sql_sua_bv = "SELECT * FROM article WHERE id='" . $_GET['idbaiviet'] . "' LIMIT 1";
    $query_sua_bv = mysqli_query($mysqli,$sql_sua_bv);      
?>  
<p>Sửa bài viết</p> 
<?php
while($row = mysqli_fetch_array($query_sua_bv)) {
?>
    <form method="POST" action="modules/article_management/handle.php?idbaiviet=<?php echo $row['id'] ?>" enctype="multipart/form-data">  
        <div class="form-responsive">
            <table border="1">
                <tr>  
                    <td>Tên bài viết</td>  
                    <td><input type="text" name="tenbaiviet" size="145" maxlength="255" value="<?php echo $row['tenbaiviet'] ?>" required></td>  
                </tr> 
                <tr>  
                    <td>Hình ảnh</td>  
                    <td>  
                        <input type="file" name="hinhanh">  
                        <img src="modules/article_management/uploads/<?php echo $row['hinhanh'] ?>" width="150px" alt="Hình ảnh bài viết">  
                    </td>  
                </tr>  
                <tr>  
                    <td>Tóm tắt</td>  
                    <td><textarea rows="10" name="tomtat" style="resize:none"><?php echo $row['tomtat'] ?></textarea></td>  
                </tr>  
                <tr>  
                    <td>Nội dung</td>  
                    <td><textarea rows="10" name="noidung" style="resize:none"><?php echo $row['noidung'] ?></textarea></td>  
                </tr>  
                <tr>  
                    <td>Danh mục bài viết</td>  
                    <td>  
                        <select name="danhmuc" required>  
                            <?php  
                                $sql_danhmuc = "SELECT * FROM article_directory ORDER BY id_baiviet DESC";  
                                $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                                while($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                                    if($row_danhmuc['id_baiviet'] == $row['id_danhmuc']) {
                            ?>   
                            <option selected value="<?php echo $row_danhmuc['id_baiviet']?>"><?php echo $row_danhmuc['tendanhmuc_baiviet'] ?></option>  
                            <?php  
                                }else{
                            ?>
                            <option value="<?php echo $row_danhmuc['id_baiviet']?>"><?php echo $row_danhmuc['tendanhmuc_baiviet'] ?></option>
                            <?php  
                                }
                            }    
                            ?>    
                        </select>  
                    </td>   
                </tr>  
                <tr>  
                    <td>Tình trạng</td>  
                    <td>  
                        <select name="tinhtrang" required>
                            <?php 
                            if ($row['tinhtrang'] == 1) {
                            ?> 
                            <option value="1" selected>Kích hoạt</option>  
                            <option value="0" >Ẩn</option>
                            <?php 
                            }else{
                            ?>
                            <option value="1" >Kích hoạt</option>  
                            <option value="0" selected>Ẩn</option> 
                            <?php 
                            }
                            ?>   
                        </select>  
                    </td>  
                </tr>  
                <tr>  
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" name="suabaiviet" value="Cập nhật bài viết">
                    </td>  
                </tr> 
            </table>  
        </div>
    </form>
<?php 
}
?> 
