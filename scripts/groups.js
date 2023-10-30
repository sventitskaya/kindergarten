// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const editGroups = document.querySelectorAll('.edit-group');
// Открывает диалоговое окно при клике на кнопку "Изменить"
editGroups.forEach(button => {
    button.addEventListener('click', (event) => {
        const groupId = event.target.getAttribute('data-group-id');
        const groupName = event.target.getAttribute('data-group-name');
        const educatorName = event.target.getAttribute('data-group-educator-id');
        console.log(educatorName);

        // Заполните поля формы в диалоговом окне
        document.getElementById('groupId').value = groupId;
        document.getElementById('groupName').value = groupName;
        document.getElementById('educatorName').value = educatorName;

        // Открывает диалоговое окно
        document.getElementById('groupModal').style.display = 'flex';
        document.getElementById('groupModalTitle').innerHTML = 'Редактировать группу';
        document.getElementById('groupForm').action = 'services/process-edit-group.php';
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const deleteGroups = document.querySelectorAll('.delete-group');
deleteGroups.forEach(button => {
    button.addEventListener('click', (event) => {
        const groupId = event.target.getAttribute('data-group-id');
        const a = document.createElement('a');
        a.id = 'remove-group';
        a.href = `services/process-delete-group.php?group_id=${groupId}`;
        a.click();
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const confirmDeleteGroups = document.querySelectorAll('.confirm-delete-group');
confirmDeleteGroups.forEach(button => {
    button.addEventListener('click', () => {
        // Откройте модальное окно подтверждения удаления
        document.getElementById('deleteGroupModal').style.display = 'flex';

        document.getElementById('cancelDeleteGroupButton').addEventListener('click', () => {
            document.getElementById('deleteGroupModal').style.display = 'none';
        })
    });
});

document.getElementById('add-group').addEventListener('click', () => {
    // Открывает диалоговое окно
    document.getElementById('groupModal').style.display = 'flex';

    document.getElementById('groupModalTitle').innerHTML = 'Добавить группу';
    document.getElementById('groupForm').action = 'services/process-add-group.php';

    document.getElementById('groupId').value = null;
    document.getElementById('groupName').value = null;
    document.getElementById('educatorName').value = null;
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeGroupModal').addEventListener('click', () => {
    document.getElementById('groupModal').style.display = 'none';
});

document.getElementById('closeDeleteGroupModal').addEventListener('click',  () => {
    document.getElementById('deleteGroupModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('groupModal')) {
        document.getElementById('groupModal').style.display = 'none';
    }

    if (event.target === document.getElementById('deleteGroupModal')) {
        document.getElementById('deleteGroupModal').style.display = 'none';
    }
});