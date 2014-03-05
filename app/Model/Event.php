<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 */
class Event extends AppModel {

	public $actsAs = array('WebSocket.Publishable' => 
		array('fields' => array('name', 'status_date', 'status_code', 'status_progress')));

}
