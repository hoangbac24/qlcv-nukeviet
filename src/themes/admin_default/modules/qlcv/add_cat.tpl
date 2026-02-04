<!-- BEGIN: main -->
<h1>Thêm danh mục</h1>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add_cat" method="post">
    <div>
        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" id="title" required />
    </div>
    <div>
        <label for="description">Mô tả:</label>
        <textarea name="description" id="description"></textarea>
    </div>
    <div>
        <label for="weight">Thứ tự:</label>
        <input type="number" name="weight" id="weight" value="0" />
    </div>
    <div>
        <input type="submit" name="submit" value="Thêm danh mục" />
    </div>
</form>
<!-- END: main -->