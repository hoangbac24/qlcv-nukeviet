<!-- BEGIN: main -->
<h1>Danh mục công việc</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Thứ tự</th>
        <th>Thời gian thêm</th>
    </tr>
    <!-- BEGIN: loop -->
    <tr>
        <td>{DATA.id}</td>
        <td>{DATA.title}</td>
        <td>{DATA.description}</td>
        <td>{DATA.weight}</td>
        <td>{DATA.add_time}</td>
    </tr>
    <!-- END: loop -->
</table>
<div class="pagination">
    {GENERATE_PAGE}
</div>
<!-- END: main -->