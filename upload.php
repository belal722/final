<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفع البيانات</title>
    <style>
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

        /* تنسيق النص */
        h1 {
            color: #333; /* لون نص رمادي داكن */
        }

        /* رابط الصفحة الرئيسية */
        .home-link {
            margin-top: 20px; /* المسافة العلوية */
        }

        .home-link a {
            color: #4CAF50; /* لون أخضر */
            font-weight: bold; /* جعل النص غامق */
        }
    </style>
</head>
<body>

<h1>رفع البيانات</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    اسم الشركة: <input type="text" name="client_name" required>
    اسم الشخص: <input type="text" name="person_name" required>
    رقم الهاتف: <input type="text" name="phone" required>
    ملفات PDF: <input type="file" name="pdf_files[]" multiple required>
    <input type="submit" name="submit" value="رفع">
</form>

<!-- رابط إلى الصفحة الرئيسية -->
<div class="home-link">
    <a href="http.php">الصفحة الرئيسية</a>
</div>

</body>
</html>
