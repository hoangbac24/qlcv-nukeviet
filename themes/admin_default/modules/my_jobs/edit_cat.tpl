<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=edit_cat&id={DATA.id}" method="post">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{DATA.title}" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="5">{DATA.description}</textarea>
    </div>
    <div class="form-group">
        <label>Weight</label>
        <input type="number" name="weight" class="form-control" value="{DATA.weight}">
    </div>
    <div class="text-center">
        <input type="submit" name="submit" value="Save Changes" class="btn btn-primary">
    </div>
</form>
<!-- END: main -->
