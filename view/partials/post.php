<?php
namespace View\Partials\Post;

function post($post) {
?>
                    <div class="post inner-block">
                        <div class="post-avatar">
                            <a href="user.php?username=<?php echo $post->author->username?>">
                                <img class="email-avatar" src="<?php echo $post->author->avatar; ?>" height="64" width="64">
                            </a>
                        </div>

                        <div class="post-content">
                            <div class="post-author">
                                <a class="link-author" href="user.php?username=<?php echo $post->author->username?>">
                                    <?php echo $post->author->name; ?> (<?php echo $post->author->username; ?>)
                                </a>
                            </div>
                            <a class="link-post" href="post.php?id=<?php echo $post->id; ?>">
                                <div class="text"><?php echo $post->text; ?></div>
                            </a>
                        </div>

                    </div>
<?php
}
?>
