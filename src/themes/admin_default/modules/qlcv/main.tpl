<!-- BEGIN: main -->
<div class="well">
    <form action="{NV_BASE_ADMINURL}index.php" method="get">
        <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
        <div class="row">
            <div class="col-xs-24 col-md-6">
                <div class="form-group">
                    <input class="form-control" type="text" value="{Q}" name="q" maxlength="255" placeholder="Tìm kiếm..." />
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Tìm kiếm" />
                </div>
            </div>
        </div>
    </form>
</div>

<!-- BEGIN: search_info -->
<div class="alert alert-info">
    Kết quả tìm kiếm cho từ khóa: <strong>{Q}</strong>
    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}" class="btn btn-warning btn-xs pull-right">
        <i class="fa fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>
<!-- END: search_info -->

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" width="50">STT</th>
                <th class="text-center" width="20%">Tiêu đề</th>
                <th class="text-center" width="20%">Danh mục</th>
                <th class="text-center" width="20%">Mô tả</th>
                <th class="text-center">Hình ảnh</th>
                <th class="text-center" width="150"></th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.stt}</td>
                <td class="text-center">
                    <strong>{DATA.title}</strong>

                </td>
                <td class="text-center">{DATA.cat_title}</td>
                <td class="text-center">{DATA.description}</td>
                <td class="text-center">
                    <!-- BEGIN: checkin_image -->
                    <a href="{DATA.checkin_image_url}" class="glightbox" target="_blank"><img src="{DATA.checkin_image_url}" alt="{DATA.title}" style="width: 100px;"></a>
                    <!-- END: checkin_image -->
                </td>
                <td class="text-center">
                    <a href="{DATA.edit_link}" class="btn btn-info btn-xs" title="Sửa"><i class="fa fa-edit"></i> Sửa</a>
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
    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm công việc mới</a>
</div>
<!-- END: main -->