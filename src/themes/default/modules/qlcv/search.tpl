<!-- BEGIN: main -->
<h1>{LANG.search_tasks}</h1>

<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&op=search" method="get">
    <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
    <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
    <input type="hidden" name="op" value="search" />

    <div>
        <label for="q">{LANG.search_keyword}:</label>
        <input type="text" name="q" id="q" value="{SEARCH_QUERY}" placeholder="{LANG.search_placeholder}" />
    </div>

    <div>
        <label for="catid">{LANG.category}:</label>
        <select name="catid" id="catid">
            <option value="0">{LANG.all_categories}</option>
            <!-- BEGIN: cat_option -->
            <option value="{CAT.id}" {CAT_SELECTED}>{CAT.title}</option>
            <!-- END: cat_option -->
        </select>
    </div>

    <div>
        <label for="status">{LANG.status}:</label>
        <select name="status" id="status">
            <option value="-1">{LANG.all_status}</option>
            <option value="0" {SEARCH_STATUS_0}>{LANG.pending}</option>
            <option value="1" {SEARCH_STATUS_1}>{LANG.completed}</option>
        </select>
    </div>

    <div>
        <input type="submit" value="{LANG.search}" />
    </div>
</form>

<!-- BEGIN: results -->
<h2>{LANG.search_results}: {NUM_ITEMS} {LANG.tasks_found}</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>{LANG.category}</th>
        <th>{LANG.title}</th>
        <th>{LANG.description}</th>
        <th>{LANG.status}</th>
        <th>{LANG.checkin_image}</th>
        <th>{LANG.checkout_image}</th>
        <th>{LANG.report_file}</th>
        <th>{LANG.add_time}</th>
    </tr>
    <!-- BEGIN: loop -->
    <tr>
        <td>{DATA.id}</td>
        <td>{DATA.category}</td>
        <td>{DATA.title}</td>
        <td>{DATA.description}</td>
        <td>{DATA.status_text}</td>
        <td>
            <!-- BEGIN: checkin_image -->
            <img src="{DATA.checkin_image_url}" width="50" alt="{LANG.checkin_image}" />
            <!-- END: checkin_image -->
        </td>
        <td>
            <!-- BEGIN: checkout_image -->
            <img src="{DATA.checkout_image_url}" width="50" alt="{LANG.checkout_image}" />
            <!-- END: checkout_image -->
        </td>
        <td>
            <!-- BEGIN: report_file -->
            <a href="{DATA.report_file_url}" target="_blank">{LANG.download}</a>
            <!-- END: report_file -->
        </td>
        <td>{DATA.add_time}</td>
    </tr>
    <!-- END: loop -->
</table>
<div class="pagination">
    {GENERATE_PAGE}
</div>
<!-- END: results -->

<!-- BEGIN: no_results -->
<p>{LANG.no_search_results}</p>
<!-- END: no_results -->
<!-- END: main -->