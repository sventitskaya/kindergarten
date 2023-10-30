<div id="childModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2 id="childModalTitle"></h2>
        <form id="childForm" method="post" action="">
            <!-- Здесь добавьте поля для редактирования информации о ребенке, например: -->
            <label for="childFirstName">Имя:</label>
            <input type="text" name="childFirstName" id="childFirstName" required>
            <br>

            <label for="childMiddleName">Отчество:</label>
            <input type="text" name="childMiddleName" id="childMiddleName" required>
            <br>

            <label for="childLastName">Фамилия:</label>
            <input type="text" name="childLastName" id="childLastName" required>
            <br>

            <label for="childBirthDate">Дата рождения:</label>
            <input type="date" name="childBirthDate" id="childBirthDate" required>
            <br>

            <div id="childGender" hidden>
                <label for="gender">Пол:</label>
                <input type="radio" id="gender" name="gender" value="Мужской" required> Мужской
                <input type="radio" id="gender" name="gender" value="Женский" required> Женский
                <br>
            </div>

            <div id="childGroup" hidden>
                <label for="childGroupId">Группа:</label>
                <select id="childGroupId" name="childGroupId" required>
                    <?php if (isset($groups) && isset($child)) foreach ($groups as $group) : ?>
                        <option value="<?php echo $group['group_id']; ?>" <?php if ($group['group_id'] == $child['child_group_id']) echo 'selected'; ?>><?php echo $group['group_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
            </div>

            <input type="hidden" name="childId" id="childId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>