<div class="container">
    <div class="col-sm-8">
        <div class="panel panel-white post panel-shadow">
            <div class="post-heading">
                <div class="pull-left image">
                    <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar"
                         alt="user profile image">
                </div>
                <div class="pull-left meta">
                    <div class="title h5">
                        <a href="#"><b>TEST AUTHOR</b></a>
                        made a post.
                    </div>
                    <h6 class="text-muted time">1 minute ago</h6>
                </div>
            </div>
            <div class="post-description">
                <p>test text for SoftGroup task</p>
                <div class="stats">
                    <a href="#" class="btn btn-default stat-item">
                        <i class="fa fa-thumbs-up icon"></i>2
                    </a>
                    <a href="#" class="btn btn-default stat-item">
                        <i class="fa fa-share icon"></i><?= $data['commentscount'] ?>
                    </a>
                </div>
            </div>
            <div class="post-footer">
                <div class="input-group">
                    <input class="form-control" placeholder="Add a comment" type="text">
                    <span class="input-group-addon">
                        <a href="#"><i class="fa fa-edit"></i></a>
                    </span>
                </div>

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
                                    <h5 class="time"><?= strftime("%d %h %H:%M", $item['createdon'])?></h5>

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
