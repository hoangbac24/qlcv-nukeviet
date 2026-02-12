<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Danh mục</label>
        <input type="text" name="cat_title" class="form-control" placeholder="Nhập tên danh mục (nếu chưa có sẽ tự tạo mới)" required>
    </div>
    <div class="form-group">
        <label>Tiêu đề</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Nội dung</label>
        {CONTENT}
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        <input type="file" name="image_checkin" class="form-control">
    </div>


    <div class="text-center">
        <input type="submit" name="submit" value="Lưu" class="btn btn-primary">
    </div>
</form>

<!-- END: main -->
