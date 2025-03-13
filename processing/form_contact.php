<?php
include('../admin/config/config.php');
if (isset($_POST['guilienhe'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $note = $_POST['note'];
    $status = 1;
    // Chuẩn bị câu lệnh SQL để thêm dữ liệu
    $sql = "INSERT INTO contact_notice(email,username,phone,status_contact,note) 
            VALUES ('" . $email . "', '" . $name . "', '" . $phone . "', '" . $status . "', '" . $note . "')";
    $row = mysqli_query($mysqli, $sql);

    if ($row) {
        // Nếu thêm thành công, hiển thị thông báo và chuyển hướng
        echo '<script>alert("Thông tin đã được gửi đi, vui lòng chờ nha");</script>';
        echo '<script>window.location.href = "../index.php?management=contact";</script>';
        exit;
    } else {
        // Nếu lỗi, hiển thị thông báo lỗi
        echo '<script>alert("Có lỗi xảy ra khi gửi thông tin. Vui lòng thử lại.");</script>';
        echo '<script>window.history.back();</script>';
        exit;
    }
}
?>