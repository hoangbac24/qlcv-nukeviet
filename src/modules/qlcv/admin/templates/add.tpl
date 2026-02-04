<h1>Thêm công việc</h1>
<form action="{$NV_BASE_ADMINURL}index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&{$NV_NAME_VARIABLE}={$MODULE_NAME}&op=add" method="post" enctype="multipart/form-data">
    <div>
        <label for="catid">Danh mục:</label>
        <select name="catid" id="catid">
            <option value="0">Chọn danh mục</option>
            {foreach from=$CATEGORIES item=cat}
            <option value="{$cat.id}">{$cat.title}</option>
            {/foreach}
        </select>
    </div>
    <div>
        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" id="title" required />
    </div>
    <div>
        <label for="description">Mô tả:</label>
        <textarea name="description" id="description"></textarea>
    </div>
    <div>
        <label for="status">Trạng thái:</label>
        <select name="status" id="status">
            <option value="0">Chưa hoàn thành</option>
            <option value="1">Hoàn thành</option>
        </select>
    </div>
    <div>
        <label for="checkin_image">Ảnh check in:</label>
        <input type="file" name="checkin_image" id="checkin_image" accept="image/*" />
    </div>
    <div>
        <label for="checkout_image">Ảnh check out:</label>
        <input type="file" name="checkout_image" id="checkout_image" accept="image/*" />
    </div>
    <div>
        <label for="report_file">File báo cáo:</label>
        <input type="file" name="report_file" id="report_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar" />
    </div>
    <div>
        <input type="submit" name="submit" value="Thêm công việc" />
    </div>
</form>