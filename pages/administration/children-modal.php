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

            <label for="children[]">Выберите детей:</label>
            <div class="custom-select">
                <div class="options">
                    <?php if (isset($freeChildren)) foreach ($freeChildren as $child) : ?>
                        <label>
                            <input type="checkbox" name="children[]" value="<?php echo $child['child_id']; ?>">
                            <?php echo $child['full_name']; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>