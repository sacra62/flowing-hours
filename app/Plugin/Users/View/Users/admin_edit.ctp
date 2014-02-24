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
				echo $this->Form->input('id');
				echo $this->Form->input('username', array(
					'label' => __d('users', 'Username')));
                                echo $this->Form->input('first_name', array(
					'label' => __d('users', 'First Name')));
                                echo $this->Form->input('last_name', array(
					'label' => __d('users', 'Last Name')));
				echo $this->Form->input('email', array(
					'label' => __d('users', 'Email')));
                if (!empty($roles)) {
                    echo $this->Form->input('role', array(
                        'label' => __d('users', 'Role'), 'values' => $roles));
                }
                echo $this->Form->input('is_admin', array(
                        'label' => __d('users', 'Is Admin')));
                    echo $this->Form->input('active', array(
                        'label' => __d('users', 'Active')));
			?>
		</fieldset>
	<?php echo $this->Form->end('Submit'); ?>
</div>
<?php //@abrar for admin show admin sidebar?> <?php  if($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar');  ?> <?php else: echo $this->element('Users.Users/sidebar');?> <?php endif; ?>