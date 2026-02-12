<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">ID</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th class="text-center" style="width: 100px;">Thứ tự</th>
                <th class="text-center" style="width: 150px;">Thời gian thêm</th>
                <th class="text-center" style="width: 150px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.id}</td>
                <td>{DATA.title}</td>
                <td>{DATA.description}</td>
                <td class="text-center">{DATA.weight}</td>
                <td class="text-center">{DATA.add_time}</td>
                <td class="text-center">
                    <a href="{DATA.edit_link}" class="btn btn-default btn-xs"><em class="fa fa-edit"></em> Sửa</a>
                    <a href="{DATA.delete_link}" class="btn btn-danger btn-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');"><em class="fa fa-trash-o"></em> Xóa</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<div class="text-center">
    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add_cat" class="btn btn-primary">Thêm danh mục mới</a>
</div>
<!-- END: main -->
