// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const editParents = document.querySelectorAll('.edit-parent');
// Открывает диалоговое окно при клике на кнопку "Изменить"
editParents.forEach(button => {
    button.addEventListener('click', (event) => {
        const parentId = event.target.getAttribute('data-parent-id');
        const parentFirstName = event.target.getAttribute('data-parent-first-name');
        const parentMiddleName = event.target.getAttribute('data-parent-middle-name');
        const parentLastName = event.target.getAttribute('data-parent-last-name');
        const parentAddress = event.target.getAttribute('data-parent-address');
        const parentPhone = event.target.getAttribute('data-parent-phone');

        // Заполните поля формы в диалоговом окне
        document.getElementById('parentId').value = parentId;
        document.getElementById('parentFirstName').value = parentFirstName;
        document.getElementById('parentMiddleName').value = parentMiddleName;
        document.getElementById('parentLastName').value = parentLastName;
        document.getElementById('parentAddress').value = parentAddress;
        document.getElementById('parentPhone').value = parentPhone;

        // Открывает диалоговое окно
        document.getElementById('parentModal').style.display = 'flex';
        document.getElementById('parentModalTitle').innerHTML = 'Редактировать родителя';
        document.getElementById('parentForm').action = 'services/process-edit-parent.php';
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const deleteParents = document.querySelectorAll('.delete-parent');
deleteParents.forEach(button => {
    button.addEventListener('click', (event) => {
        const parentId = event.target.getAttribute('data-parent-id');
        const a = document.createElement('a');
        a.id = 'remove-parent';
        a.href = `services/process-delete-parent.php?parent_id=${parentId}`;
        a.click();
    });
});

// Найти все кнопки "Удалить" и добавить для каждой обработчик события на нажатие
const confirmDeleteParents = document.querySelectorAll('.confirm-delete-parent');
confirmDeleteParents.forEach(button => {
    button.addEventListener('click', () => {
        // Откройте модальное окно подтверждения удаления
        document.getElementById('deleteParentModal').style.display = 'flex';

        document.getElementById('cancelDeleteParentButton').addEventListener('click', () => {
            document.getElementById('deleteParentModal').style.display = 'none';
        })
    });
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeParentModal').addEventListener('click', () => {
    document.getElementById('parentModal').style.display = 'none';
});

document.getElementById('closeDeleteParentModal').addEventListener('click', () => {
    document.getElementById('deleteParentModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('parentModal')) {
        document.getElementById('parentModal').style.display = 'none';
    }

    if (event.target === document.getElementById('deleteParentModal')) {
        document.getElementById('deleteParentModal').style.display = 'none';
    }
});