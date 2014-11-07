<div class="users view">
<h5><?php  echo __('User'); ?></h5>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h6><?php echo __('Actions'); ?></h6>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Times'), array('controller' => 'times', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time'), array('controller' => 'times', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h6><?php echo __('Related Times'); ?></h6>
	<?php if (!empty($user['Time'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Project Id'); ?></th>
		<th><?php echo __('Time In'); ?></th>
		<th><?php echo __('Time Out'); ?></th>
		<th><?php echo __('Activity'); ?></th>
		<th><?php echo __('User'); ?></th>
		<th><?php echo __('Project'); ?></th>
		<th><?php echo __('Duration'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Time'] as $time): ?>
		<tr>
			<td><?php echo $time['id']; ?></td>
			<td><?php echo $time['user_id']; ?></td>
			<td><?php echo $time['project_id']; ?></td>
			<td><?php echo $time['time_in']; ?></td>
			<td><?php echo $time['time_out']; ?></td>
			<td><?php echo $time['activity']; ?></td>
			<td><?php echo $time['user']; ?></td>
			<td><?php echo $time['project']; ?></td>
			<td><?php echo $time['duration']; ?></td>
			<td><?php echo $time['group_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'times', 'action' => 'view', $time['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'times', 'action' => 'edit', $time['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'times', 'action' => 'delete', $time['id']), null, __('Are you sure you want to delete # %s?', $time['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Time'), array('controller' => 'times', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
