<?php

define('NV_SYSTEM', true);
chdir(dirname(__FILE__) . '/src');
require 'includes/mainfile.php';

$module_data = 'qlcv';
$table_name = NV_PREFIXLANG . '_' . $module_data . '_jobs';

echo "Checking table: " . $table_name . "<br>";

$sql = "SHOW COLUMNS FROM " . $table_name;
$result = $db->query($sql);
$columns = $result->fetchAll(PDO::FETCH_COLUMN);

echo "Current columns: " . implode(', ', $columns) . "<br><br>";

$missing_cols = [];
if (!in_array('image_checkin', $columns)) {
    $missing_cols[] = "ADD COLUMN image_checkin VARCHAR(255) DEFAULT '' AFTER content";
}
if (!in_array('file_report', $columns)) {
    $missing_cols[] = "ADD COLUMN file_report VARCHAR(255) DEFAULT '' AFTER image_checkin";
}

if (!empty($missing_cols)) {
    foreach ($missing_cols as $add_sql) {
        $sql = "ALTER TABLE " . $table_name . " " . $add_sql;
        echo "Executing: " . $sql . "<br>";
        try {
            $db->query($sql);
            echo "Success!<br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "All required columns exist.";
}

echo "<br>Done.";
die();
