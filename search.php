<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "name_9");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// استلام البحث
$search = isset($_GET['search']) ? $_GET['search'] : '';

// استعلام البحث
$sql = "SELECT * FROM products WHERE client_name LIKE '%$search%' OR person_name LIKE '%$search%' OR phone LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($sql);

// التأكد من وجود نتائج
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>رقم</th><th>اسم الشركة</th><th>اسم الشخص</th><th>رقم الهاتف</th><th>ملف PDF</th><th>تاريخ الإضافة</th><th>إجراءات</th></tr>";

    $n = 1; // متغير للترقيم اليدوي
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $n++ . "</td>"; // طباعة الترقيم المتسلسل
        echo "<td>" . htmlspecialchars($row['client_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['person_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";

        // عرض الملفات
        $pdf_files = explode(',', $row['pdf_file']);
        echo "<td>";
        foreach ($pdf_files as $file) {
            echo "<a href='uploads/" . htmlspecialchars($file) . "' class='pdf'>" . htmlspecialchars($file) . "</a><br>";
        }
        echo "</td>";

        // عرض تاريخ الإضافة
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";

        // عرض الإجراءات (الحذف والتعديل)
        echo "<td>";
        echo "<a href='?delete=" . $row['id'] . "' class='delete' onclick='return confirm(\"هل أنت متأكد من الحذف؟\")'>حذف</a> ";
        echo "<a href='edit.php?id=" . $row['id'] . "' class='edit'>تعديل</a> ";
        echo "<a href='add_pdf.php?id=" . $row['id'] . "' class='add-pdf'> PDF</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "لا توجد بيانات لعرضها.";
}

$conn->close();
?>
