<!-- BEGIN: main -->
<div class="qlcv-list">
    <table class="table table-striped table-bordered table-hover">
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
</div>
<div class="text-center">
    {GENERATE_PAGE}
</div>
<!-- END: main -->
