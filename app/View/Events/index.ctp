<?php
var current_url = "<?php echo $this->here; ?>";
$websocket = new WebSocket(array('port' => 8081, 'scheme' => 'ws'));

if($websocket->connect()) {

    $data = $websocket->read();
    $payload = json_decode(substr($data['payload'], 4));
    $payload = $payload->args[0]->dat;
    if (isset($payload[0])): ?>
    	<script>
    	var data = $.parseJSON('<?php echo json_encode($payload); ?>');
    	if (app_path.indexOf('page:') != -1) {
	    var page = current_url[current_url.length-1];
	    // page-1 + 10 are the indices we want
	    // change the data variable to hold only those indices
	    	
	} else {
	   // else change the data variable to only contain the first 10
	}
    	var eventsList = "";
    	// loop over the data obj like normal and create the table
	$.each(data,function(index,events){
	    eventsList += "<tr>\n"
	    eventsList += "\t<td>" + events.name + "&nbsp;</td>\n";
	    eventsList += "\t<td>" + events.scheduled_date = "&nbsp;</td>\n";
	    eventsList += "</tr>\n";
	});
	if (eventsList !== "") {
	    $('tbody').html(eventsList);
	}    
    	</script>

 <? endif; 
}
?>

	<h2><?php echo __('Events'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('scheduled_date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<tbody>
	<?php foreach ($events as $event): ?>
		<tr>
			<td><?php echo h($event['Event']['name']); ?>&nbsp;</td>
			<td><?php echo h($event['Event']['scheduled_date']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('action' => 'view', $event['Event']['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $event['Event']['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>


