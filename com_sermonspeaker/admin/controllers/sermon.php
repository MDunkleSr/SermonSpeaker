<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Serie controller class.
 *
 * @package		SermonSpeaker.Administrator
 */
class SermonspeakerControllerSermon extends JControllerForm
{
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param	array	$data	An array of input data.
	 * @return	boolean
	 */
	protected function allowAdd($data = array())
	{
		$user		= JFactory::getUser();
		$categoryId	= JArrayHelper::getValue($data, 'catid', JFactory::getApplication()->input->get('filter_category_id'), 'int');
		$allow = null;

		if ($categoryId)
		{
			// If the category has been passed in the data or URL check it.
			$allow = $user->authorise('core.create', $this->option.'.category.'.$categoryId);
		}

		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd($data);
		}
		else
		{
			return $allow;
		}
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId)
		{
			// Need to do a lookup from the model.
			$record = $this->getModel()->getItem($recordId);
			$categoryId = (int) $record->catid;
		}

		if ($categoryId)
		{
			$user = JFactory::getUser();
			// The category has been set. Check the category permissions.
			if ($user->authorise('core.edit', $this->option.'.category.'.$categoryId))
			{
				return true;
			}
			// Fallback on edit.own.
			if ($user->authorise('core.edit.own', $this->option.'.category.'.$categoryId))
			{
				return ($record->created_by == $user->get('id'));
			}
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}

	public function reset()
	{
		$app	= JFactory::getApplication();
		$jinput	= $app->input;
		$db		= JFactory::getDBO();
		$id 	= $jinput->get('id', 0, 'int');
		if (!$id)
		{
			$app->redirect('index.php?option=com_sermonspeaker&view=sermons', JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
			return;
		}
		$model 	= $this->getModel();
		$item 	= $model->getItem($id);
		$user	= JFactory::getUser();
		$canEdit	= $user->authorise('core.edit', 'com_sermonspeaker.category.'.$item->catid);
		$canEditOwn	= $user->authorise('core.edit.own', 'com_sermonspeaker.category.'.$item->catid) && $item->created_by == $user->id;
		if ($canEdit || $canEditOwn)
		{
			$query	= "UPDATE #__sermon_sermons \n"
					. "SET hits='0' \n"
					. "WHERE id='".$id."'"
					;
			$db->setQuery($query);
			$db->execute();
			$app->redirect('index.php?option=com_sermonspeaker&view=sermons', JText::sprintf('COM_SERMONSPEAKER_RESET_OK', JText::_('COM_SERMONSPEAKER_SERMON'), $item->title));
		}
		else
		{
			$app->redirect('index.php?option=com_sermonspeaker&view=sermons', JText::_('JERROR_ALERTNOAUTHOR'), 'error');
		}
		return;
	}

	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$recordId = $model->getState($this->context.'.id');
		$params	= JComponentHelper::getParams('com_sermonspeaker');

		$app	= JFactory::getApplication();
		$db		= JFactory::getDBO();

		// Check filenames and show a warning if one isn't save to use in an URL. Store anyway.
		$files	= array('audiofile', 'videofile', 'addfile');
		foreach ($files as $file)
		{
			$filename	= JFile::stripExt(basename($validData[$file]));
			if ($filename != JApplication::stringURLSafe($filename) && $filename != str_replace(' ', '_', JFile::makeSafe($filename)))
			{
				$text	= JText::_('COM_SERMONSPEAKER_FILENAME_NOT_IDEAL') . ': ' . $validData[$file];
				$app->enqueueMessage($text, 'warning');
			}
		}

		// Scriptures
		$query	= "DELETE FROM #__sermon_scriptures \n"
				."WHERE sermon_id = ".$recordId
				;
		$db->setQuery($query);
		$db->execute();
		$i	= 1;
		if (isset($validData['scripture']))
		{
			foreach ($validData['scripture'] as $scripture)
			{
				$item	= explode('|', $scripture);
				$query	= "INSERT INTO #__sermon_scriptures \n"
						."(`book`,`cap1`,`vers1`,`cap2`,`vers2`,`text`,`ordering`,`sermon_id`) \n"
						."VALUES ('".(int)$item[0]."','".(int)$item[1]."','".(int)$item[2]."','".(int)$item[3]."','".(int)$item[4]."',".$db->quote($item[5]).",'".$i."','".$recordId."')"
						;
				$db->setQuery($query);
				$db->execute();
				$i++;
			}
		}

		$item = $model->getItem();

		// ID3
		if($params->get('write_id3', 0)){
			$app	= JFactory::getApplication();
			$app->enqueueMessage($this->setMessage(''));
			return $this->write_id3($recordId);
		}

		return;
	}

	public function id3()
	{
		$app	= JFactory::getApplication();
		$id		= $app->input->get('id', 0, 'int');
		$this->write_id3($id);
		$app->redirect('index.php?option=com_sermonspeaker&view=sermon&layout=edit&id='.$id);
		return;
	}

	public function write_id3($id){
		$app	= JFactory::getApplication();
		if (!$id){
			$app->redirect('index.php?option=com_sermonspeaker&view=sermons', JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
			return;
		}
		$db = JFactory::getDBO();
		$query	= "SELECT audiofile, videofile, sermons.created_by, sermons.catid, sermons.title, speakers.title as speaker_title, series.title AS series_title, YEAR(sermon_date) AS year, DATE_FORMAT(sermon_date, '%H%i') AS time, DATE_FORMAT(sermon_date, '%d%m') AS date, notes, sermon_number, picture \n"
				. "FROM #__sermon_sermons AS sermons \n"
				. "LEFT JOIN #__sermon_speakers AS speakers ON speaker_id = speakers.id \n"
				. "LEFT JOIN #__sermon_series AS series ON series_id = series.id \n"
				. "WHERE sermons.id='".$id."'"
				;
		$db->setQuery($query);
		$item	= $db->loadObject();
		$user	= JFactory::getUser();
		$canEdit	= $user->authorise('core.edit', 'com_sermonspeaker.category.'.$item->catid);
		$canEditOwn	= $user->authorise('core.edit.own', 'com_sermonspeaker.category.'.$item->catid) && $item->created_by == $user->id;
		if ($canEdit || $canEditOwn){
			$files[]	= $item->audiofile;
			$files[]	= $item->videofile;
			require_once(JPATH_COMPONENT_SITE.'/id3/getid3/getid3.php');
			$getID3		= new getID3;
			$getID3->setOption(array('encoding'=>'UTF-8'));
			require_once(JPATH_COMPONENT_SITE.'/id3/getid3/write.php');
			$writer		= new getid3_writetags;
			$writer->tagformats			= array('id3v2.3');
			$writer->overwrite_tags		= true; // false would merge, but is currently known to be buggy and throws an exception
			$writer->remove_other_tags	= false;
			$writer->tag_encoding		= 'UTF-8';
			$TagData = array(
				'title'   => array($item->title),
				'artist'  => array($item->speaker_title),
				'album'   => array($item->series_title),
				'track'   => array($item->sermon_number),
				'year'    => array($item->year),
				'date'    => array($item->date),
				'time'    => array($item->time),
			);
			$TagData['comment'] = array(strip_tags(JHtml::_('content.prepare', $item->notes)));

			JImport('joomla.filesystem.file');
			// Adding the picture to the id3 tags, taken from getID3 Demos -> demo.write.php
			if ($item->picture && !parse_url($item->picture, PHP_URL_SCHEME)) {
				ob_start();
				$pic = JPATH_ROOT.'/'.trim($item->picture, ' /');
				if ($fd = fopen($pic, 'rb')) {
					ob_end_clean();
					$APICdata = fread($fd, filesize($pic));
					fclose ($fd);
					$image = getimagesize($pic);
					if (($image[2] > 0) && ($image[2] < 4)) { // 1 = gif, 2 = jpg, 3 = png
						$TagData['attached_picture'][0]['data']          = $APICdata;
						$TagData['attached_picture'][0]['picturetypeid'] = 0;
						$TagData['attached_picture'][0]['description']   = JFile::getName($pic);
						$TagData['attached_picture'][0]['mime']          = $image['mime'];
					}
				} else {
					$errormessage = ob_get_contents();
					ob_end_clean();
					$app->enqueueMessage("Couldn't open the picture: $pic", 'notice');
				}
			}
			$writer->tag_data = $TagData;
			foreach ($files as $file){
				if (!$file){
					continue;
				}
				$path		= JPATH_SITE.$file;
				$path		= str_replace('//', '/', $path);
				if(!is_writable($path)){
					continue;
				}
				$writer->filename	= $path;
				if ($writer->WriteTags()) {
					$app->enqueueMessage('Successfully wrote id3 tags to "'.$file.'"');
					if (!empty($writer->warnings)) {
						$app->enqueueMessage('There were some warnings:<br>'.implode(', ', $writer->warnings), 'notice');
					}
				} else {
					$app->enqueueMessage('Failed to write id3 tags to "'.$file.'"! '.implode(', ', $writer->errors), 'warning');
				}
			}
			return true;
		} else {
			$app->redirect('index.php?option=com_sermonspeaker&view=sermons', JText::_('JERROR_ALERTNOAUTHOR'), 'error');
			return;
		}
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean	 True if successful, false otherwise and internal error is set.
	 *
	 * @since   1.7
	 */
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('Sermon', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_sermonspeaker&view=sermons'.$this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
}