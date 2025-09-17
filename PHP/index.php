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
    <div class="container mt-5">
        <div class="row">
            <!-- Form bên trái -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <form id="registrationForm" action="process.php" method="POST">
                            <!-- Username -->
                            <div class="mb-3 row">
                                <label for="username" class="col-sm-3 col-form-label fw-bold">Username:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-3 col-form-label fw-bold">Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>

                            <!-- Age Slider -->
                            <div class="mb-3 row">
                                <label for="age" class="col-sm-3 col-form-label fw-bold">Age:</label>
                                <div class="col-sm-9">
                                    <div class="position-relative my-4">
                                        <div class="position-absolute bg-primary text-white px-2 py-1 rounded fw-bold" 
                                             style="top: -40px; left: 50%; transform: translateX(-50%); font-size: 14px;" 
                                             id="ageTooltip">18</div>
                                        <input type="range" class="form-range border border-dark border-2" 
                                               id="age" name="age" min="0" max="100" value="18" 
                                               oninput="updateAgeValue(this.value)" 
                                               onmousemove="updateAgeValue(this.value)">
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="fw-bold text-dark">0</small>
                                            <small class="fw-bold text-dark">100</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hobby Checkboxes -->
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Hobby:</label>
                                <div class="col-sm-9">
                                    <div class="border border-2 p-3 rounded bg-light">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sport" name="hobby[]" value="Thể thao">
                                            <label class="form-check-label fw-semibold" for="sport">Thể thao</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="music" name="hobby[]" value="Âm nhạc">
                                            <label class="form-check-label fw-semibold" for="music">Âm nhạc</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="art" name="hobby[]" value="Nghệ thuật">
                                            <label class="form-check-label fw-semibold" for="art">Nghệ thuật</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Country Dropdown -->
                            <div class="mb-3 row">
                                <label for="country" class="col-sm-3 col-form-label fw-bold">Country:</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="country" name="country" required>
                                        <option value="">Chọn quốc gia...</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Buttons bên phải -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <button type="submit" form="registrationForm" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Submit
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" onclick="clearForm()">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Cập nhật giá trị age khi slider thay đổi - Tốc độ đồng bộ cao
        function updateAgeValue(value) {
            const ageTooltip = document.getElementById('ageTooltip');
            const slider = document.getElementById('age');
            
            // Cập nhật giá trị hiển thị
            ageTooltip.textContent = value;
            
            // Tính toán vị trí chính xác và nhanh chóng
            const rect = slider.getBoundingClientRect();
            const sliderWidth = rect.width;
            const min = parseInt(slider.min);
            const max = parseInt(slider.max);
            const percentage = (value - min) / (max - min);
            
            // Tính toán vị trí với độ chính xác cao
            const thumbPosition = percentage * sliderWidth;
            
            // Áp dụng vị trí ngay lập tức (không có transition để tránh delay)
            ageTooltip.style.left = thumbPosition + 'px';
        }

        // Load danh sách quốc gia từ API
        async function loadCountries() {
            try {
                const response = await fetch('https://restcountries.com/v3.1/all?fields=name');
                const countries = await response.json();
                
                const countrySelect = document.getElementById('country');
                
                // Sắp xếp các quốc gia theo thứ tự alphabet
                countries.sort((a, b) => a.name.common.localeCompare(b.name.common));
                
                // Thêm các option vào select
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    countrySelect.appendChild(option);
                });
                
            } catch (error) {
                console.error('Lỗi khi tải danh sách quốc gia:', error);
                // Fallback: thêm một số quốc gia phổ biến
                const fallbackCountries = [
                    'Vietnam', 'United States', 'Japan', 'South Korea', 'China', 
                    'Thailand', 'Singapore', 'Malaysia', 'Indonesia', 'Philippines',
                    'Australia', 'Canada', 'United Kingdom', 'France', 'Germany',
                    'Italy', 'Spain', 'Brazil', 'Mexico', 'India'
                ];
                
                const countrySelect = document.getElementById('country');
                fallbackCountries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country;
                    option.textContent = country;
                    countrySelect.appendChild(option);
                });
            }
        }

        // Khởi tạo vị trí ban đầu
        document.addEventListener('DOMContentLoaded', function() {
            // Load danh sách quốc gia
            loadCountries();
            
            // Đợi một chút để DOM render hoàn tất
            setTimeout(() => {
                updateAgeValue(18);
            }, 50);
        });

        // Cập nhật lại vị trí khi resize window
        window.addEventListener('resize', function() {
            const slider = document.getElementById('age');
            updateAgeValue(slider.value);
        });

        // Xóa sạch form
        function clearForm() {
            document.getElementById('registrationForm').reset();
            document.getElementById('age').value = '18';
            updateAgeValue(18);
        }

        // Xác nhận trước khi submit
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const hobbies = document.querySelectorAll('input[name="hobby[]"]:checked');
            if (hobbies.length === 0) {
                e.preventDefault();
                alert('Vui lòng chọn ít nhất một sở thích!');
                return false;
            }
            
            if (confirm('Bạn có chắc chắn muốn gửi form này không?')) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>