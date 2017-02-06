<? foreach ($data['output'] as $item): ?>
    <li class="comment" data-user-id="<?= $item['createdby']?>" data-comment-id="<?= $item['id'] ?>">
        <div class="av-rating">Середній рейтинг коментаря:<? Comments::getAvgStars($item['id'])?></div>
        <a class="pull-left" href="#">
            <img class="avatar" src="http://bootdey.com/img/Content/user_1.jpg" alt="avatar">
        </a>
        <div class="comment-body">
            <div class="comment-heading">
                <h4 class="user"><?= htmlspecialchars($item['createdby_name']) ?></h4>
                <h5 class="time"><?= strftime("%d %h %H:%M", $item['createdon']) ?></h5>
                <p><?= htmlspecialchars($item['body']) ?></p>
            </div>

            <div class="spec form-group dis-none">
                <textarea  class="form-control" rows="3" class="newvalue"> <?= htmlspecialchars($item['body']) ?></textarea>

                <div class="button-save">
                    <button type="button" name="btn-cancel" class="btn">Отмена</button>
                    <button type="button" name="btn-save"   class="btn btn-primary">Сохранить</button>
                </div>
            </div>

        <? if (isset($_SESSION['userId']) && $item['createdby'] != $_SESSION['userId']): ?>

            <div class="row lead">
                <div id="stars" data-rating='<? Comments::getStars($item['id'])?>'class="starrr"></div>

            </div>
         <? endif; ?>
        </div>

        <? if (isset($_SESSION['userId']) && $item['createdby'] == $_SESSION['userId']): ?>
            <div class="function">
                <div class="edit">edit</div>
                <div class="delete">delete</div>
            </div>
        <? endif; ?>
    </li>

<? endforeach; ?>