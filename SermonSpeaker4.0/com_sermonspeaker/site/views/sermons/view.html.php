<?php
defined('_JEXEC') or die;
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the SermonSpeaker Component
 */
class SermonspeakerViewSermons extends JViewLegacy
{
	function display($tpl = null)
	{
		require_once(JPATH_COMPONENT.'/helpers/player.php');
		// Get some data from the models
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->years		= $this->get('Years');
		$this->months		= $this->get('Months');
		$books				= $this->get('Books');
		// Get Category stuff from models
		$this->category		= $this->get('Category');
		$children			= $this->get('Children');
		$this->parent		= $this->get('Parent');
		$this->children		= array($this->category->id => $children);
		// Add filter to pagination, needed in case of URL params from module(?)
		$this->pagination->setAdditionalUrlParam('view', 'sermons');
		$this->pagination->setAdditionalUrlParam('year', $this->state->get('date.year'));
		$this->pagination->setAdditionalUrlParam('month', $this->state->get('date.month'));
		$this->params = $this->state->get('params');
		if ((int)$this->params->get('limit', '')){
			$this->params->set('filter_field', 0);
			$this->params->set('show_pagination_limit', 0);
			$this->params->set('show_pagination', 0);
			$this->params->set('show_pagination_results', 0);
		}
		$this->columns	= $this->params->get('col');
		if (!$this->columns){
			$this->columns = array();
		}
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		if ($this->category == false) {
			return JError::raiseError(404, JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}
		if ($this->parent == false && $this->category->id != 'root') {
			return JError::raiseError(404, JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}
		if ($this->category->id == 'root'){
			$this->params->set('show_category_title', 0);
			$this->cat = '';
		} else {
			// Get the category title for backward compatibility
			$this->cat = $this->category->title;
		}
		// Check whether category access level allows access.
		$user	= JFactory::getUser();
		$groups	= $user->getAuthorisedViewLevels();
		if (!in_array($this->category->access, $groups)) {
			return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
		}
		// Set layout from parameters if not already set elsewhere
		if ($this->getLayout() == 'default') {
			$this->setLayout($this->params->get('sermonslayout', 'table'));
		}
		$js = 'function clear_all(){
			if(document.id(\'filter_books\')){
				document.id(\'filter_books\').value=0;
			}
			if(document.id(\'filter_months\')){
				document.id(\'filter_months\').value=0;
			}
			if(document.id(\'filter_years\')){
				document.id(\'filter_years\').value=0;
			}
			if(document.id(\'filter-search\')){
				document.id(\'filter-search\').value="";
			}
		}';
		$this->document->addScriptDeclaration($js);
		// Build Books
		$at	= 0;
		$nt	= 0;
		$ap	= 0;
		$this->books	= array();
		foreach ($books as $book){
			if(!$at && $book <= 39){
				$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_OLD_TESTAMENT'));
				$at	= 1;
			} elseif($book > 39){
				if($at == 1){
					$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_OLD_TESTAMENT'));
					$at	= 2;
				}
				if(!$nt && $book <= 66){
					$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_NEW_TESTAMENT'));
					$nt	= 1;
				} elseif($book > 66){
					if($nt == 1){
						$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_NEW_TESTAMENT'));
						$nt	= 2;
					}
					if(!$ap){
						$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_APOCRYPHA'));
						$ap	= 1;
					}
				}
			}
			$object	= new stdClass;
			$object->value	= $book;
			$object->text	= JText::_('COM_SERMONSPEAKER_BOOK_'.$book);
			$this->books[]	= $object;
		}
		if($at == 1){
			$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_OLD_TESTAMENT'));
		} elseif($nt == 1){
			$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_NEW_TESTAMENT'));
		} elseif($ap == 1){
			$this->books[]	= JHtml::_('select.optgroup', JText::_('COM_SERMONSPEAKER_APOCRYPHA'));
		}
		$this->pageclass_sfx	= htmlspecialchars($this->params->get('pageclass_sfx'));
		$this->maxLevel			= $this->params->get('maxLevel', -1);
		$this->_prepareDocument();
		parent::display($tpl);
	}
	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_SERMONSPEAKER_SERMONS_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}