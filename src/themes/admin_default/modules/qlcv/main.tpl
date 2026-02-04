<!-- BEGIN: main -->
<h1>Danh sách công việc</h1>
<a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add">Thêm công việc</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Danh mục</th>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Trạng thái</th>
        <th>Ảnh Check In</th>
        <th>Ảnh Check Out</th>
        <th>File Báo Cáo</th>
        <th>Thời gian thêm</th>
        <th>Thao tác</th>
    </tr>
    <!-- BEGIN: loop -->
    <tr>
        <td>{DATA.id}</td>
        <td>{DATA.cat_title}</td>
        <td>{DATA.title}</td>
        <td>{DATA.description}</td>
        <td>{DATA.status_text}</td>
        <td>
            {if DATA.checkin_image_url}
            <img src="{DATA.checkin_image_url}" width="50" alt="Check In" />
            {/if}
        </td>
        <td>
            {if DATA.checkout_image_url}
            <img src="{DATA.checkout_image_url}" width="50" alt="Check Out" />
            {/if}
        </td>
        <td>
            {if DATA.report_file_url}
            <a href="{DATA.report_file_url}" target="_blank">Download</a>
            {/if}
        </td>
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