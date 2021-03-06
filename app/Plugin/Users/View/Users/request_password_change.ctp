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
<h2><?php echo __('Forgot your password?'); ?></h2>
<p><?php echo __('Please enter the email you used for registration and you\'ll get an email with further instructions.'); ?></p>
<?php
	echo $this->Form->create($model, array(
		'url' => array(
			'admin' => false,
			'action' => 'reset_password')));
	echo $this->Form->input('email', array(
		'label' => __('Your Email')));
	echo $this->Form->submit(__('SUBMIT'));
	echo $this->Form->end();
?>
</div>
<?php //@abrar for admin show admin sidebar?> <?php  if($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar');  ?> <?php else: echo $this->element('Users.Users/sidebar');?> <?php endif; ?>