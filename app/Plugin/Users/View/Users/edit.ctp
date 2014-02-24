<?php
/**
 * Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="users form">
    <?php echo $this->Form->create($model); ?>
    <fieldset>
        <legend><?php echo __d('users', 'Edit User'); ?></legend>
        <?php
//				echo $this->Form->input('UserDetail.first_name');
        //we decided to put first name and last name into users table and not userdetail table
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('email');
        ?>
        <p>
            <?php echo $this->Html->link(__d('users', 'Change your password'), array('action' => 'change_password')); ?>
        </p>
    </fieldset>
    <?php echo $this->Form->end(__d('users', 'Submit')); ?>
</div>
<?php //@abrar for admin show admin sidebar?> <?php if ($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar'); ?> <?php else: echo $this->element('Users.Users/sidebar'); ?> <?php endif; ?>