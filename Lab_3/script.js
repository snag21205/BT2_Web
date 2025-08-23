// State
let students = [];
let editingIndex = null;

// Helpers
function getFormValues() {
  const fullName = document.getElementById('fullName').value.trim();
  const dob = document.getElementById('dob').value;
  const genderInput = document.querySelector('input[name="gender"]:checked');
  const gender = genderInput ? genderInput.value : '';
  const hometown = document.getElementById('hometown').value.trim();
  return { fullName, dob, gender, hometown };
}

function setFormValues({ fullName = '', dob = '', gender = '', hometown = '' } = {}) {
  document.getElementById('fullName').value = fullName;
  document.getElementById('dob').value = dob;
  if (gender === 'Nam') {
    document.getElementById('male').checked = true;
  } else if (gender === 'Nữ') {
    document.getElementById('female').checked = true;
  } else {
    const checked = document.querySelector('input[name="gender"]:checked');
    if (checked) checked.checked = false;
  }
  document.getElementById('hometown').value = hometown;
}

function validateStudent({ fullName, dob, gender, hometown }) {
  if (!fullName || !dob || !gender || !hometown) return false;
  return true;
}

function resetForm() {
  setFormValues({});
  editingIndex = null;
  document.getElementById('updateBtn').disabled = true;
  document.getElementById('addBtn').disabled = false;
}

// CRUD operations
function addStudent() {
  const student = getFormValues();
  if (!validateStudent(student)) {
    alert('Vui lòng nhập đầy đủ thông tin.');
    return;
  }
  students.push(student);
  renderTable();
  resetForm();
}

function startEdit(index) {
  const student = students[index];
  if (!student) return;
  editingIndex = index;
  setFormValues(student);
  document.getElementById('updateBtn').disabled = false;
  document.getElementById('addBtn').disabled = true;
}

function updateStudent() {
  if (editingIndex === null) return;
  const updated = getFormValues();
  if (!validateStudent(updated)) {
    alert('Vui lòng nhập đầy đủ thông tin.');
    return;
  }
  students[editingIndex] = updated;
  renderTable();
  resetForm();
}

function deleteStudent(index) {
  if (!confirm('Bạn có chắc muốn xóa sinh viên này?')) return;
  students.splice(index, 1);
  renderTable();
  // nếu đang sửa mục đã xóa thì reset
  if (editingIndex !== null && index === editingIndex) {
    resetForm();
  }
}

// Render
function renderTable() {
  const tbody = document.getElementById('tableBody');
  tbody.innerHTML = '';
  students.forEach((s, i) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${i + 1}</td>
      <td>${s.fullName}</td>
      <td>${s.dob}</td>
      <td>${s.gender}</td>
      <td>${s.hometown}</td>
      <td>
        <button class="btn btn-sm btn-outline-primary" data-action="edit" data-index="${i}">Sửa</button>
      </td>
      <td>
        <button class="btn btn-sm btn-outline-danger" data-action="delete" data-index="${i}">Xóa</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// Event bindings
window.addEventListener('DOMContentLoaded', () => {
  document.getElementById('addBtn').addEventListener('click', addStudent);
  document.getElementById('updateBtn').addEventListener('click', updateStudent);

  // Ủy quyền sự kiện cho nút Sửa/Xóa trong bảng
  document.getElementById('tableBody').addEventListener('click', (e) => {
    const target = e.target;
    if (!(target instanceof HTMLElement)) return;
    const action = target.getAttribute('data-action');
    const indexStr = target.getAttribute('data-index');
    if (!action || indexStr === null) return;
    const index = Number(indexStr);
    if (action === 'edit') startEdit(index);
    if (action === 'delete') deleteStudent(index);
  });
});

