<?php
session_start();
require_once('_conn.php'); // تأكد من وجود ملف الاتصال

if (isset($_POST['delete'])) {
    $product_id = intval($_POST['product_id']); // تأكد من أن ID هو عدد صحيح

    // حذف المنتج من قاعدة البيانات
    $st = $db->prepare("DELETE FROM products WHERE id = ?");
    if ($st->execute([$product_id])) {
        echo 'success'; // أرسل رسالة النجاح
        exit;
    } else {
        echo 'error'; // أرسل رسالة الفشل
        exit;
    }
}

// تنظيف المدخلات
$name = htmlspecialchars(trim($_POST['name']));
$car_number = htmlspecialchars(trim($_POST['number']));

// التحقق من امتدادات الملفات
$img_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
$pdf_ext = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);

// السماح فقط بأنواع معينة من الملفات
$allowed_img_ext = ['jpg', 'jpeg', 'png'];
$allowed_pdf_ext = ['pdf'];

if (!in_array($img_ext, $allowed_img_ext)) {
    echo "صيغة الصورة غير مدعومة.";
    exit;
}

if (!in_array($pdf_ext, $allowed_pdf_ext)) {
    echo "صيغة ملف PDF غير مدعومة.";
    exit;
}

// إنشاء أسماء ملفات فريدة
$img_name = $name . time() . '.' . $img_ext; // اسم الصورة
$pdf_name = $name . time() . '.pdf'; // اسم PDF

// مسارات حفظ الملفات
$p_photo = 'image/' . $img_name; // المسار للصورة
$p_pdf = 'pdf/' . $pdf_name; // المسار لملف PDF

// رفع الملفات
if (move_uploaded_file($_FILES['photo']['tmp_name'], $p_photo) && move_uploaded_file($_FILES['pdf']['tmp_name'], $p_pdf)) {
    // إدخال البيانات في قاعدة البيانات
    $st = $db->prepare("INSERT INTO products (name, car_number, img, pdf) VALUES (?, ?, ?, ?)");
    
    // تخزين المسارات في قاعدة البيانات
    if ($st->execute([$name, $car_number, $img_name, $pdf_name])) {
        $_SESSION['msg'] = ["success", "تم إضافة العنصر بنجاح"];
        header("Location: create_car.php?msg=success");
    } else {
        $_SESSION['msg'] = ["error", "عذرًا! لم نتمكن من إضافة العنصر. الرجاء الاتصال بالمشرف."];
        header("Location: create_car.php?msg=error");
    }
} else {
    echo "فشل في رفع الملفات.";
    print_r($_FILES); // طباعة معلومات الملفات إذا فشل الرفع
    exit;
}



?>
