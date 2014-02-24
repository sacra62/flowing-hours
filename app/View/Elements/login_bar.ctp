<h1 class="fleft">
    <?php
    echo $this->Html->link(
            'Flowing Hours', '/', array('class' => 'marginLR10'));
    ?></h1>

<div class="fleft"><?php
    $ses_lang = $this->Session->read('Config.language') == "fi" ? "en" : "fi";
    echo $this->Html->link(
            __("LANGUAGE_CODE"), array('controller' => 'pages', 'action' => 'display', "?" => array("lang" => $ses_lang)), array('class' => 'marginLR10'));
    ?></div>
<div class="fright">
    <?php
    if (isset($user['User'])) {
        echo "(" .__("HELLO")." ". $user['User']['first_name'] . " " . $user['User']['last_name'] . ')';
        echo $this->Html->link(
                __("MY_PROFILE"), array('controller' => 'users', 'action' => 'index'), array('class' => 'marginLR10'));
        echo $this->Html->link(
                __("LOGOUT"), "/users/logout", array('class' => 'marginLR10'), __("LOGOUT_QUESTION")
        );
    }
    ?>
</div>