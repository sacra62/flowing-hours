    <?php
        if (isset($user['User'])) {
            echo "(Hello " . $user['User']['first_name'] ." ".$user['User']['last_name']. ')';
            echo $this->Html->link(
                    'My Profile', array('controller' => 'users', 'action' => 'index'), array('class' => 'marginLR10'));
            echo $this->Html->link(
                    'Logout', "/users/logout", array('class' => 'marginLR10'), "Are you sure you want to logout?"
            );
        } else {
//            echo $this->Html->link(
//                    'Login', array('controller' => 'users', 'action' => 'login'));
        }
    ?>
