<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">ID</th>
                <th>Title</th>
                <th>Description</th>
                <th class="text-center" style="width: 100px;">Weight</th>
                <th class="text-center" style="width: 150px;">Add Time</th>
                <th class="text-center" style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.id}</td>
                <td>{DATA.title}</td>
                <td>{DATA.description}</td>
                <td class="text-center">{DATA.weight}</td>
                <td class="text-center">{DATA.add_time}</td>
                <td class="text-center">
                    <a href="{DATA.edit_link}" class="btn btn-default btn-xs"><em class="fa fa-edit"></em> Edit</a>
                    <a href="{DATA.delete_link}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this category?');"><em class="fa fa-trash-o"></em> Delete</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<div class="text-center">
    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add_cat" class="btn btn-primary">Add New Category</a>
</div>
<!-- END: main -->
