<h1>Sửa công việc</h1>
<form action="{$NV_BASE_ADMINURL}index.php?{$NV_LANG_VARIABLE}={$NV_LANG_DATA}&{$NV_NAME_VARIABLE}={$MODULE_NAME}&op=edit&id={$DATA.id}" method="post" enctype="multipart/form-data">
    <div>
        <label for="catid">Danh mục:</label>
        <select name="catid" id="catid">
            <option value="0">Chọn danh mục</option>
            {foreach from=$CATEGORIES item=cat}
            <option value="{$cat.id}" {if $cat.id == $DATA.catid}selected{/if}>{$cat.title}</option>
            {/foreach}
        </select>
    </div>
    <div>
        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" id="title" value="{$DATA.title}" required />
    </div>
    <div>
        <label for="description">Mô tả:</label>
        <textarea name="description" id="description">{$DATA.description}</textarea>
    </div>
    <div>
        <label for="status">Trạng thái:</label>
        <select name="status" id="status">
            <option value="0" {if $DATA.status == 0}selected{/if}>Chưa hoàn thành</option>
            <option value="1" {if $DATA.status == 1}selected{/if}>Hoàn thành</option>
        </select>
    </div>
    <div>
        <label for="checkin_image">Ảnh check in:</label>
        {if $DATA.checkin_image}
        <div>
            <img src="{NV_BASE_SITEURL}uploads/{$MODULE_NAME}/{$DATA.checkin_image}" width="100" alt="Check in" />
            <br />
        </div>
        {/if}
        <input type="file" name="checkin_image" id="checkin_image" accept="image/*" />
    </div>
    <div>
        <label for="checkout_image">Ảnh check out:</label>
        {if $DATA.checkout_image}
        <div>
            <img src="{NV_BASE_SITEURL}uploads/{$MODULE_NAME}/{$DATA.checkout_image}" width="100" alt="Check out" />
            <br />
        </div>
        {/if}
        <input type="file" name="checkout_image" id="checkout_image" accept="image/*" />
    </div>
    <div>
        <label for="report_file">File báo cáo:</label>
        {if $DATA.report_file}
        <div>
            <a href="{NV_BASE_SITEURL}uploads/{$MODULE_NAME}/{$DATA.report_file}" target="_blank">{$DATA.report_file}</a>
            <br />
        </div>
        {/if}
        <input type="file" name="report_file" id="report_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar" />
    </div>
    <div>
        <input type="submit" name="submit" value="Cập nhật công việc" />
    </div>
</form>