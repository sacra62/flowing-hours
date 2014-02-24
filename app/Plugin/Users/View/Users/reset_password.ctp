<div class="users form">
<h2><?php echo __d('users', 'Reset your password'); ?></h2>
<?php
	echo $this->Form->create($model, array(
		'url' => array(
			'action' => 'reset_password',
			$token)));
	echo $this->Form->input('new_password', array(
		'label' => __d('users', 'New Password'),
		'type' => 'password'));
	echo $this->Form->input('confirm_password', array(
		'label' => __d('users', 'Confirm'),
		'type' => 'password'));
	echo $this->Form->submit(__d('users', 'Submit'));
	echo $this->Form->end();
?>
</div>
<?php //@abrar for admin show admin sidebar?> <?php  if($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar');  ?> <?php else: echo $this->element('Users.Users/sidebar');?> <?php endif; ?>