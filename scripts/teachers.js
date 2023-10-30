// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const editTeachers = document.querySelectorAll('.edit-teacher');
// Открывает диалоговое окно при клике на кнопку "Изменить"
editTeachers.forEach(button => {
    button.addEventListener('click', (event) => {
        const teacherId = event.target.getAttribute('data-teacher-id');
        const teacherFirstName = event.target.getAttribute('data-teacher-first-name');
        const teacherMiddleName = event.target.getAttribute('data-teacher-middle-name');
        const teacherLastName = event.target.getAttribute('data-teacher-last-name');
        const teacherAddress = event.target.getAttribute('data-teacher-address');
        const teacherPhone = event.target.getAttribute('data-teacher-phone');

        // Заполните поля формы в диалоговом окне
        document.getElementById('teacherId').value = teacherId;
        document.getElementById('teacherFirstName').value = teacherFirstName;
        document.getElementById('teacherMiddleName').value = teacherMiddleName;
        document.getElementById('teacherLastName').value = teacherLastName;
        document.getElementById('teacherAddress').value = teacherAddress;
        document.getElementById('teacherPhone').value = teacherPhone;

        // Открывает диалоговое окно
        document.getElementById('teacherModal').style.display = 'flex';
        document.getElementById('teacherModalTitle').innerHTML = 'Редактировать учителя';
        document.getElementById('teacherForm').action = 'services/process-edit-teacher.php';
        document.getElementById('teacherCredentials').setAttribute('hidden', 'true');
        document.getElementById('teacherUsername').removeAttribute('required');
        document.getElementById('teacherPassword').removeAttribute('required');
        document.getElementById('teacherEmail').removeAttribute('required');
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const deleteTeachers = document.querySelectorAll('.delete-teacher');
deleteTeachers.forEach(button => {
    button.addEventListener('click', (event) => {
        const teacherId = event.target.getAttribute('data-teacher-id');
        const a = document.createElement('a');
        a.id = 'remove-teacher';
        a.href = `services/process-delete-teacher.php?teacher_id=${teacherId}`;
        a.click();
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const confirmDeleteTeachers = document.querySelectorAll('.confirm-delete-teacher');
confirmDeleteTeachers.forEach(button => {
    button.addEventListener('click', () => {
        // Откройте модальное окно подтверждения удаления
        document.getElementById('deleteTeacherModal').style.display = 'flex';

        document.getElementById('cancelDeleteTeacherButton').addEventListener('click', () => {
            document.getElementById('deleteTeacherModal').style.display = 'none';
        })
    });
});

document.getElementById('add-teacher').addEventListener('click', () => {
    // Открывает диалоговое окно
    document.getElementById('teacherModal').style.display = 'flex';

    document.getElementById('teacherModalTitle').innerHTML = 'Добавить учителя';
    document.getElementById('teacherForm').action = 'services/process-add-teacher.php';

    document.getElementById('teacherId').value = null;
    document.getElementById('teacherFirstName').value = null;
    document.getElementById('teacherMiddleName').value = null;
    document.getElementById('teacherLastName').value = null;
    document.getElementById('teacherAddress').value = null;
    document.getElementById('teacherPhone').value = null;
    document.getElementById('teacherCredentials').removeAttribute('hidden');
    document.getElementById('teacherUsername').setAttribute('required', 'true');
    document.getElementById('teacherPassword').setAttribute('required', 'true');
    document.getElementById('teacherEmail').setAttribute('required', 'true');
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeTeacherModal').addEventListener('click', () => {
    document.getElementById('teacherModal').style.display = 'none';
});

document.getElementById('closeDeleteTeacherModal').addEventListener('click', () => {
    document.getElementById('deleteTeacherModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('teacherModal')) {
        document.getElementById('teacherModal').style.display = 'none';
    }

    if (event.target === document.getElementById('deleteTeacherModal')) {
        document.getElementById('deleteTeacherModal').style.display = 'none';
    }
});