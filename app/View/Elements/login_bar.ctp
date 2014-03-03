<script>
//some translations
var __unfinished="<?php echo __("Unfinished")?>";
var __done="<?php echo __("Done")?>";

</script>

<h1 class="fleft">
    <?php
    $homepagelink = $this->Session->read('Auth.User.is_admin') ? array('controller' => 'users', 'action' => 'index') : "/";
    echo $this->Html->link(
            'Flowing Hours', $homepagelink, array('class' => 'marginLR10'));
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