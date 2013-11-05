    <?php
        if (isset($user['User'])) {
            echo "(Hello " . $user['User']['username'] . ')';
            echo $this->Html->link(
                    'My Profile', array('controller' => 'users', 'action' => 'index'), array('class' => 'marginLR10'));
            echo $this->Html->link(
                    'Logout', array('controller' => 'users', 'action' => 'logout', 6), array('class' => 'marginLR10'), "Are you sure you want to logout?"
            );
        } else {
//            echo $this->Html->link(
//                    'Login', array('controller' => 'users', 'action' => 'login'));
        }
    ?>
