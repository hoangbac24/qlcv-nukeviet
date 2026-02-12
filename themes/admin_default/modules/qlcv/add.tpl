<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add" method="post">
    <div class="form-group">
        <label>Danh mục</label>
        <select name="catid" class="form-control" required>
            <option value="0">-- Chọn danh mục --</option>
            <!-- BEGIN: cat_loop -->
            <option value="{CAT.id}">{CAT.title}</option>
            <!-- END: cat_loop -->
        </select>
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
        <label><input type="checkbox" name="status" value="1" checked> Hoạt động?</label>
    </div>
    <div class="text-center">
        <input type="submit" name="submit" value="Lưu" class="btn btn-primary">
    </div>
</form>

<div class="table-responsive" style="margin-top: 20px;">
    <!-- BEGIN: list -->
    <h3>Danh sách công việc đã đăng</h3>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">STT</th>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th class="text-center" style="width: 180px;">Ngày tạo</th>
                <th class="text-center" style="width: 150px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: row -->
            <tr>
                <td class="text-center">{ROW.stt}</td>
                <td>{ROW.title}</td>
                <td>{ROW.author}</td>
                <td class="text-center">{ROW.add_time}</td>
                <td class="text-center">
                    <a href="{ROW.edit_link}" class="btn btn-info btn-xs"><em class="fa fa-edit"></em> Sửa</a>
                    <a href="{ROW.delete_link}" class="btn btn-danger btn-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa?');"><em class="fa fa-trash-o"></em> Xóa</a>
                </td>
            </tr>
            <!-- END: row -->
        </tbody>
    </table>
    <div class="text-center">
        {GENERATE_PAGE}
    </div>
    <!-- END: list -->
</div>
<!-- END: main -->
