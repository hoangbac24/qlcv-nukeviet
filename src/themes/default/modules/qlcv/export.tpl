<!-- BEGIN: main -->
<h1>{LANG.export_tasks}</h1>
<p>{LANG.export_description}</p>

<div class="export-options">
    <h3>{LANG.choose_export_format}</h3>
    <p>{LANG.total_tasks}: {TASK_COUNT}</p>

    <div class="export-buttons">
        <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=export&format=csv" class="btn btn-primary">
            {LANG.export_csv}
        </a>

        <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=export&format=pdf" class="btn btn-secondary">
            {LANG.export_pdf}
        </a>
    </div>
</div>

<div class="export-info">
    <h4>{LANG.export_info}</h4>
    <ul>
        <li>{LANG.csv_description}</li>
        <li>{LANG.pdf_description}</li>
    </ul>
</div>
<!-- END: main -->