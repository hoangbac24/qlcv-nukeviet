<!-- BEGIN: main -->
<div class="my-jobs-detail">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h1 class="panel-title">{DATA.title}</h1>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted">
                        <span class="glyphicon glyphicon-time"></span> Posted on: {DATA.add_time}
                    </p>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                     <p><strong>Description:</strong> {DATA.description}</p>
                     <hr>
                     <div>{DATA.content}</div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
             <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}" class="btn btn-default">Back to List</a>
        </div>
    </div>
</div>
<!-- END: main -->
