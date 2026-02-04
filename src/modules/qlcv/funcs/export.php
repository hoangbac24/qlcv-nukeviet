<?php

/**
 * Export Tasks
 */

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

// Check if user is logged in
if (!defined('NV_IS_USER')) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$format = $nv_Request->get_string('format', 'get', 'csv');

$page_title = $nv_Lang->getModule('export');
$key_words = 'qlcv, export, tasks';

// Get categories
$global_array_cat = [];
$result = $db->query('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
while ($row = $result->fetch()) {
    $global_array_cat[$row['id']] = $row;
}

// Get user's tasks
$result = $db->query('SELECT id, catid, title, description, status, add_time, checkin_image, checkout_image, report_file FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE userid = ' . $user_info['userid'] . ' ORDER BY add_time DESC');
$tasks = [];
while ($row = $result->fetch()) {
    $row['category'] = isset($global_array_cat[$row['catid']]) ? $global_array_cat[$row['catid']]['title'] : 'N/A';
    $row['status_text'] = $row['status'] ? $nv_Lang->getModule('completed') : $nv_Lang->getModule('pending');
    $row['add_time'] = date('d/m/Y H:i', $row['add_time']);
    $tasks[] = $row;
}

if ($format == 'csv') {
    // Export CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=tasks_' . $user_info['username'] . '_' . date('Y-m-d') . '.csv');

    $output = fopen('php://output', 'w');

    // CSV headers
    fputcsv($output, [
        $nv_Lang->getModule('id'),
        $nv_Lang->getModule('category'),
        $nv_Lang->getModule('title'),
        $nv_Lang->getModule('description'),
        $nv_Lang->getModule('status'),
        $nv_Lang->getModule('add_time')
    ]);

    // CSV data
    foreach ($tasks as $task) {
        fputcsv($output, [
            $task['id'],
            $task['category'],
            $task['title'],
            $task['description'],
            $task['status_text'],
            $task['add_time']
        ]);
    }

    fclose($output);
    exit;
} elseif ($format == 'pdf') {
    // Export PDF (simple HTML to PDF)
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=tasks_' . $user_info['username'] . '_' . date('Y-m-d') . '.pdf');

    $html = '<h1>' . $nv_Lang->getModule('my_tasks') . ' - ' . $user_info['username'] . '</h1>';
    $html .= '<table border="1" cellpadding="5" cellspacing="0">';
    $html .= '<tr>';
    $html .= '<th>' . $nv_Lang->getModule('id') . '</th>';
    $html .= '<th>' . $nv_Lang->getModule('category') . '</th>';
    $html .= '<th>' . $nv_Lang->getModule('title') . '</th>';
    $html .= '<th>' . $nv_Lang->getModule('description') . '</th>';
    $html .= '<th>' . $nv_Lang->getModule('status') . '</th>';
    $html .= '<th>' . $nv_Lang->getModule('add_time') . '</th>';
    $html .= '</tr>';

    foreach ($tasks as $task) {
        $html .= '<tr>';
        $html .= '<td>' . $task['id'] . '</td>';
        $html .= '<td>' . $task['category'] . '</td>';
        $html .= '<td>' . $task['title'] . '</td>';
        $html .= '<td>' . $task['description'] . '</td>';
        $html .= '<td>' . $task['status_text'] . '</td>';
        $html .= '<td>' . $task['add_time'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Simple HTML to PDF conversion (you might want to use a proper PDF library)
    echo $html;
    exit;
} else {
    // Show export options
    $xtpl = new XTemplate('export.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $nv_Lang);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_FILE', $module_file);
    $xtpl->assign('USER_INFO', $user_info);
    $xtpl->assign('TASK_COUNT', count($tasks));

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}