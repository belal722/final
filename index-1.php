<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "name_9");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// استعلام للحصول على البيانات من جدول products
$sql = "SELECT * FROM products ORDER BY id ASC";
$result = $conn->query($sql);

// التحقق من وجود نتائج
if ($result->num_rows > 0) {
    // طباعة البيانات في جدول HTML
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>اسم العميل</th><th>اسم الشخص</th><th>رقم الهاتف</th><th>ملف PDF</th><th>تاريخ الإنشاء</th><th>إجراءات</th></tr>";

    // طباعة كل سجل
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['client_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['person_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "<td><a href='uploads/" . htmlspecialchars($row['pdf_file']) . "'>" . htmlspecialchars($row['pdf_file']) . "</a></td>";
        echo "<td>" . $row['created_at'] . "</td>";
        // إضافة زر الحذف والتعديل
        echo "<td>";
        echo "<a href='?delete=" . $row['id'] . "' onclick='return confirm(\"هل أنت متأكد من الحذف؟\")'>حذف</a> | ";
        echo "<a href='edit.php?id=" . $row['id'] . "'>تعديل</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "لا توجد بيانات لعرضها.";
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
