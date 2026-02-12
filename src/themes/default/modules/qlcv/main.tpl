<!-- BEGIN: main -->
<h1>{LANG.task_management}</h1>

<div class="module-navigation">
    <ul>
        <li><a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=dashboard">{LANG.dashboard}</a></li>
        <li><a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=search">{LANG.search_tasks}</a></li>
        <li><a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=export">{LANG.export_tasks}</a></li>
        <li><a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=api">{LANG.api_documentation}</a></li>
    </ul>
</div>

<h2>{LANG.all_tasks}</h2>
<table border="1">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">{LANG.image}</th>
            <th>{LANG.title}</th>
            <th>{LANG.description}</th>


            <th class="text-center">{LANG.feature}</th>
        </tr>
    </thead>
    <tbody>
    <!-- BEGIN: loop -->
    <tr>
        <td class="text-center">{DATA.stt}</td>
        <td class="text-center">
            <!-- BEGIN: checkin_image -->
            <a href="{DATA.checkin_image_url}" class="glightbox"><img src="{DATA.checkin_image_url}" alt="{DATA.title}" style="max-width: 100px; max-height: 60px;"></a>
            <!-- END: checkin_image -->
        </td>
        <td><a href="{DATA.link}"><strong>{DATA.title}</strong></a></td>
        <td>{DATA.description}</td>


        <td class="text-center">
        </td>
    </tr>
    <!-- END: loop -->
    </tbody>
</table>
<div class="pagination">
    {GENERATE_PAGE}
</div>
<!-- END: main -->