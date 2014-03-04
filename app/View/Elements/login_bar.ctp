

<h1 class="fleft">
    <?php
    $homepagelink = $this->Session->read('Auth.User.is_admin') ? array('controller' => 'users', 'action' => 'index') : FULL_BASE_URL . $this->webroot;
    echo '<a href="'.$homepagelink.'" class="marginLR10"><img src="'.FULL_BASE_URL . $this->webroot.'img/logo.png"/>';
    ?></h1>

<div class="fleft"><?php
    $ses_lang = $this->Session->read('Config.language') == "fi" ? "en" : "fi";
    echo $this->Html->link(
            __("LANGUAGE_CODE"), "?lang=" . $ses_lang, array('class' => 'marginLR10'));
    ?></div>
<div class="fright">
    <?php
    if (isset($user['User'])) {
        echo "(" . __("HELLO") . " " . $user['User']['first_name'] . " " . $user['User']['last_name'] . ')';
        echo $this->Html->link(
                __("MY_PROFILE"), array('controller' => "users", 'action' => 'edit', $this->Session->read('Auth.User.id')), array('class' => 'marginLR10'));
        echo $this->Html->link(
                __("LOGOUT"), "/users/logout", array('class' => 'marginLR10'), __("LOGOUT_QUESTION")
        );
    }
    ?>
</div>