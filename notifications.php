<?php 
include "view/main.php";

function t() {
?>
    <div id="list" class="pure-u-1">
        <div class="pure-g">
            <div class="pure-u-1-6">
            </div>
            <div class="pure-u-2-3">
                <div class="block">
                    <div class="inner-block notification fav">
                        <div class="notification-content">LSN liked a twirp you wrote</div>
                        <div class="notification-users"><img src="images/avatar.jpg" width="32px" height="32px" alt="LSN"/></div>
                    </div>
                    <div class="inner-block notification fav">
                        <div class="notification-content">LSN liked a twirp you wrote</div>
                        <div class="notification-users"><img src="images/avatar.jpg" width="32px" height="32px" alt="LSN"/></div>
                    </div>
                    <div class="inner-block notification mention post">
                        <div class="post-avatar">
                            <img class="email-avatar" src="/images/avatar.jpg" height="64" width="64">
                        </div>

                        <div class="post-content">
                            <div class="post-author">John Doe</div>
                            <div class="message">@IkeAntalpeet Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.</div>
                        </div>
                    </div>
                    <div class="inner-block notification fav">
                        <div class="notification-content">LSN liked a twirp you wrote</div>
                        <div class="notification-users"><img src="images/avatar.jpg" width="32px" height="32px" alt="LSN"/></div>
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
