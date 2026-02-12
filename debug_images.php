<?php
define('NV_SYSTEM', true);
require dirname(__FILE__) . '/src/includes/mainfile.php';

$module_data = 'qlcv';
$sql = "SELECT id, title, image_checkin, file_report FROM " . NV_PREFIXLANG . "_" . $module_data . "_jobs";
$result = $db->query($sql);
$data = $result->fetchAll(PDO::FETCH_ASSOC);

echo "Jobs Data:\n";
print_r($data);

echo "\nUploads Directory Scan:\n";
$upload_dir = NV_UPLOADS_DIR . '/' . 'qlcv'; // Assuming module_upload is qlcv
if (is_dir($upload_dir)) {
    $files = scandir($upload_dir);
    print_r($files);
} else {
    echo "Upload dir does not exist: " . $upload_dir;
}
