<?php
return array(
	'_root_'  => 'public/list',  // The default route
	'student/detail/(:num)' => 'student/detail/$1',
	'company/edit/(:num)' => 'company/edit/$1',
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);
