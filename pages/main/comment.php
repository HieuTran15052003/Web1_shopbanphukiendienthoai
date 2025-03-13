<div class="comment-h3"><h3>Gửi phản hồi của khách hàng</h3></div>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="POST" autocomplete="off" action="processing/form_contact.php">
            <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" id="name" class="form-control" required name="name">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" class="form-control" required name="phone">
            </div>
            <div class="form-group">
                <label for="email">Email liên hệ</label>
                <input type="text" id="email" class="form-control" required name="email">
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea class="form-control" id="note" rows="5" required name="note"></textarea>
            </div>
            <div class="form-group"> 
                <button type="submit" class="btn btn-success" name="guilienhe">Gửi phản hồi</button>
            </div>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>