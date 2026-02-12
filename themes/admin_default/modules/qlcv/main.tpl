<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" width="50">STT</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Mô tả</th>
                <th class="text-center">Hình ảnh</th>
                <th class="text-center" width="150"></th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.stt}</td>
                <td><strong>{DATA.title}</strong></td>
                <td>{DATA.cat_title}</td>
                <td>{DATA.description}</td>
                <td class="text-center">
                    <!-- BEGIN: checkin_image -->
                    <a href="{DATA.checkin_image_url}" class="glightbox" target="_blank"><img src="{DATA.checkin_image_url}" alt="{DATA.title}" style="max-width: 100px; max-height: 60px;"></a>
                    <!-- END: checkin_image -->
                </td>
                <td class="text-center">
                    <a href="{DATA.edit_link}" class="btn btn-default btn-xs" title="Sửa"><i class="fa fa-edit"></i> Sửa</a>
                    <a href="{DATA.delete_link}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-xs" title="Xóa"><i class="fa fa-trash-o"></i> Xóa</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<div class="text-center">
    {GENERATE_PAGE}
</div>
<div class="text-center">
    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add" class="btn btn-primary">Thêm công việc mới</a>
</div>
<!-- END: main -->
