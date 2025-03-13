<p>Quản lý thông tin website</p>
<?php     
    $sql_lh = "SELECT * FROM contact WHERE id=1";
    $query_lh = mysqli_query($mysqli,$sql_lh);      
?>
<?php
while($row = mysqli_fetch_array($query_lh)) {
?>
<form method="POST" action="modules/information_web/handle.php?id=<?php echo $row['id'] ?>" enctype="multipart/form-data">
    <div class="form-responsive">
        <table border="1" width="100%" style="border-collapse:collapse;">
            <tr>
                <td>Thông tin liên hệ</td>
                <td>
                    <textarea rows="10" name="thongtinlienhe" id="thongtinlienhe" style="resize:none"><?php echo $row['thongtinlienhe'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="2">
                    <input class="fix_more" type="submit" name="submitlienhe" value="Cập nhật">
                </td>
            </tr>
        </table>
    </div>
</form>
<?php 
}
?> 