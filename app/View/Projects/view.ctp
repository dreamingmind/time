<div class="projects view">
<h5><?php  echo __('Project'); ?></h5>
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
	</dl>
</div>
<div class="related">
	<h6><?php echo __('Related Times'); ?></h6>
	<?php if (!empty($project['Time'])): ?>
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
		foreach ($project['Time'] as $time): ?>
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
