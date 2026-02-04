<!-- BEGIN: main -->
<h1>Danh sách công việc</h1>
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
    </tr>
    <!-- BEGIN: loop -->
    <tr>
        <td>{DATA.id}</td>
        <td>{DATA.category}</td>
        <td>{DATA.title}</td>
        <td>{DATA.description}</td>
        <td>{if DATA.status}Hoàn thành{else}Chưa hoàn thành{/if}</td>
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
    </tr>
    <!-- END: loop -->
</table>
<div class="pagination">
    {GENERATE_PAGE}
</div>
<!-- END: main -->