<div class="tab-panel" data-tab="approvals">
    <?php if (!empty($requests)) : ?>
        <div class="group-tabs page-table-container">
            <table class="page-table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td><?php echo $request['full_name']; ?></td>
                        <td><?php echo $request['status']; ?></td>
                        <td>
                            <form method="post">
                                <div class="button-row" style="flex-wrap: nowrap">
                                    <input type="submit" name="confirm_<?php echo $request['username']; ?>"
                                           value="Подтвердить">
                                    <input type="submit" name="cancel_<?php echo $request['username']; ?>"
                                           value="Отклонить">
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>Нет ожидающих запросов на регистрацию.</p>
    <?php endif; ?>
</div>
