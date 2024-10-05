<?php
$db_user = "root";
$db_password = "";

try {
    $db = new PDO("mysql:host=localhost;port=3306;dbname=cars", $db_user, $db_password);
    // عرض الأخطاء إن وجدت
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // طباعة رسالة خطأ إذا فشل الاتصال
    echo "Connection failed: " . $e->getMessage();
}
?>