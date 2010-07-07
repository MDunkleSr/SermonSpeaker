<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class SermonspeakerViewMain extends JView
{
	function display( $tpl = null )
	{
		$migrate = NULL;
		$params	=& JComponentHelper::getParams('com_sermonspeaker');
		if (!$params->get('series_player')){
			$migrate = '<thead>';
			$migrate .= '<tr><td bgcolor="salmon"><center><strong>'.JText::_('COM_SERMONSPEAKER_NOTSAVED').'</strong></center></td></tr>';
			$migrate .= '</thead>';
		} elseif (file_exists(JPATH_COMPONENT.DS.'config.sermonspeaker.php') || file_exists(JPATH_COMPONENT.DS.'sermoncastconfig.sermonspeaker.php')) {
			$migrate = '<thead>';
			$migrate .= '<tr><td bgcolor="salmon"><center><strong>'.JText::_('COM_SERMONSPEAKER_OLD_CONFIG_PRESENT').'</strong></center></td></tr>';
			$migrate .= '<tr align="center"><td bgcolor="salmon">';
			$migrate .= '<center><form action="index.php?option=com_sermonspeaker&task=migrate" method="post" name="adminForm">';
			$migrate .= '<input type="submit" value="Migrate!">';
			$migrate .= '</center></form></td></tr>';
			$migrate .= '</thead>';
		}
		$this->assignRef('migrate', $migrate);

		parent::display($tpl);
	}
}