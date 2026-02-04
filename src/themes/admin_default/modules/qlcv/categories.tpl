<!-- BEGIN: main -->
<h1>Danh mục công việc</h1>
<a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add_cat">Thêm danh mục</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Thứ tự</th>
        <th>Thời gian thêm</th>
        <th>Thao tác</th>
    </tr>
    <!-- BEGIN: loop -->
    <tr>
        <td>{DATA.id}</td>
        <td>{DATA.title}</td>
        <td>{DATA.description}</td>
        <td>{DATA.weight}</td>
        <td>{DATA.add_time}</td>
        <td>
            <a href="{DATA.edit_link}">Sửa</a> |
            <a href="{DATA.delete_link}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
        </td>
    </tr>
    <!-- END: loop -->
</table>
{GENERATE_PAGE}
<!-- END: main -->