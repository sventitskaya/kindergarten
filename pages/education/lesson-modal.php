<div id="lessonModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2 id="lessonModalTitle"></h2>
        <form id="lessonForm" method="post" action="">
            <label for="lessonName">Название:</label>
            <input type="text" name="lessonName" id="lessonName" required>
            <br>

            <label for="startDatetime">Дата и время начала:</label>
            <input type="datetime-local" name="startDatetime" id="startDatetime" required>
            <br>

            <label for="endDatetime">Дата и время окончания:</label>
            <input type="datetime-local" name="endDatetime" id="endDatetime" required>
            <br>

            <label for="selectedGroups[]">Выберите группы:</label>
            <div class="custom-select">
                <div class="options">
                    <?php if (isset($groups)) foreach ($groups as $group) : ?>
                        <label>
                            <input type="checkbox" name="selectedGroups[]" value="<?php echo $group['group_id']; ?>">
                            <?php echo $group['group_name']; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (isset($isAdmin) && $isAdmin) : ?>
                <div>
                    <label for="teacherName">Учитель/Воспитатель:</label>
                    <select id="teacherName" name="teacherName" required>
                        <?php if (isset($teachers)) foreach ($teachers as $teacher) : ?>
                            <option value="<?php echo $teacher['user_id']; ?>" <?php if (isset($lesson) && $teacher['user_id'] == $lesson['teacher_id']) echo 'selected'; ?>><?php echo $teacher['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                </div>
            <?php else : ?>
                <input type="hidden" id="teacherName" name="teacherName">
            <?php endif; ?>

            <input type="hidden" name="lessonId" id="lessonId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>