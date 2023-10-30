// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const editLessons = document.querySelectorAll('.edit-lesson');
// Открывает диалоговое окно при клике на кнопку "Изменить"
editLessons.forEach(button => {
    button.addEventListener('click', (event) => {
        const lessonId = event.target.getAttribute('data-lesson-id');
        const lessonName = event.target.getAttribute('data-lesson-name');
        const startDatetime = event.target.getAttribute('data-lesson-start');
        const endDatetime = event.target.getAttribute('data-lesson-end');
        const teacherName = event.target.getAttribute('data-lesson-teacher-id');
        const groupIds = event.target.getAttribute('data-lesson-groups').split(',');

        // Заполните поля формы в диалоговом окне
        document.getElementById('lessonId').value = lessonId;
        document.getElementById('lessonName').value = lessonName;
        document.getElementById('startDatetime').value = startDatetime;
        document.getElementById('endDatetime').value = endDatetime;
        document.getElementById('teacherName').value = teacherName;

        const checkboxes = document.querySelectorAll('.options input[type="checkbox"]');
        for (const checkbox of checkboxes) {
            checkbox.checked = groupIds.includes(checkbox.value);
        }

        // Открывает диалоговое окно
        document.getElementById('lessonModal').style.display = 'flex';
        document.getElementById('lessonModalTitle').innerHTML = 'Редактировать занятие';
        document.getElementById('lessonForm').action = 'services/process-edit-lesson.php';
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const deleteLessons = document.querySelectorAll('.delete-lesson');
deleteLessons.forEach(button => {
    button.addEventListener('click', (event) => {
        const lessonId = event.target.getAttribute('data-lesson-id');
        const a = document.createElement('a');
        a.id = 'remove-lesson';
        a.href = `services/process-delete-lesson.php?lesson_id=${lessonId}`;
        a.click();
    });
});

document.getElementById('add-lesson').addEventListener('click', () => {
    // Открывает диалоговое окно
    document.getElementById('lessonModal').style.display = 'flex';

    document.getElementById('lessonModalTitle').innerHTML = 'Добавить занятие';
    document.getElementById('lessonForm').action = 'services/process-add-lesson.php';

    const checkboxes = document.querySelectorAll('.options input[type="checkbox"]');
    for (const checkbox of checkboxes) {
        checkbox.checked = false;
    }
    document.getElementById('lessonId').value = null;
    document.getElementById('lessonName').value = null;
    document.getElementById('startDatetime').value = null;
    document.getElementById('endDatetime').value = null;
    document.getElementById('teacherName').value = null;
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('lessonModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('lessonModal')) {
        document.getElementById('lessonModal').style.display = 'none';
    }
});