<div id="groupModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeGroupModal">&times;</span>
        <h2 id="groupModalTitle"></h2>
        <form id="groupForm" method="post" action="">
            <label for="groupName">Название:</label>
            <input type="text" name="groupName" id="groupName" required>
            <br>

            <label for="educatorName">Воспитатель:</label>
            <select id="educatorName" name="educatorName" required>
                <?php if (isset($educators)) foreach ($educators as $educator) : ?>
                    <option value="<?php echo $educator['user_id']; ?>" <?php if (isset($group) && $educator['user_id'] == $group['educator_id']) echo 'selected'; ?>><?php echo $educator['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <input type="hidden" name="groupId" id="groupId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>