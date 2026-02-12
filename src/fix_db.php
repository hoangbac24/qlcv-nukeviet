<?php

define('NV_SYSTEM', true);
require 'includes/mainfile.php';

$module_data = 'qlcv';
// We need to determine prefix if not standard. But NV_PREFIXLANG is set in mainfile.php
// Assuming 'vi' as default lang prefix usually used if not defined in cli context?
// Actually NV_PREFIXLANG might not be set in CLI without request.
// Let's list tables matching %_qlcv_jobs to find the table.

$sql = "SHOW TABLES LIKE '%_qlcv_jobs'";
$result = $db->query($sql);
$tables = $result->fetchAll(PDO::FETCH_COLUMN);

if (empty($tables)) {
    die("Error: Table _qlcv_jobs not found with any prefix.\n");
}

foreach ($tables as $table_name) {
    echo "Checking table: " . $table_name . "\n";
    $sql = "SHOW COLUMNS FROM " . $table_name;
    $result = $db->query($sql);
    $columns = $result->fetchAll(PDO::FETCH_COLUMN);

    echo "Current columns: " . implode(', ', $columns) . "\n";

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
            echo "Executing: " . $sql . "\n";
            try {
                $db->query($sql);
                echo "Success!\n";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        }
    } else {
        echo "All required columns exist.\n";
    }
}
echo "Done.\n";
