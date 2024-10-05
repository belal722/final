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
            display: none;
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

        .search-container {
            margin-top: 20px;
            text-align: center;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

    </style>

    <script>
        // دالة AJAX للبحث الفوري
        function searchRecords(query) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // تحديث الجدول بالنتائج
                    document.getElementById("results").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search.php?search=" + encodeURIComponent(query), true);
            xhttp.send();
        }

        // استدعاء البحث عند تحميل الصفحة لعرض كل البيانات
        window.onload = function() {
            searchRecords('');
        };
    </script>
</head>
<body>

<!-- مربع البحث -->
<div class="search-container">
    <input type="text" onkeyup="searchRecords(this.value)" placeholder="ابحث هنا...">
</div>

<!-- مكان عرض النتائج -->
<div id="results">
    <!-- سيتم هنا عرض نتائج البحث -->
</div>

<!-- رابط إلى الصفحة الرئيسية -->
<div class="home-link">
    <a href="http.php">الصفحة الرئيسية</a>
</div>

<!-- رسالة التأكيد -->
<div class="message" id="message"><?php echo $message; ?></div>

<script>
    var message = "<?php echo $message; ?>";
    if (message) {
        var messageDiv = document.getElementById("message");
        messageDiv.style.display = "block";
        setTimeout(function() {
            messageDiv.style.display = "none";
        }, 3000);
    }
</script>

</body>
</html>
