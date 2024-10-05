<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "name_9");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// التحقق من وجود id في الطلب
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // تحويل id إلى عدد صحيح
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    // التحقق من وجود السجل
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("السجل غير موجود.");
    }
}

// رسالة التأكيد
$message = "";

// التحقق من طلب التحديث
if (isset($_POST['submit'])) {
    $client_name = $_POST['client_name'];
    $person_name = $_POST['person_name'];
    $phone = $_POST['phone'];
    
    // مصفوفة لتخزين أسماء الملفات
    $uploaded_files = explode(',', $row['pdf_file']); // استرجاع الملفات الحالية

    // حرك كل ملف إلى المجلد المناسب
    foreach ($_FILES['pdf_files']['tmp_name'] as $key => $tmp_name) {
        $pdf_file = $_FILES['pdf_files']['name'][$key];
        move_uploaded_file($tmp_name, 'uploads/' . $pdf_file);
        $uploaded_files[] = $pdf_file; // إضافة اسم الملف إلى المصفوفة
    }

    // تحويل مصفوفة الملفات إلى سلسلة نصية مفصولة بفواصل
    $pdf_files_string = implode(',', $uploaded_files);

    // استعلام التحديث
    $sql = "UPDATE products SET client_name='$client_name', person_name='$person_name', phone='$phone', pdf_file='$pdf_files_string' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "تم تحديث السجل بنجاح!";
    } else {
        $message = "حدث خطأ أثناء تحديث السجل: " . $conn->error;
    }
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل البيانات</title>
    <style>
        /* أسلوب التنسيق كما في الصفحات السابقة */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* خلفية رمادية فاتحة */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* جعل العناصر في عمود */
            justify-content: center; /* محاذاة عمودي */
            align-items: center; /* محاذاة أفقي */
            height: 100vh; /* ارتفاع الصفحة */
        }

        form {
            background-color: white; /* خلفية بيضاء */
            padding: 20px; /* حشوة داخلية */
            border-radius: 5px; /* زوايا مستديرة */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* تأثير الظل */
            width: 300px; /* عرض محدد */
        }

        input[type="text"],
        input[type="file"] {
            width: 100%; /* عرض كامل */
            padding: 10px; /* حشوة داخلية */
            margin: 10px 0; /* هوامش عمودية */
            border: 1px solid #ccc; /* إطار رمادي */
            border-radius: 4px; /* زوايا مستديرة */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* لون أخضر */
            color: white; /* نص أبيض */
            padding: 10px; /* حشوة داخلية */
            border: none; /* لا إطار */
            border-radius: 4px; /* زوايا مستديرة */
            cursor: pointer; /* شكل المؤشر */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* لون أغمق عند المرور */
        }

        h1 {
            color: #333; /* لون نص رمادي داكن */
        }

        .home-link {
            margin-top: 20px; /* المسافة العلوية */
        }

        .home-link a {
            color: #4CAF50; /* لون أخضر */
            font-weight: bold; /* جعل النص غامق */
        }

        .message {
            color: green; /* لون النص */
            margin-bottom: 20px; /* المسافة السفلية */
        }
    </style>
</head>
<body>

<h1>تعديل البيانات</h1>

<div class="message"><?php echo $message; ?></div>

<form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    اسم الشركة: <input type="text" name="client_name" value="<?php echo htmlspecialchars($row['client_name']); ?>" required>
    اسم الشخص: <input type="text" name="person_name" value="<?php echo htmlspecialchars($row['person_name']); ?>" required>
    رقم الهاتف: <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
    
    <!-- إضافة حقل لرفع ملفات PDF جديدة -->
    إضافة ملفات PDF جديدة: <input type="file" name="pdf_files[]" multiple>

    <input type="submit" name="submit" value="تحديث">
</form>

<!-- رابط إلى الصفحة الرئيسية -->
<div class="home-link">
    <a href="http.php">الصفحة الرئيسية</a>
</div>

</body>
</html>
