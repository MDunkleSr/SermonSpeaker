<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$count		= (int)$params->get('archive_count');
$switch 	= FALSE;
if ($params->get('archive_switch') == 'month'){
	$switch = TRUE;
}
$database 	= &JFactory::getDBO();

$select_m	= NULL;
$group_m	= NULL;
if ($switch){
	$select_m	= ", MONTH(sermon_date) AS created_month";
	$group_m 	= ", created_month DESC";
}
$query	= "SELECT sermon_date, YEAR(sermon_date) AS created_year".$select_m." \n"
		. "FROM #__sermon_sermons \n"
		. "WHERE (published = 1) \n"
		. "GROUP BY created_year DESC".$group_m;

$database->setQuery($query, 0, $count);
$rows = $database->loadObjectList();

$menu = &JSite::getMenu();
$menuitems = $menu->getItems('link', 'index.php?option=com_sermonspeaker&view=sermons');
if ($menuitems == "") {
	$menuitems = $menu->getItems('component', 'com_sermonspeaker');
}

$sermonspeaker_itemid = $menuitems[0]->id;
if(count($rows)) {
	echo '<ul>';
	foreach ($rows as $row) {
		$request_m	= NULL;
		$text_m		= NULL;
		if ($switch){
			$request_m	= '&amp;month='.$row->created_month;
			$text_m		= JHTML::date($row->sermon_date, 'F', 0).', ';
		}
		$link = JRoute::_('index.php?option=com_sermonspeaker&amp;view=archive&amp;year='.$row->created_year.$request_m.'&amp;Itemid='.$sermonspeaker_itemid);
		$text = $text_m.JHTML::date($row->sermon_date, 'Y', 0);
		?>
		<li><a href="<?php echo $link; ?>"><?php echo $text; ?></a></li>
		<?php
	}
	echo '</ul>';
} // end of if
?>
