<?php 
include "../view/main.php";

function t() {
?>
    <div id="list" class="pure-u-1">
        <div class="pure-g">
            <div class="pure-u-1-6">
            </div>
            <div class="pure-u-2-3">
                <div class="block">
                    <div class="post inner-block main-post">
                        <div class="post-avatar">
                            <img class="email-avatar" src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>
                    <form class="pure-form write-twirp answer-twirp inner-block">
                        <fieldset>
                            <textarea name="twirp" rows="1"></textarea>
                            <button type="submit" class="pure-button pure-button-primary">Respond</button>
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

                    <div class="thread-separator"></div>

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

                    <div class="thread-separator"></div>                    

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
            <div class="pure-u-1-6">
            </div>            
        </div>
    </div>
<?php
}

main_template(t);
?>
