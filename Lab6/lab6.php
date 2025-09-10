<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
<?php
function khaibao($id, $hoten, $tuoi, $hsl){
        return array(
                'id'=> $id,
                'hoten'=> $hoten,
                'tuoi'=> $tuoi,
                'hsl'=> $hsl
        );
}
function taothongtin($id, $hoten, $tuoi, $hsl){
        return khaibao($id, $hoten, $tuoi, $hsl);
}
function taothongtins(){
        return [
                taothongtin("nv01","Le Van Nam",20,2),
                taothongtin("nv02","Le Van Nu",20,2),
                taothongtin("nv03","Ho Thi Binh",20,2.1),
                taothongtin("nv04","Nguyen Van A",21,2.3),
                taothongtin("nv05","Tran Thi B",22,2.2)
        ];
}
$NhanVien = taothongtins();
?>

<script>
const nhanVienData = <?php echo json_encode($NhanVien, JSON_UNESCAPED_UNICODE); ?>;
</script>

<div class="container">
    <div class="row mb-3">
        <div class="col-3 d-flex align-items-center">
            <button id="reloadBtn" class="btn btn-dark">Load lại bảng</button>
        </div>
        <div class="col-6 text-center">
            <button id="colorEvenOddBtn" class="btn btn-secondary me-2">Tô màu chẵn/lẻ</button>
            <button id="colorRandomBtn" class="btn btn-primary me-2">Tô màu ngẫu nhiên</button>
        </div>
    </div>
    <div id="tableContainer"></div>
</div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






