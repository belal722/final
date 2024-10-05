<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة البيانات</title>
    <link rel="stylesheet" href="css/style.css"> <!-- ربط ملف CSS -->
    <style>
    body {
        background-image: url(img.jpeg);
        background-size: cover;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #F2F2F269;
    }
    tr:nth-child(even) {
        background-color: #F9F9F93E;
    }

    a {
        text-decoration: none;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        margin-right: 5px;
        font-weight: bold;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    a:hover {
        opacity: 0.8;
    }
    a.delete {
        background-color: #ff5252;
    }
    a.edit {
        background-color: #007bff;
    }
    a.pdf {
        color: #007bff;
        padding: 5px;
        border-radius: 3px;
        transition: background-color 0.3s;
    }
    a.pdf:hover {
        background-color: #e7f1ff;
    }
    a.delete:hover {
        background-color: #ff1a1a;
    }
    a.edit:hover {
        background-color: #0056b3;
    }
    .home-link {
        text-align: center;
        margin-top: 20px;
    }
    .home-link a {
        color: black;
        font-weight: bold;
    }
    .message {
        text-align: center;
        margin-top: 20px;
        color: green;
        display: <?php echo isset($message) && $message ? 'block' : 'none'; ?>;
    }
    .add-pdf {
        background-color: #4CAF50;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    .add-pdf:hover {
        background-color: #45a049;
    }
    .search-box {
        margin-top: 20px;
        text-align: center;
    }
    .search-box input[type="text"] {
        padding: 8px;
        width: 300px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    </style>
</head>
<body>

<div class="home-link">
    <a href="http.php">الصفحة الرئيسية</a>
</div>

<?php
$message = ""; // Initialize the message variable

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "name_9");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// معالجة طلب الحذف
if (isset($_GET['delete'])) {
    $id_to_delete = intval($_GET['delete']); // تحويل القيمة إلى عدد صحيح لتجنب SQL Injection
    $delete_query = "DELETE FROM products WHERE id = $id_to_delete";

    if ($conn->query($delete_query) === TRUE) {
        $message = "تم حذف السجل بنجاح.";
    } else {
        $message = "حدث خطأ أثناء حذف السجل: " . $conn->error;
    }
}

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    // عرض النتائج هنا فقط إذا لم يكن الطلب من AJAX
?>
<!-- نموذج البحث -->
<div class="search-box">
    <input type="text" id="search-input" placeholder="ابحث عن اسم الشركة أو الشخص">
</div>

<!-- عرض الرسالة -->
<div class="message"><?php echo $message; ?></div>

<!-- منطقة عرض النتائج -->
<div id="results">
<?php
}

// البحث في قاعدة البيانات
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// استعلام البيانات مع دعم البحث
$sql = "SELECT * FROM products WHERE client_name LIKE '%$search_query%' OR person_name LIKE '%$search_query%' ORDER BY id DESC";
$result = $conn->query($sql);

// منطقة عرض النتائج
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

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    // إغلاق div الخاص بـ النتائج
    ?>
    </div>
    <?php
}
?>

<script>
// استخدام AJAX للبحث الفوري عند الكتابة
document.getElementById('search-input').addEventListener('input', function() {
    var searchQuery = this.value;

    // إنشاء طلب AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '?search=' + encodeURIComponent(searchQuery), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // تحديث النتائج
            document.getElementById('results').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>

</body>
</html>
