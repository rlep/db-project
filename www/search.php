<?php 
include "../view/main.php";

main_template(function() {
?>
    <div id="list" class="pure-u-1">
        <div class="pure-g">
            <div class="pure-u-1-6 pure-menu search-options">
                <ul class="pure-menu-list">
                      <li class="pure-menu-item pure-menu-selected"><a href="#" class="pure-menu-link">Users</a></li>
                      <li class="pure-menu-item"><a href="#" class="pure-menu-link">Twirps</a></li>
                  </ul>
            </div>
            <div class="pure-u-5-6">
                <div class="block">
                    <form class="pure-form write-twirp inner-block">
                        <fieldset>
                            <textarea name="twirp" rows="1" placeholder="'Sup ?"></textarea>
                            <button type="submit" class="pure-button pure-button-primary">Twirp</button>
                        </fieldset>
                    </form>

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
