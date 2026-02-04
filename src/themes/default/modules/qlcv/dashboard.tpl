<!-- BEGIN: main -->
<h1>{LANG.dashboard} - {USER_INFO.username}</h1>
<p>{LANG.welcome_dashboard}</p>

<h2>{LANG.my_tasks}</h2>
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
<!-- END: main -->