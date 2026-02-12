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

$page_title = 'Sửa công việc';

$id = $nv_Request->get_int('id', 'get', 0);

if ($id > 0) {
    if ($nv_Request->isset_request('submit', 'post')) {
        $cat_title = $nv_Request->get_title('cat_title', 'post', '');
        $title = $nv_Request->get_title('title', 'post', '');
        $description = $nv_Request->get_textarea('description', 'post', '');
        $content = $nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS);
        $status = 1; // Default to active

        if (empty($title)) {
            $error = 'Lỗi: Tiêu đề không được để trống';
        } elseif (empty($cat_title)) {
            $error = 'Lỗi: Vui lòng nhập tên danh mục';
        } else {
            // Upload Logic (Copy from add.php but with update logic)
            require_once NV_ROOTDIR . '/includes/vendor/vinades/nukeviet/Files/Upload.php';
            require_once NV_ROOTDIR . '/includes/vendor/vinades/nukeviet/Files/Image.php';
            $upload_dir = NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload;
            if (!is_dir($upload_dir)) {
                nv_mkdir($upload_dir, $module_upload, true);
            }

            $sql_update_extra = '';
            
            // Image Checkin
            // Debugging
            $debug_content = "Time: " . date('Y-m-d H:i:s') . "\n";
            $debug_content .= "Module Upload: " . (isset($module_upload) ? $module_upload : 'UNDEFINED') . "\n";
            $debug_content .= "Upload Dir: " . (isset($upload_dir) ? $upload_dir : 'UNDEFINED') . "\n";
            $debug_content .= "Files: " . print_r($_FILES, true) . "\n";
            
            if (isset($_FILES['image_checkin']) && is_uploaded_file($_FILES['image_checkin']['tmp_name'])) {
                $debug_content .= "File detected. Attempting upload...\n";
                // Correct Constructor: $allowed_filetypes, $forbid_extensions, $forbid_mimes, $maxsize, $maxwidth, $maxheight
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

                    $sql_update_extra .= ', image_checkin = :image_checkin';
                    $image_checkin = $upload_info['basename']; // Use basename for DB
                    $debug_content .= "Upload Success. Name: " . $image_checkin . "\n";
                } else {
                    $debug_content .= "Upload Error: " . $upload_info['error'] . "\n";
                }
            } else {
                $debug_content .= "No file uploaded or is_uploaded_file failed.\n";
            }
            file_put_contents(NV_ROOTDIR . '/debug_edit.txt', $debug_content, FILE_APPEND);




            // Check if category exists
            $stmt = $db->prepare('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories WHERE title = :title');
            $stmt->bindValue(':title', $cat_title, PDO::PARAM_STR);
            $stmt->execute();
            $catid = $stmt->fetchColumn(); 

            // If not exists, create it
            if (!$catid) {
                $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_categories (title, description, weight, add_time, edit_time) VALUES (:title, :description, :weight, :add_time, :edit_time)');
                $stmt->bindValue(':title', $cat_title, PDO::PARAM_STR);
                $stmt->bindValue(':description', '', PDO::PARAM_STR); 
                $stmt->bindValue(':weight', 0, PDO::PARAM_INT);
                $stmt->bindValue(':add_time', NV_CURRENTTIME, PDO::PARAM_INT);
                $stmt->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);
                $stmt->execute();
                $catid = $db->lastInsertId();
            }

            try {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_jobs SET catid = :catid, title = :title, description = :description, content = :content, status = :status, edit_time = :edit_time' . $sql_update_extra . ' WHERE id = :id');
                $stmt->bindValue(':catid', $catid, PDO::PARAM_INT);
                $stmt->bindValue(':title', $title, PDO::PARAM_STR);
                $stmt->bindValue(':description', $description, PDO::PARAM_STR);
                $stmt->bindValue(':content', $content, PDO::PARAM_STR);
                $stmt->bindValue(':status', $status, PDO::PARAM_INT);
                $stmt->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);

                if (isset($image_checkin) && !empty($sql_update_extra) && strpos($sql_update_extra, 'image_checkin') !== false) {
                    $stmt->bindValue(':image_checkin', $image_checkin, PDO::PARAM_STR);
                }


                $stmt->execute();
            
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
            } catch(PDOException $e) {
                 $error = 'Lỗi cập nhật: ' . $e->getMessage();
            }
        }
    }

    // Fetch job with category title
    $stmt = $db->prepare('SELECT a.*, b.title as cat_title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_jobs a LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_categories b ON a.catid = b.id WHERE a.id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row) {
        $xtpl = new XTemplate('edit.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $nv_Lang);
        $xtpl->assign('MODULE_NAME', $module_name);
        $xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
        $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
        $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
        $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
        $xtpl->assign('OP', $op);
        $xtpl->assign('DATA', $row);

        if (!empty($error)) {
            $xtpl->assign('ERROR', $error);
            $xtpl->parse('main.error');
        }

        $content = isset($content) ? $content : $row['content'];
        $content = '<textarea class="form-control" rows="5" name="content">' . htmlspecialchars($content) . '</textarea>';
        $xtpl->assign('CONTENT', $content);

        if (!empty($row['image_checkin'])) $xtpl->parse('main.image_checkin');


        $xtpl->parse('main');
        $contents = $xtpl->text('main');

        include NV_ROOTDIR . '/includes/header.php';
        echo nv_admin_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    } else {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }
} else {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}