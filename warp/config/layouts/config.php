<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get config
$config = $this['system']->config;

// get config xml
$xml     = $this['dom']->create($this['path']->path('template:config.xml'), 'xml');
$warpxml = $this['dom']->create($this['path']->path('warp:warp.xml'), 'xml');

echo '<ul id="config" data-warpversion="'.($warpxml->first('version')->text()).'">';
echo '<div style="padding:10px 0px 10px 5px;border:1px solid #DDDDDD;margin-bottom:10px;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;border: 1px solid #D2D2D2;border-radius: 4px;">Template Configuration Help &rarr; Instruction Available <a href="http://www.mightyjoomla.com/free-joomla-template/outdoor-free-joomla-template" target="_blank">HERE</a></div>';

// render fields
foreach ($xml->find('fields') as $fields) {
	
	// init vars
    $name    = $fields->attr('name');
	$content = '';

	if ($name == 'Profiles') {

		// get profile data
		$profiles = $config->get('profile_data', array('default' => array()));

		// render profiles
		foreach ($profiles as $profile => $values) {
			$content .= $this->render('config:layouts/fields', array('config' => $config, 'fields' => $fields, 'values' => $this['data']->create($values), 'prefix' => "profile_data[$profile]", 'attr' => array('data-profile' => $profile)));
		}

	} else {
		$content = $this->render('config:layouts/fields', array('config' => $config, 'fields' => $fields, 'values' => $config, 'prefix' => 'config', 'attr' => array()));
	}

	printf('<li class="%s" data-name="%s">%s</li>', $name, $name, $content);
}

echo '</ul>';