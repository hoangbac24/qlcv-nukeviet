<?php

/**
 * Search Tasks
 */

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('search');
$key_words = 'qlcv, search, tasks';

$per_page = 10;
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=search';

// Get search parameters
$q = $nv_Request->get_title('q', 'get', '');
$catid = $nv_Request->get_int('catid', 'get', 0);
$status = $nv_Request->get_int('status', 'get', -1);

// Get categories for filter
$global_array_cat = [];
$result = $db->query('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
while ($row = $result->fetch()) {
    $global_array_cat[$row['id']] = $row;
}

// Build search query
$where = [];
$params = [];

if (!empty($q)) {
    $where[] = '(title LIKE :q OR description LIKE :q)';
    $params[':q'] = '%' . $q . '%';
}

if ($catid > 0) {
    $where[] = 'catid = :catid';
    $params[':catid'] = $catid;
}

if ($status >= 0) {
    $where[] = 'status = :status';
    $params[':status'] = $status;
}

$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Query search results
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_tasks')
    ->where($where_clause);

if (!empty($params)) {
    foreach ($params as $key => $value) {
        $db->bindParam($key, $value);
    }
}

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('id, catid, title, description, status, add_time, checkin_image, checkout_image, report_file')
    ->order('add_time DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$array_data = [];
while ($row = $result->fetch()) {
    $row['category'] = isset($global_array_cat[$row['catid']]) ? $global_array_cat[$row['catid']]['title'] : 'N/A';
    $row['status_text'] = $row['status'] ? $nv_Lang->getModule('completed') : $nv_Lang->getModule('pending');

    // Handle images and files
    if (!empty($row['checkin_image'])) {
        $row['checkin_image_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $row['checkin_image'];
    }
    if (!empty($row['checkout_image'])) {
        $row['checkout_image_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $row['checkout_image'];
    }
    if (!empty($row['report_file'])) {
        $row['report_file_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $row['report_file'];
    }

    $row['add_time'] = date('d/m/Y H:i', $row['add_time']);
    $array_data[] = $row;
}

// Generate page
$generate_page = nv_generate_page($base_url . '&q=' . urlencode($q) . '&catid=' . $catid . '&status=' . $status, $num_items, $per_page, $page);

// Use XTemplate
$xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('PAGE', $page);
$xtpl->assign('GENERATE_PAGE', $generate_page);
$xtpl->assign('SEARCH_QUERY', $q);
$xtpl->assign('SEARCH_CATID', $catid);
$xtpl->assign('SEARCH_STATUS', $status);

// Categories for filter
foreach ($global_array_cat as $cat) {
    $xtpl->assign('CAT', $cat);
    $xtpl->assign('CAT_SELECTED', $cat['id'] == $catid ? 'selected' : '');
    $xtpl->parse('main.cat_option');
}

foreach ($array_data as $data) {
    $xtpl->assign('DATA', $data);
    
    // Handle conditional blocks for images and files
    if (!empty($data['checkin_image_url'])) {
        $xtpl->parse('main.results.loop.checkin_image');
    }
    if (!empty($data['checkout_image_url'])) {
        $xtpl->parse('main.results.loop.checkout_image');
    }
    if (!empty($data['report_file_url'])) {
        $xtpl->parse('main.results.loop.report_file');
    }
    
    $xtpl->parse('main.results.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';