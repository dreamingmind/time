<div class="projects view">
<h2><?php  echo __('Project'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($project['Project']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client'); ?></dt>
		<dd>
			<?php echo $this->Html->link($project['Client']['name'], array('controller' => 'clients', 'action' => 'view', $project['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($project['Project']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Note'); ?></dt>
		<dd>
			<?php echo h($project['Project']['note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($project['Project']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($project['Project']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Project'), array('action' => 'edit', $project['Project']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Project'), array('action' => 'delete', $project['Project']['id']), null, __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Times'), array('controller' => 'times', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time'), array('controller' => 'times', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Times'); ?></h3>
	<?php if (!empty($project['Time'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
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
		foreach ($project['Time'] as $time): ?>
		<tr>
			<td><?php echo $time['id']; ?></td>
			<td><?php echo $time['created']; ?></td>
			<td><?php echo $time['modified']; ?></td>
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
