// Tạo bảng nhân viên bằng JS, thêm cột xóa, các chức năng màu, load lại

let originalData = [];
let currentData = [];
let rowColors = [];

// Lấy dữ liệu từ biến toàn cục nhanVienData (được xuất từ PHP)

function initData() {
	originalData = JSON.parse(JSON.stringify(nhanVienData));
	currentData = JSON.parse(JSON.stringify(nhanVienData));
	rowColors = Array(currentData.length).fill('');
}


function renderTable() {
	const container = document.getElementById('tableContainer');
	let html = `<h2 class="mb-3">Danh sách nhân viên</h2>`;
	html += `<table class="table table-bordered"><thead class="table-dark"><tr>
		<th>STT</th><th>ID</th><th>Họ tên</th><th>Tuổi</th><th>Hệ số lương</th><th>Xóa</th>
	</tr></thead><tbody>`;
	currentData.forEach((nv, idx) => {
		const rowClass = rowColors[idx] || '';
		html += `<tr class="${rowClass}">
			<td>${idx + 1}</td>
			<td>${nv.id}</td>
			<td>${nv.hoten}</td>
			<td>${nv.tuoi}</td>
			<td>${nv.hsl}</td>
			<td><button class="btn btn-danger btn-sm delete-row" data-idx="${idx}">Xóa</button></td>
		</tr>`;
	});
	html += `</tbody></table>`;
	container.innerHTML = html;
	// Gán sự kiện xóa dòng
	document.querySelectorAll('.delete-row').forEach(btn => {
		btn.addEventListener('click', function() {
			const idx = this.getAttribute('data-idx');
			currentData.splice(idx, 1);
			rowColors.splice(idx, 1); // Xóa màu tương ứng
			renderTable();
		});
	});
}


function colorEvenOdd() {
	const rows = document.querySelectorAll('#tableContainer tbody tr');
	rows.forEach((row, idx) => {
		const color = (idx % 2 === 0) ? 'table-light' : 'table-dark';
		row.className = color;
		rowColors[idx] = color;
	});
}


function colorRandom() {
	const colors = ['table-primary', 'table-secondary', 'table-success', 'table-danger', 'table-warning', 'table-info', 'table-light', 'table-dark'];
	const rows = document.querySelectorAll('#tableContainer tbody tr');
	rows.forEach((row, idx) => {
		const color = colors[Math.floor(Math.random() * colors.length)];
		row.className = color;
		rowColors[idx] = color;
	});
}


function reloadTable() {
	currentData = JSON.parse(JSON.stringify(originalData));
	rowColors = Array(currentData.length).fill('');
	renderTable();
}

// Sự kiện các nút
window.onload = function() {
	initData();
	renderTable();
	document.getElementById('reloadBtn').onclick = reloadTable;
	document.getElementById('colorEvenOddBtn').onclick = colorEvenOdd;
	document.getElementById('colorRandomBtn').onclick = colorRandom;
}
