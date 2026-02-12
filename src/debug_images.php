<?php
define('NV_SYSTEM', true);
chdir(dirname(__FILE__) . '/src');
require 'includes/mainfile.php';

$module_data = 'qlcv';
// Need to find table prefix dynamically or just assume.
// NV_PREFIXLANG is available after mainfile.php

echo "<h2>Debug Info</h2>";

$sql = "SELECT id, title, image_checkin FROM " . NV_PREFIXLANG . "_" . $module_data . "_jobs LIMIT 5";
$result = $db->query($sql);
$jobs = $result->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($jobs);
echo "</pre>";

$upload_dir = NV_UPLOADS_DIR . '/' . $module_upload;
echo "<h3>Upload Dir: $upload_dir</h3>";

if (is_dir(NV_ROOTDIR . '/' . $upload_dir)) {
    $files = scandir(NV_ROOTDIR . '/' . $upload_dir);
    echo "<pre>";
    print_r($files);
    echo "</pre>";
} else {
    echo "Directory not found: " . NV_ROOTDIR . '/' . $upload_dir;
}
