<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "name_9");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// رسالة التأكيد
$message = "";

// الحصول على ID السجل لتحديثه
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // الحصول على ID السجل
} else {
    die("ID السجل غير موجود.");
}

// استعلام للحصول على البيانات الخاصة بالسجل
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

// التحقق من وجود السجل
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc(); // الحصول على البيانات
} else {
    die("السجل غير موجود. تأكد من أن ID صحيح في قاعدة البيانات.");
}

// التحقق من طلب الإدخال
if (isset($_POST['submit'])) {
    $pdf_file = $_FILES['pdf_file']['name'];

    // حرك الملف إلى المجلد المناسب
    move_uploaded_file($_FILES['pdf_file']['tmp_name'], 'uploads/' . $pdf_file);

    // استعلام الإدخال
    $sql = "UPDATE products SET pdf_file = CONCAT_WS(',', pdf_file, '$pdf_file') WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $message = "تم إضافة ملف PDF بنجاح!";
    } else {
        $message = "حدث خطأ أثناء إضافة ملف PDF: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            background-image: url(img.jpeg);
            background-size: cover;
        }
        h2 {
            color: #333;
        }
        .form-container {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin: 15px 0;
            color: #d9534f;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>إضافة ملف PDF جديد</h2>
    <form action="add_pdf.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- ID السجل -->
        <div class="form-group">
            <label for="pdf_file">ملف PDF:</label>
            <input type="file" name="pdf_file" required>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="رفع">
        </div>
    </form>

    <!-- رسالة التأكيد -->
    <div class="message"><?php echo $message; ?></div>
</div>

<div class="footer">
    <a href="index.php">العودة إلى عرض البيانات</a>
</div>

</body>
</html>
