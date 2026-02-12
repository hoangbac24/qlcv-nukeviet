<!-- BEGIN: main -->
<div class="my-jobs-list">
    <!-- BEGIN: loop -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="{DATA.link}">{DATA.title}</a></h3>
        </div>
        <div class="panel-body">
            <p class="text-muted"><small>Posted on: {DATA.add_time}</small></p>
            <p>{DATA.description}</p>
            <a href="{DATA.link}" class="btn btn-primary btn-sm">Read More</a>
        </div>
    </div>
    <!-- END: loop -->
</div>
<div class="text-center">
    {GENERATE_PAGE}
</div>
<!-- END: main -->
