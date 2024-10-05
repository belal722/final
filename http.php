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
            background-image: url(Sky.jpg);
            background-size: cover;
        }

        h2 {
            text-align: center; /* محاذاة العنوان إلى المنتصف */
            color: #333; /* لون رمادي غامق */
            margin-bottom: 20px; /* مسافة تحت العنوان */
        }

        form {
            background-color: white; /* خلفية بيضاء للنموذج */
            padding: 20px;
            border-radius: 10px; /* زوايا مستديرة */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* ظل */
            width: 300px; /* عرض النموذج */
        }

        input[type="text"], input[type="file"], input[type="submit"] {
            width: 100%; /* عرض كامل */
            padding: 10px;
            margin: 10px 0; /* مسافة من الأعلى والأسفل */
            border: 1px solid #ddd; /* حد رمادي */
            border-radius: 5px; /* زوايا مستديرة */
            box-sizing: border-box; /* لضمان عدم تجاوز الحشوة */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* لون خلفية الزر */
            color: white; /* لون النص */
            cursor: pointer; /* شكل المؤشر */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* لون الخلفية عند التمرير */
        }

        a {
            display: block; /* جعل الرابط كتلة */
            text-align: center; /* محاذاة إلى المنتصف */
            /* margin-top: 20px; مسافة علوية */
            color: #FFFFFF; /* لون أزرق */
            background-color: black;
            text-decoration: none; /* إزالة الخط */
        }

        a:hover {
            text-decoration: underline; /* إضافة خط تحت عند التمرير */
        }

        .footer {
            margin-top: auto; /* دفع الرابط إلى الأسفل */
            margin-bottom: 20px; /* مسافة تحت الرابط */
        }
    </style>
</head>
<body>

<h2>رفع البيانات</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    اسم الشركة: <input type="text" name="client_name" required><br>
    اسم الشخص: <input type="text" name="person_name" required><br>
    رقم الهاتف: <input type="text" name="phone" required><br>
    ملفات PDF: <input type="file" name="pdf_files[]" multiple required><br>
    <input type="submit" name="submit" value="رفع">
</form>


<div class="footer">
    <a href="index.php">عرض البيانات</a>
</div>

</body>
</html>
