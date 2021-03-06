<?php
defined('_JEXEC') or die;

$jinput = JFactory::getApplication()->input;

// providing backward compatibilty to older SermonSpeaker versions
if ($jinput->get('task') == 'podcast') {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: '.JURI::root().'index.php?option=com_sermonspeaker&view=feed&format=raw');
	return;
}

require_once(JPATH_COMPONENT.'/helpers/route.php');
require_once(JPATH_COMPONENT.'/helpers/sermonspeaker.php');

// Load languages and merge with fallbacks
$jlang = JFactory::getLanguage();
$jlang->load('com_sermonspeaker', JPATH_COMPONENT, 'en-GB', true);
$jlang->load('com_sermonspeaker', JPATH_COMPONENT, null, true);

$controller	= JControllerLegacy::getInstance('Sermonspeaker');
$controller->execute($jinput->get('task'));
$controller->redirect();