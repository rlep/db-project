<?php 
include "main.php";
main_template(get_defined_vars(), function($vars) {
    extract($vars);
?>
    <div id="list" class="pure-u-1">
        <div class="pure-g">
            <div class="pure-u-1-3">
                <div class="block sidebar">
                    <div class="inner-block">
                        <div class="user-badge">
                            <div class="user-head">
                            <div class="user-avatar"><img src="<?php echo $user->avatar;?>" height="64" width="64"/></div> 
                                <div class="user-name"><?php echo htmlspecialchars($user->name); ?> (<?php echo htmlspecialchars($user->username); ?>)</div>
                            </div>

                            <div class="user-infos pure-g">
                                <div class="pure-u-1-3"><?php echo $stats->nb_posts; ?> twirps</div>
                                <div class="pure-u-1-3"><?php echo $stats->nb_followers; ?> followers</div>
                                <div class="pure-u-1-3"><?php echo $stats->nb_following; ?> following</div>
                            </div>

                            <div class="user-actions">
                                <?php if ($followable) { ?>
                                <a class="pure-button" href="?username=<?php echo htmlspecialchars($user->username);?>&follow">Follow</a>
                                <?php }
                                if ($editable) { ?>
                                <a class="pure-button" href="update_profile.php">Edit profile</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pure-u-2-3">
                <div class="block">
                    <div class="post inner-block">
                        <div class="post-avatar">
                            <img src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>

                    <div class="post inner-block">
                        <div class="post-avatar">
                            <img src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>

                    <div class="post inner-block">
                        <div class="post-avatar">
                            <img class="email-avatar" src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>

                    <div class="post inner-block">
                        <div class="post-avatar">
                            <img class="email-avatar" src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>

                    <div class="post inner-block">
                        <div class="post-avatar">
                            <img class="email-avatar" src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>

                    <div class="post inner-block">
                        <div class="post-avatar">
                            <img class="email-avatar" src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>

                    <div class="innerblock end"></div>
                </div>
            </div>
        </div>
    </div>
<?php
});
?>
