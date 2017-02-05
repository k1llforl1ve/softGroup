<div class="container">
    <div class="col-sm-8">
        <div class="panel panel-white post panel-shadow">
            <? if (isset($_SESSION['userId']) && $_SESSION['userId'] != 0): ?>
            <div class="post-heading">
                <div class="pull-left image">
                    <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar"
                         alt="user profile image">
                </div>
                <div class="pull-left meta">
                    <div class="title h5">
                        <a href="#"><b><? print_r($_SESSION['user']['login']) ?></b></a>
                        made a post.
                    </div>
                    <a href="<?php echo SITE_URL; ?>login/logout">Logout</a>
                </div>
            </div>
            <div class="post-description">
                <p>Це ваш тестовий користувач.</p>
                <div class="stats">
                    <a href="#" class="btn btn-default stat-item">
                        <i class="fa fa-thumbs-up icon"></i>2
                    </a>
                    <a href="#" class="btn btn-default stat-item">
                        <i class="fa fa-share icon"></i><?= $data['commentscount'] ?>
                    </a>
                </div>
            </div>
            <? endif;?>
            <div class="post-footer">
                <!-- TODO: Внутрь контроллера вывод интупа или формы входа-->
                <? if (isset($_SESSION['userId']) && $_SESSION['userId'] != 0): ?>
                    <div class="input-group">
                        <input class="form-control" placeholder="Add a comment" type="text">
                        <span class="input-group-addon">
                            <a href="#"><i class="fa fa-edit"></i></a>
                        </span>
                    </div>
                <? else: ?>
                    <h3>Будь ласка, увійдіть для того, щоб залишати коментарі!</h3>
                    <form action="login/login">
                        <div class="form-group">
                            <label for="usr">Логін:</label>
                            <input type="text" name="user"required class="form-control" id="usr">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Пароль:</label>
                            <input type="password" name="password" required class="form-control" id="pwd">
                        </div>
                        <button type="submit" class="btn btn-default">Увійти</button>
                    </form>
                <? endif; ?>
                <ul class="comments-list">
                    <!-- TODO: передать под функцию шаблонизации -->
                    <? foreach ($data['output'] as $item): ?>
                        <li class="comment">
                            <a class="pull-left" href="#">
                                <img class="avatar" src="http://bootdey.com/img/Content/user_1.jpg" alt="avatar">
                            </a>
                            <div class="comment-body">
                                <div class="comment-heading">
                                    <h4 class="user"><?= htmlspecialchars($item['parent']) ?></h4>
                                    <h5 class="time"><?= strftime("%d %h %H:%M", $item['createdon']) ?></h5>

                                </div>
                                <p><?= htmlspecialchars($item['body']) ?></p>

                            </div>
                        </li>

                    <? endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
