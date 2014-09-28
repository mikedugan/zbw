<?php

/*******************************************
* Tapatalk
* edit-by Tapatalk team
* www.tapatalk.com
* 2012-07
*******************************************/
$direct_install = false;

if(file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')){
	require_once(dirname(__FILE__) . '/SSI.php');
	$direct_install = true;
}
elseif (!defined('SMF'))
	die('tapatalk wasn\'t able to conect to smf');
	
//Anothers $smcFunc;
db_extend('packages');

//Hooks Integration
$hooks = array(
	'integrate_pre_include' => '$sourcedir/Subs-Tapatalk.php',
	'integrate_admin_areas' => 'Tapatalk_add_admin_areas',
);

//Loading....
foreach($hooks AS $hook => $call)
	add_integration_function($hook,$call);

//Creating columns....
$columns = array(
	'userid' => array(
		'name' => 'userid',
		'type' => 'int',
		'size' => '10',
		'default' => 0,
		'null' => false,
	),
	'announcement' => array(
		'name' => 'announcement',
		'type' => 'smallint',
		'size' => '5',
		'default' => 1,
		'null' => false,
	),
		'pm' => array(
		'name' => 'pm',
		'type' => 'smallint',
		'size' => '5',
		'default' => 1,
		'null' => false,
	),
		'subscribe' => array(
		'name' => 'subscribe',
		'type' => 'smallint',
		'size' => '5',
		'default' => 1,
		'null' => false,
	),
		'updated' => array(
		'name' => 'updated',
		'type' => 'timestamp',
		'null' => false,
	),
	);


//Creating indexes...
$indexes = array(
	'userid' => array(
		'name' => 'userid',
		'type' => 'primary',
		'columns' => array(
			'userid' => 'userid'
		),
	),
);
	
$installed = $smcFunc['db_create_table']('{db_prefix}tapatalk_users', $columns, $indexes, array(), 'update', 'ignore');

//Creating columns....
$push_columns = array(
	'pushid' => array(
		'name' => 'pushid',
		'type' => 'int',
		'auto' => 1,
		'null' => false,
	),
	'userid' => array(
		'name' => 'userid',
		'type' => 'int',
		'size' => '10',
		'default' => 0,
		'null' => false,
	),
	'type' => array(
		'name' => 'type',
		'type' => 'varchar',
		'size' => '10',
		'default' => 1,
		'null' => false,
	),
		'id' => array(
		'name' => 'id',
		'type' => 'int',
		'size' => '10',
		'default' => 1,
		'null' => false,
	),
		'subid' => array(
		'name' => 'subid',
		'type' => 'int',
		'size' => '10',
		'default' => 1,
		'null' => false,
	),
		'title' => array(
		'name' => 'title',
		'type' => 'varchar',
		'size' => '250',
		'default' => 1,
		'null' => false,
	),
			'author' => array(
		'name' => 'author',
		'type' => 'varchar',
		'size' => '100',
		'default' => 1,
		'null' => false,
	),
			'dateline' => array(
		'name' => 'dateline',
		'type' => 'int',
		'size' => '10',
		'default' => 1,
		'null' => false,
	),
			'status' => array(
		'name' => 'status',
		'type' => 'tinyint',
		'size' => '4',
		'default' => 1,
		'null' => false,
	),	
	);


//Creating indexes...
$push_indexes = array(
	'pushid' => array(
		'name' => 'pushid',
		'type' => 'primary',
		'columns' => array(
			'pushid' => 'pushid'
		),
	),
	'userid' => array(
		'name' => 'userid',
		'type' => 'index',
		'columns' => array(
			'userid' => 'userid'
		),
	),
	'dateline' => array(
		'name' => 'dateline',
		'type' => 'index',
		'columns' => array(
			'dateline' => 'dateline'
		),
	),
);
	
$installed = $smcFunc['db_create_table']('{db_prefix}tapatalk_push', $push_columns, $push_indexes, array(), 'update', 'ignore');

$smcFunc['db_query']('', '
	ALTER TABLE {db_prefix}tapatalk_users
	ADD `quote` SMALLINT( 5 ) NOT NULL DEFAULT 1 AFTER `subscribe` ,
    ADD `tag` SMALLINT( 5 ) NOT NULL DEFAULT 1 AFTER `quote`',
	array(
		'db_error_skip' => true,
	)
);

$smcFunc['db_query']('', '
	ALTER TABLE {db_prefix}tapatalk_users
	CHANGE `updated` `updated` INT( 10 ) NOT NULL ',
	array(
		'db_error_skip' => true,
	)
);

$history_tapatalk_user_index = array('userid', 'announcement', 'pm', 'subscribe', 'updated');
$history_tapatalk_push_index = array('type', 'id', 'subid', 'title', 'author', 'status');
foreach($history_tapatalk_user_index as $index_name)
    $smcFunc['db_query']('', 'ALTER TABLE {db_prefix}tapatalk_users DROP INDEX `'.$index_name.'`',array('db_error_skip' => true,));
foreach($history_tapatalk_push_index as $index_name)
    $smcFunc['db_query']('', 'ALTER TABLE {db_prefix}tapatalk_push DROP INDEX `'.$index_name.'`',array('db_error_skip' => true,));

$smcFunc['db_query']('', '
	ALTER TABLE {db_prefix}tapatalk_push
	ADD `pushid` INT NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY ( `pushid` ) ',
	array(
		'db_error_skip' => true,
	)
);

$default_settings = array(
    array('tp_full_ads', 1),
);

$smcFunc['db_insert']('replace',
	'{db_prefix}settings',
	array('variable' => 'string-255', 'value' => 'string-65534'),
	$default_settings,
	array('variable')
);

 if($direct_install)
	echo 'Done....';
 
?>
