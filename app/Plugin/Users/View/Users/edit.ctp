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
        <legend><?php echo __('Edit User'); ?></legend>
        <?php
//				echo $this->Form->input('UserDetail.first_name');
        //we decided to put first name and last name into users table and not userdetail table
        echo $this->Form->input('first_name', array(
					'label' => __('First Name'),
					'error' => array('isValid' => __('Must be a valid name'))));
				echo $this->Form->input('last_name', array(
					'label' => __('Last Name')));
			echo $this->Form->input('email', array(
				'label' => __('E-mail (used as login)'),
				'error' => array('isValid' => __('Must be a valid email address'),
				'isUnique' => __('An account with that email already exists'))));
        ?>
        <p>
            <?php echo $this->Html->link(__("CHANGE_PASSWORD"), array('action' => 'change_password')); ?>
        </p>
    </fieldset>
    <?php echo $this->Form->end(__('SUBMIT')); ?>
</div>
<?php //@abrar for admin show admin sidebar?> <?php if ($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar'); ?> <?php else: echo $this->element('Users.Users/sidebar'); ?> <?php endif; ?>