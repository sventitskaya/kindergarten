<div class="tab-panel" data-tab="lessons">
    <div class="group-tabs page-table-container">
        <ul class="tab-list">
            <?php if(isset($groups)) foreach ($groups as $group) : ?>
                <li class="tab"
                    data-group-id="<?php echo $group['group_id']; ?>"
                    data-tab="lessons-tab-<?php echo $group['group_id']; ?>">
                    <?php echo $group['group_name']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if(isset($groups) && isset($conn) && isset($isAdmin) && isset($isTeacher)) foreach ($groups as $group) : ?>
            <div class="group-content tab-panel"
                 data-group-id="<?php echo $group['group_id']; ?>"
                 data-tab="lessons-tab-<?php echo $group['group_id']; ?>">
                <?php
                // Получаем список занятий для текущей группы
                if ($isTeacher) {
                    $getLessonsQuery = "SELECT l.lesson_id, 
                                            l.lesson_name, 
                                            l.start_datetime,
                                            l.end_datetime,
                                            l.teacher_id, 
                                            CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) as teacher_name,
                                            r.group_id
                                        FROM Lessons l
                                        INNER JOIN LessonGroupRelation r ON l.lesson_id = r.lesson_id
                                        LEFT JOIN Users u ON l.teacher_id = u.user_id
                                        WHERE r.group_id = :group_id and l.teacher_id = :user_id";
                    $stmt = $conn->prepare($getLessonsQuery);
                    $stmt->bindParam(':group_id', $group['group_id']);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();
                    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $getLessonsQuery = "SELECT l.lesson_id, 
                                            l.lesson_name, 
                                            l.start_datetime,
                                            l.end_datetime,
                                            l.teacher_id, 
                                            CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) as teacher_name,
                                            r.group_id
                                        FROM Lessons l
                                        INNER JOIN LessonGroupRelation r ON l.lesson_id = r.lesson_id
                                        LEFT JOIN Users u ON l.teacher_id = u.user_id
                                        WHERE r.group_id = :group_id";
                    $stmt = $conn->prepare($getLessonsQuery);
                    $stmt->bindParam(':group_id', $group['group_id']);
                    $stmt->execute();
                    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }


                if (count($lessons) > 0) {
                    // Если есть занятия, отображаем таблицу
                    echo '<div class="page-table-container">';
                    echo '<table class="page-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Название</th>';
                    echo '<th>Начало</th>';
                    echo '<th>Окончание</th>';
                    echo '<th>Учитель/Воспитатель</th>';
                    if ($isAdmin) {
                        echo '<th>Действия</th>';
                    }
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    foreach ($lessons as $lesson) {
                        $lessonId = $lesson['lesson_id'];

                        $getLessonGroupsQuery = "SELECT group_id FROM LessonGroupRelation WHERE lesson_id = :lesson_id";
                        $stmt = $conn->prepare($getLessonGroupsQuery);
                        $stmt->bindParam(':lesson_id', $lessonId);
                        $stmt->execute();
                        $groupsLessons = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        $lessonGroups[$lessonId] = $groupsLessons;
                    }
                    $lessonGroupsStrings = array();
                    if (isset($lessonGroups)) foreach ($lessonGroups as $lessonId => $groupsLessons) {
                        $lessonGroupsString = implode(',', $groupsLessons);
                        $lessonGroupsStrings[$lessonId] = $lessonGroupsString;
                    }

                    foreach ($lessons as $lesson) {
                        echo '<tr>';
                        echo '<td>' . $lesson['lesson_name'] . '</td>';
                        echo '<td>' . date("d.m.Y H:i", strtotime($lesson['start_datetime'])) . '</td>';
                        echo '<td>' . date("d.m.Y H:i", strtotime($lesson['end_datetime'])) . '</td>';
                        echo '<td>' . $lesson['teacher_name'] . '</td>';
                        if ($isAdmin) {
                            echo '<td>';
                            echo '<div class="button-row">';
                            echo '<button class="edit-lesson"';
                            echo 'data-lesson-id="' . $lesson['lesson_id'] . '"';
                            echo 'data-lesson-name="' . $lesson['lesson_name'] . '"';
                            echo 'data-lesson-start="' . $lesson['start_datetime'] . '"';
                            echo 'data-lesson-end="' . $lesson['end_datetime'] . '"';
                            echo 'data-lesson-teacher-id="' . $lesson['teacher_id'] . '"';
                            echo 'data-lesson-groups="' . $lessonGroupsStrings[$lesson['lesson_id']] . '">';
                            echo 'Изменить';
                            echo '</button>';
                            echo '<button class="delete-lesson"';
                            echo 'data-lesson-id="' . $lesson['lesson_id'] . '">';
                            echo 'Удалить';
                            echo '</button>';
                            echo '</div>';
                            echo '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    // Если у группы нет занятий, выводим сообщение
                    echo "<p>Нет доступных занятий для этой группы.</p>";
                }
                ?>
            </div>
        <?php endforeach; ?>
        <?php include 'lesson-modal.php'; ?>
        <a id="add-lesson">Добавить занятие</a>
        <script src="../../scripts/lessons.js" type="text/javascript"></script>
    </div>
</div>