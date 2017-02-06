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
                        <b><? print_r($_SESSION['user']['login']) ?></b>

                    </div>
                    <a href="<?php echo SITE_URL; ?>login/logout">Logout</a>
                </div>
            </div>
            <div class="post-description">

                <p>Це ваш тестовий користувач. Наразі такі елементи управління:</p>
                <p><span class="glyphicon glyphicon-edit"></span> - редагування коментарю(власного);</p>
                <p><span class="glyphicon glyphicon-trash"></span> - видалення(власного);</p>
                <p><span class="glyphicon glyphicon-send"></span> - відповісти.</p>
                <div class="stats">

                    <span  class="btn btn-default stat-item">
                        <i class="glyphicon glyphicon-envelope"></i>
                        <b><?= $data['commentscount'] ?></b>
                    </span>
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
                    <h3>Будь ласка, увійдіть для того, щоб залишати коментарі! </h3>
                    <h4>Юзер admin або зареєструйте нового</h4>
                    <p>Логін і пароль  для користувача admin - l: admin p: 123456 (0 привелегій)</p>

                    <form action="login/login">
                        <div class="form-group">
                            <label for="usr">Логін:</label>
                            <input type="text" name="user" required class="form-control" id="usr">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Пароль:</label>
                            <input type="password" name="password" required class="form-control" id="pwd">
                        </div>
                        <button type="submit" class="btn btn-default">Увійти</button>
                        <button type="button" onclick="location.href='<?= SITE_URL.'login/register' ?>'" class="btn btn-default">Реєстрація</button>
                    </form>
                <? endif; ?>
                <button type="button" class="refresh btn btn-info">Обновити Ленту</button>
                <ul class="comments-list">
                    <!-- TODO: передать под функцию шаблонизации -->
                    <? print_r($data['comments'])?>
                </ul>
            </div>
        </div>
    </div>
</div>
