// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const editChildren = document.querySelectorAll('.edit-child');

editChildren.forEach(button => {
    button.addEventListener('click', (event) => {
        const childId = event.target.getAttribute('data-child-id');
        const childFirstName = event.target.getAttribute('data-child-first-name');
        const childMiddleName = event.target.getAttribute('data-child-middle-name');
        const childLastName = event.target.getAttribute('data-child-last-name');
        const childBirthDate = event.target.getAttribute('data-child-birth-date');
        const childGroupId = event.target.getAttribute('data-child-group-id');

        // Заполните поля формы в диалоговом окне
        document.getElementById('childId').value = childId;
        document.getElementById('childFirstName').value = childFirstName;
        document.getElementById('childMiddleName').value = childMiddleName;
        document.getElementById('childLastName').value = childLastName;
        document.getElementById('childBirthDate').value = childBirthDate;
        document.getElementById('childGroupId').value = childGroupId;

        // Открывает диалоговое окно
        document.getElementById('childModal').style.display = 'flex';
        document.getElementById('childGroup').removeAttribute('hidden');
        document.getElementById('childGender').setAttribute('hidden', 'true');
        document.getElementById('childGroupId').setAttribute('required', 'true');
        document.getElementById('childModalTitle').innerHTML = 'Редактировать ребенка';
        document.getElementById('childForm').action = 'services/process-edit-child.php';

        const maleRadio = document.querySelector('input[name="gender"][value="Мужской"]');
        const femaleRadio = document.querySelector('input[name="gender"][value="Женский"]');

        maleRadio.removeAttribute('required');
        femaleRadio.removeAttribute('required');
    });
});

document.getElementById('add-child').addEventListener('click', () => {
    // Открывает диалоговое окно
    document.getElementById('childModal').style.display = 'flex';

    document.getElementById('childModalTitle').innerHTML = 'Добавить ребенка';
    document.getElementById('childForm').action = 'services/process-add-child.php';
    document.getElementById('childGender').removeAttribute('hidden');
    document.getElementById('childGroup').setAttribute('hidden', 'true');
    document.getElementById('childGroupId').removeAttribute('required');
    document.getElementById('childId').value = null;
    document.getElementById('childFirstName').value = null;
    document.getElementById('childMiddleName').value = null;
    document.getElementById('childLastName').value = null;
    document.getElementById('childBirthDate').value = null;
    document.getElementById('childGroupId').value = null;
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('childModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('childModal')) {
        document.getElementById('childModal').style.display = 'none';
    }
});