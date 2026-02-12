<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=add" method="post">
    <div class="form-group">
        <label>Category</label>
        <select name="catid" class="form-control" required>
            <option value="0">-- Select Category --</option>
            <!-- BEGIN: cat_loop -->
            <option value="{CAT.id}">{CAT.title}</option>
            <!-- END: cat_loop -->
        </select>
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Content</label>
        {CONTENT}
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="status" value="1" checked> Active?</label>
    </div>
    <div class="text-center">
        <input type="submit" name="submit" value="Save" class="btn btn-primary">
    </div>
</form>
<!-- END: main -->
