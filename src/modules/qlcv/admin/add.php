<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = 'Thêm công việc';

// Handle Form Submission
if ($nv_Request->isset_request('submit', 'post')) {
    $cat_title = $nv_Request->get_title('cat_title', 'post', '');
    $title = $nv_Request->get_title('title', 'post', '');
    $description = $nv_Request->get_textarea('description', 'post', '');
    $content = $nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS);
    $status = 1; // Default to active since field was removed

    if (empty($title)) {
        $error = 'Lỗi: Tiêu đề không được để trống';
    } elseif (empty($cat_title)) {
        $error = 'Lỗi: Vui lòng nhập tên danh mục';
    } else {
        // Upload Logic
        require_once NV_ROOTDIR . '/includes/vendor/vinades/nukeviet/Files/Upload.php';
        require_once NV_ROOTDIR . '/includes/vendor/vinades/nukeviet/Files/Image.php';
        $upload_dir = NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload;
        if (!is_dir($upload_dir)) {
            nv_mkdir($upload_dir, $module_upload, true);
        }

        // Image Checkin
        // Debugging
        $debug_content = "Time: " . date('Y-m-d H:i:s') . "\n";
        $debug_content .= "Module Upload: " . (isset($module_upload) ? $module_upload : 'UNDEFINED') . "\n";
        $debug_content .= "Upload Dir: " . (isset($upload_dir) ? $upload_dir : 'UNDEFINED') . "\n";
        $debug_content .= "Files: " . print_r($_FILES, true) . "\n";

        $image_checkin = '';
        if (isset($_FILES['image_checkin']) && is_uploaded_file($_FILES['image_checkin']['tmp_name'])) {
            $debug_content .= "File detected. Attempting upload...\n";
            $upload = new NukeViet\Files\Upload(['images'], $global_config['forbid_extensions'], [], 5 * 1024 * 1024, 3000, 3000);
            $upload_info = $upload->save_file($_FILES['image_checkin'], $upload_dir, false);
            
            $debug_content .= "Upload Info: " . print_r($upload_info, true) . "\n";
            
            if (empty($upload_info['error'])) {
                 // Resize Image
                try {
                    $image_path = $upload_info['name']; // Full path
                    $image = new NukeViet\Files\Image($image_path);
                    $image->resizeXY(800, 600);
                    $image->save($upload_dir, $upload_info['basename']); // Overwrite
                    $debug_content .= "Image resized to 800x600 max.\n";
                } catch (Exception $e) {
                     $debug_content .= "Image resize failed: " . $e->getMessage() . "\n";
                }

                $image_checkin = $upload_info['basename']; // Use basename
                $debug_content .= "Upload Success. Name: " . $image_checkin . "\n";
            }
        } else {
             $debug_content .= "No file uploaded or is_uploaded_file failed.\n";
        }
        file_put_contents(NV_ROOTDIR . '/debug_add.txt', $debug_content, FILE_APPEND);



        // Check if category exists
        $stmt = $db->prepare('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories WHERE title = :title');
        $stmt->bindValue(':title', $cat_title, PDO::PARAM_STR);
        $stmt->execute();
        $catid = $stmt->fetchColumn();

        // If not exists, create it
        if (!$catid) {
            $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_categories (title, description, weight, add_time, edit_time) VALUES (:title, :description, :weight, :add_time, :edit_time)');
            $stmt->bindValue(':title', $cat_title, PDO::PARAM_STR);
            $stmt->bindValue(':description', '', PDO::PARAM_STR); // Empty description for auto-created cat
            $stmt->bindValue(':weight', 0, PDO::PARAM_INT);
            $stmt->bindValue(':add_time', NV_CURRENTTIME, PDO::PARAM_INT);
            $stmt->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);
            $stmt->execute();
            $catid = $db->lastInsertId();
        }

        try {
            $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_jobs (catid, title, description, content, image_checkin, status, add_time, edit_time) VALUES (:catid, :title, :description, :content, :image_checkin, :status, :add_time, :edit_time)');
            $stmt->bindValue(':catid', $catid, PDO::PARAM_INT);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':content', $content, PDO::PARAM_STR);
            $stmt->bindValue(':image_checkin', $image_checkin, PDO::PARAM_STR);
            $stmt->bindValue(':status', $status, PDO::PARAM_INT);
            $stmt->bindValue(':add_time', NV_CURRENTTIME, PDO::PARAM_INT);
            $stmt->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);
            $stmt->execute();
        
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        } catch(PDOException $e) {
             // Handle if columns missing (Schema update failed fallback)
             // Ideally we run the schema update here if error code suggests column missing but that's complex
             // For now assume schema update worked or will work
             $error = 'Lỗi lưu dữ liệu: ' . $e->getMessage();
        }
    }
}

// Load template
$xtpl = new XTemplate('job_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('OP', $op);

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

$content = isset($content) ? $content : '';
// Simple textarea for content as requested
$content = '<textarea class="form-control" rows="5" name="content">' . htmlspecialchars($content) . '</textarea>';
$xtpl->assign('CONTENT', $content);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
