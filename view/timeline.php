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
                        <h2>Trending Topics</h2>
                        <ul>
                            <li><a href="hashtag.php?h=PrimaireDroite">#PrimaireDroite</a></li>
                            <li><a href="hashtag.php?h=Fillon">#Fillon</a></li>
                            <li><a href="hashtag.php?h=ZoneTéléchargement">#ZoneTéléchargement</a></li>
                            <li><a href="hashtag.php?h=24hDeBaba">#24hDeBaba</a></li>
                            <li><a href="hashtag.php?h=UnSloganPourLaSNCF">#UnSloganPourLaSNCF</a></li>
                            <li><a href="hashtag.php?h=ACAB">#ACAB</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="pure-u-2-3">
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
