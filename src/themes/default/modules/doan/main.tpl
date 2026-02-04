<!-- BEGIN main -->
<h1>Danh sách đồ án</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Mô tả</th>
        <th>Thời gian thêm</th>
    </tr>
    <!-- BEGIN loop -->
    <tr>
        <td>{DATA.id}</td>
        <td>{DATA.ten}</td>
        <td>{DATA.mo_ta}</td>
        <td>{DATA.addtime}</td>
    </tr>
    <!-- END loop -->
</table>
<!-- END main -->