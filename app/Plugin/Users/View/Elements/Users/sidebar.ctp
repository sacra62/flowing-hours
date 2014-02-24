<div class="actions">
	<ul>
		<?php if (!$this->Session->read('Auth.User.id')) : ?>
			<li><?php echo $this->Html->link(__d('users', 'Login'), array('action' => 'login')); ?></li>
            <?php if (!empty($allowRegistration) && $allowRegistration)  : ?>
			<li><?php echo $this->Html->link(__d('users', 'Register an account'), array('action' => 'add')); ?></li>
            <?php endif; ?>
		<?php else : ?>
			<li><?php echo $this->Html->link(__d('users', 'My Account'), array('action' => 'edit',$this->Session->read('Auth.User.id')));?>
			<li><?php echo $this->Html->link(__d('users', 'Change password'), array('action' => 'change_password')); ?>
		<?php endif ?>
		
	</ul>
</div>
