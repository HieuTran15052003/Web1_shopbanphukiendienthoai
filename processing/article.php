<?php  
    // Giả sử $mysqli đã được thiết lập và kết nối thành công  
    $sql_bv = "SELECT * FROM article WHERE article.id='$_GET[id]' LIMIT 1";  
    $query_bv = mysqli_query($mysqli,$sql_bv);
    $query_bv_all = mysqli_query($mysqli,$sql_bv);
    $row_bv_title = mysqli_fetch_array($query_bv);
?>
<h3 class="article-name">Bài viết : <?php echo $row_bv_title['tenbaiviet'] ?></h3>
<div class="row">
    <?php  
    while ($row_bv = mysqli_fetch_array($query_bv_all)) {  
    ?> 
    <div class="article-noidung">
        <p><?php echo $row_bv['noidung']?></p>
    </div> 
    <?php  
    }
    ?>
</div>     