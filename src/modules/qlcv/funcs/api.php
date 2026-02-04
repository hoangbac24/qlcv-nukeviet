<?php

/**
 * REST API for Tasks
 */

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

// Set JSON header
header('Content-Type: application/json');

// Get API action
$action = $nv_Request->get_string('action', 'get', '');

// Get categories
$global_array_cat = [];
$result = $db->query('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
while ($row = $result->fetch()) {
    $global_array_cat[$row['id']] = $row;
}

switch ($action) {
    case 'tasks':
        // Get tasks list
        $userid = $nv_Request->get_int('userid', 'get', 0);
        $catid = $nv_Request->get_int('catid', 'get', 0);
        $status = $nv_Request->get_int('status', 'get', -1);
        $limit = $nv_Request->get_int('limit', 'get', 10);
        $offset = $nv_Request->get_int('offset', 'get', 0);

        $where = [];
        $params = [];

        if ($userid > 0) {
            $where[] = 'userid = :userid';
            $params[':userid'] = $userid;
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

        $sql = 'SELECT id, catid, userid, title, description, status, add_time FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks ' . $where_clause . ' ORDER BY add_time DESC LIMIT ' . $limit . ' OFFSET ' . $offset;

        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();

        $tasks = [];
        while ($row = $stmt->fetch()) {
            $row['category'] = isset($global_array_cat[$row['catid']]) ? $global_array_cat[$row['catid']]['title'] : 'N/A';
            $row['status_text'] = $row['status'] ? 'Completed' : 'Pending';
            $row['add_time'] = date('c', $row['add_time']); // ISO 8601 format
            $tasks[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $tasks,
            'total' => count($tasks)
        ]);
        break;

    case 'categories':
        // Get categories list
        $categories = array_values($global_array_cat);

        echo json_encode([
            'success' => true,
            'data' => $categories,
            'total' => count($categories)
        ]);
        break;

    case 'task':
        // Get single task
        $id = $nv_Request->get_int('id', 'get', 0);

        if ($id > 0) {
            $stmt = $db->prepare('SELECT id, catid, userid, title, description, status, add_time, checkin_image, checkout_image, report_file FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE id = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $task = $stmt->fetch();
            if ($task) {
                $task['category'] = isset($global_array_cat[$task['catid']]) ? $global_array_cat[$task['catid']]['title'] : 'N/A';
                $task['status_text'] = $task['status'] ? 'Completed' : 'Pending';
                $task['add_time'] = date('c', $task['add_time']);

                // Add full URLs for images and files
                if (!empty($task['checkin_image'])) {
                    $task['checkin_image_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $task['checkin_image'];
                }
                if (!empty($task['checkout_image'])) {
                    $task['checkout_image_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $task['checkout_image'];
                }
                if (!empty($task['report_file'])) {
                    $task['report_file_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $task['report_file'];
                }

                echo json_encode([
                    'success' => true,
                    'data' => $task
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Task not found'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid task ID'
            ]);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid API action',
            'available_actions' => ['tasks', 'categories', 'task']
        ]);
        break;
}

exit;