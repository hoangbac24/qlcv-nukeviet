<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=edit&id={DATA.id}" method="post">
    <div class="form-group">
        <label>Category</label>
        <select name="catid" class="form-control" required>
            <option value="0">-- Select Category --</option>
            <!-- BEGIN: cat_loop -->
            <option value="{CAT.id}" {CAT.selected}>{CAT.title}</option>
            <!-- END: cat_loop -->
        </select>
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{DATA.title}" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3">{DATA.description}</textarea>
    </div>
    <div class="form-group">
        <label>Content</label>
        {CONTENT}
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="status" value="1" {CHECKED_STATUS}> Active?</label>
    </div>
    <div class="text-center">
        <input type="submit" name="submit" value="Save Changes" class="btn btn-primary">
    </div>
</form>
<!-- END: main -->
