// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const removeGroupChildren = document.querySelectorAll('.remove-group-children');
removeGroupChildren.forEach(button => {
    button.addEventListener('click', (event) => {
        const childId = event.target.getAttribute('data-child-id');
        const a = document.createElement('a');
        a.id = 'remove-child';
        a.href = `../administration/services/process-deassign-group.php?child_id=${childId}`;
        a.click();
    });
});

document.getElementById('add-children-to-group').addEventListener('click', () => {
    // Открывает диалоговое окно
    document.getElementById('childrenGroupModal').style.display = 'flex';

    document.getElementById('childrenGroupModalTitle').innerHTML = 'Добавить детей в группу';
    document.getElementById('childrenGroupForm').action = '../administration/services/process-assign-group.php';

    const checkboxes = document.querySelectorAll('.options input[type="checkbox"]');
    for (const checkbox of checkboxes) {
        checkbox.checked = false;
    }
    document.getElementById('childrenGroupName').value = null;
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeChildrenGroupModal').addEventListener('click', () => {
    document.getElementById('childrenGroupModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('childrenGroupModal')) {
        document.getElementById('childrenGroupModal').style.display = 'none';
    }
});