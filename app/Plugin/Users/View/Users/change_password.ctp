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
<h2><?php echo __('CHANGE_PASSWORD'); ?></h2>
<p><?php echo __('Please enter your old password because of security reasons and then your new password twice.'); ?></p>
	<?php
		echo $this->Form->create($model, array('action' => 'change_password'));
		echo $this->Form->input('old_password', array(
			'label' => __('Old Password'),
			'type' => 'password'));
		echo $this->Form->input('new_password', array(
			'label' => __('New Password'),
			'type' => 'password'));
		echo $this->Form->input('confirm_password', array(
			'label' => __('CONFIRM_PASS_AGAIN'),
			'type' => 'password'));
		echo $this->Form->end(__('SUBMIT'));
	?>
</div>
<?php //@abrar for admin show admin sidebar?> <?php  if($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar');  ?> <?php else: echo $this->element('Users.Users/sidebar');?> <?php endif; ?>