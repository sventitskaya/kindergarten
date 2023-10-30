<div id="childrenGroupModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeChildrenGroupModal">&times;</span>
        <h2 id="childrenGroupModalTitle"></h2>
        <form id="childrenGroupForm" method="post" action="">
            <label for="childrenGroupName">Название группы:</label>
            <select id="childrenGroupName" name="childrenGroupName" required>
                <?php if (isset($groups)) foreach ($groups as $group) : ?>
                    <option value="<?php echo $group['group_id']; ?>"><?php echo $group['group_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <input type="hidden" name="childId" id="childId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>