<?php
// Kiểm tra xem form có được gửi qua POST hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
    $hobbies = isset($_POST['hobby']) ? $_POST['hobby'] : [];
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';
    
    // Validate dữ liệu
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username không được để trống";
    }
    
    if (empty($password)) {
        $errors[] = "Password không được để trống";
    }
    
    if ($age < 0 || $age > 100) {
        $errors[] = "Tuổi phải trong khoảng từ 0 đến 100";
    }
    
    if (empty($hobbies)) {
        $errors[] = "Vui lòng chọn ít nhất một sở thích";
    }
    
    if (empty($country)) {
        $errors[] = "Vui lòng chọn quốc gia";
    }
    
} else {
    // Nếu không phải POST request, chuyển hướng về trang chủ
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <?php if (!empty($errors)): ?>
            <!-- Hiển thị lỗi -->
            <div class="alert alert-danger shadow mt-5 border-0" role="alert">
                <h2 class="text-danger mb-3">
                    <i class="bi bi-exclamation-triangle"></i> Có lỗi xảy ra!
                </h2>
                <ul class="list-unstyled">
                    <?php foreach ($errors as $error): ?>
                        <li class="text-danger mb-2">
                            <i class="bi bi-x-circle"></i> <?php echo $error; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <hr>
                <a href="index.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Quay lại form
                </a>
            </div>
        <?php else: ?>
            <!-- Hiển thị thông tin đã nhập -->
            <div class="card shadow mt-4 border-0">
                <div class="card-header bg-light">
                    <h3 class="text-center mb-0">Thông tin bạn đã nhập</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="mb-3 p-3 bg-light rounded border">
                                <div class="row">
                                    <div class="col-4 fw-bold">Username:</div>
                                    <div class="col-8 text-primary"><?php echo $username; ?></div>
                                </div>
                            </div>
                            
                            <div class="mb-3 p-3 bg-light rounded border">
                                <div class="row">
                                    <div class="col-4 fw-bold">Tuổi:</div>
                                    <div class="col-8 text-info"><?php echo $age; ?> tuổi</div>
                                </div>
                            </div>
                            
                            <div class="mb-3 p-3 bg-light rounded border">
                                <div class="row">
                                    <div class="col-4 fw-bold">Sở thích:</div>
                                    <div class="col-8">
                                        <?php if (!empty($hobbies)): ?>
                                            <?php foreach ($hobbies as $hobby): ?>
                                                <span class="badge bg-success me-2"><?php echo htmlspecialchars($hobby); ?></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 p-3 bg-light rounded border">
                                <div class="row">
                                    <div class="col-4 fw-bold">Quốc gia:</div>
                                    <div class="col-8 text-warning fw-bold"><?php echo $country; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-left"></i> Quay lại form
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto redirect sau 10 giây nếu có lỗi
        <?php if (!empty($errors)): ?>
        setTimeout(function() {
            if (confirm('Tự động chuyển về trang chủ sau 10 giây. Bạn có muốn ở lại trang này không?')) {
                // Người dùng chọn ở lại
            } else {
                window.location.href = 'index.php';
            }
        }, 10000);
        <?php endif; ?>
    </script>
</body>
</html>