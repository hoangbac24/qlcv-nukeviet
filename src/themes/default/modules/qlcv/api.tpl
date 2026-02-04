<!-- BEGIN: main -->
<h1>{LANG.api_documentation}</h1>

<div class="api-info">
    <h2>REST API Endpoints</h2>
    
    <h3>1. Lấy danh sách công việc</h3>
    <p><strong>URL:</strong> {NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=api&action=tasks</p>
    <p><strong>Phương thức:</strong> GET</p>
    <p><strong>Mô tả:</strong> Lấy danh sách tất cả công việc</p>
    
    <h3>2. Lấy chi tiết công việc</h3>
    <p><strong>URL:</strong> {NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=api&action=task&id={TASK_ID}</p>
    <p><strong>Phương thức:</strong> GET</p>
    <p><strong>Mô tả:</strong> Lấy chi tiết một công việc cụ thể</p>
    
    <h3>3. Lấy danh sách danh mục</h3>
    <p><strong>URL:</strong> {NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=api&action=categories</p>
    <p><strong>Phương thức:</strong> GET</p>
    <p><strong>Mô tả:</strong> Lấy danh sách tất cả danh mục công việc</p>
    
    <h4>Định dạng phản hồi</h4>
    <p>Tất cả API trả về dữ liệu dạng JSON với cấu trúc:</p>
    <pre>
{
    "success": true|false,
    "message": "Thông báo",
    "data": {...}
}
    </pre>
    
    <h4>Ví dụ sử dụng</h4>
    <p>Sử dụng JavaScript fetch API:</p>
    <pre>
fetch('/index.php?language=vi&nv=qlcv&op=api&action=tasks')
    .then(response => response.json())
    .then(data => console.log(data));
    </pre>
</div>
<!-- END: main -->