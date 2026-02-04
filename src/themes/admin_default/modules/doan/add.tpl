<!-- BEGIN main -->
<h1>Thêm đồ án</h1>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add" method="post">
    <div>
        <label for="ten">Tên đồ án:</label>
        <input type="text" name="ten" id="ten" required />
    </div>
    <div>
        <label for="mo_ta">Mô tả:</label>
        <textarea name="mo_ta" id="mo_ta"></textarea>
    </div>
    <div>
        <input type="submit" name="submit" value="Thêm đồ án" />
    </div>
</form>
<!-- END main -->