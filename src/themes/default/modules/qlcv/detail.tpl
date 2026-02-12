<!-- BEGIN: main -->
<div class="job-detail">
    <h1 class="mb-3">{DATA.title}</h1>
    <div class="text-muted mb-3">
        Ngày đăng: {DATA.add_time} | Cập nhật: {DATA.edit_time}
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Mô tả</h5>
            <p class="card-text">{DATA.description}</p>
        </div>
    </div>

    <div class="content mb-4">
        {DATA.content}
    </div>

    <!-- BEGIN: image_checkin -->
    <div class="card mb-3">
        <div class="card-header">Ảnh Check-in</div>
        <div class="card-body text-center">
            <img src="{DATA.image_checkin}" alt="Check-in" class="img-fluid" style="max-height: 400px;">
        </div>
    </div>
    <!-- END: image_checkin -->

    <!-- BEGIN: image_checkout -->
    <div class="card mb-3">
        <div class="card-header">Ảnh Check-out</div>
        <div class="card-body text-center">
            <img src="{DATA.image_checkout}" alt="Check-out" class="img-fluid" style="max-height: 400px;">
        </div>
    </div>
    <!-- END: image_checkout -->

    <!-- BEGIN: file_report -->
    <div class="alert alert-info">
        <strong>File báo cáo:</strong> <a href="{DATA.file_report}" target="_blank" download>Tải về</a>
    </div>
    <!-- END: file_report -->
</div>
<!-- END: main -->
