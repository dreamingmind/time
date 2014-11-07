<div class="times view">
<h5><?php  echo __('Time'); ?></h5>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($time['Time']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time In'); ?></dt>
		<dd>
			<?php echo h($time['Time']['time_in']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time Out'); ?></dt>
		<dd>
			<?php echo h($time['Time']['time_out']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity'); ?></dt>
		<dd>
			<?php echo h($time['Time']['activity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo h($time['Time']['user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo h($time['Time']['project']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
