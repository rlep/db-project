<?php 
include "../view/main.php";

main_template(function() {
?>
    <div id="list" class="pure-u-1">
        <div class="pure-g">
            <div class="pure-u-1-6">
            </div>
            <div class="pure-u-2-3">
                <div class="block">
                    <form class="inner-block pure-form pure-form-aligned">
                        <fieldset>
                            <div class="pure-control-group">
                                <label for="username">Username</label>
                                <input id="username" type="text" placeholder="Username" required>
                            </div>

                            <div class="pure-control-group">
                                <label for="name">Displayed name</label>
                                <input id="name" type="text" placeholder="Name">
                            </div>
                    
                            <div class="pure-control-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" placeholder="Password" required>
                            </div>
                    
                            <div class="pure-control-group">
                                <label for="email">Email Address</label>
                                <input id="email" type="email" placeholder="Email Address" required>
                            </div>
                    
                            <div class="pure-controls">
                                <label for="cb" class="pure-checkbox">
                                    <input id="cb" type="checkbox"> I've read the terms and conditions
                                </label>
                    
                                <button type="submit" class="pure-button pure-button-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="pure-u-1-6">
            </div>            
        </div>
    </div>
<?php
});
?>
