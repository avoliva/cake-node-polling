
<?php
$websocket = new WebSocket(array('port' => 8081, 'scheme' => 'ws', 'persistent' => true));
if($websocket->connect()) {

	$data = $websocket->read(65535);
	// print_r($data);
	$payload = json_decode(substr($data['payload'], 4));
	// var_dump($payload);
	$payload = $payload->args[0]->dat;
	 debug($websocket->emit('notification'));
	if (isset($payload[0])): ?>
		<script src="http://localhost:8081/socket.io/socket.io.js"></script>
		<script>
		var socket = io.connect('http://localhost:8081');
        // on message received we print all the data inside the #container div
        socket.on('notification', function (data) {
			var current_url = "<?php echo $this->here; ?>";
			var data = data;
			console.log(data.dat[0]);
			var newArray = [];
			var limit= 5;
			if (current_url.indexOf('page:') != -1) {
				var page = current_url[current_url.length-1] - 1;
				// page is 2
				// we want 6-10
				// page is 1 once subtracted
				// page * limit
				//--
				//page is 1
				// page + 5 is 6; 
				for (var i = page*limit; i < (page*limit+5); ++i) {
					if (data.dat[i] === void 0) break;
					newArray.push(data.dat[i]);
				}
				// console.log(newArray);
				// page-1 + 10 are the indices we want
				// change the data variable to hold only those indices
				
			} else {
				for (var i = 0; i < limit; ++i) {
					if (data.dat[i] === void 0) break;
					newArray.push(data.dat[i]);
				}
			
				// else change the data variable to only contain the first 10
			}
			var eventsList = "";
				// loop over the data obj like normal and create the table
			$.each(newArray,function(index,events){
				console.log
				eventsList += "<tr>\n"
				eventsList += "\t<td>" + events.name + "&nbsp;</td>\n";
				eventsList += "\t<td>" + events.scheduled_date + "&nbsp;</td>\n";
				eventsList += "</tr>\n";
			});
			if (eventsList !== "") {
				// console.log(eventsList);
				// console.log('made it');
				$('.real').html(eventsList);
			}    
		})
		</script>

 <? endif; 
}
?>

	<h2><?php echo __('Events'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('scheduled_date'); ?></th>
	</tr>
	<tbody class="real">
	<?php foreach ($events as $event): ?>
		<tr>
			<td><?php echo h($event['Event']['name']); ?>&nbsp;</td>
			<td><?php echo h($event['Event']['scheduled_date']); ?>&nbsp;</td>
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


