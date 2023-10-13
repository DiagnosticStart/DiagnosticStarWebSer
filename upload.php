<?php
// افترض أن هذا الملف يتم تضمينه في نفس المجلد الذي يحتوي على الصفحة HTML

// تحقق من وجود الملف في الطلب
if (isset($_FILES['file'])) {
    $targetDir = "uploads/"; // المجلد الذي يحتوي على الصور المحفوظة
    $targetFile = $targetDir . basename($_FILES['file']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // التحقق من أن الملف هو صورة
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES['file']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // التحقق من أن الملف غير موجود
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }

    // التحقق من حجم الملف
    if ($_FILES['file']['size'] > 500000) {
        $uploadOk = 0;
    }

    // السماح بتحميل ملفات محددة من خلال التحقق من الامتداد
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo json_encode(['status' => 'error', 'message' => 'فشل رفع الملف.']);
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            echo json_encode(['status' => 'success', 'url' => $targetFile, 'name' => basename($_FILES['file']['name'])]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء رفع الملف.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'لم يتم تلقي أي ملف.']);
}
?>
