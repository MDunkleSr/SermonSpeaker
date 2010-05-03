<?php
/**
* @version $Id: 2.5.1
* @package sermonSpeaker
* @Email martin.zh@gmail.com
* @Website - http://joomlacode.org/gf/project/sermon_speaker/
* @copyright Copyright (C) 2006 Steve Shiflett. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* This file is part of sermonSpeaker.
* sermonSpeaker is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* sermonSpeaker is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* See COPYRIGHT.php for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class sermonLang {
  var $adUpload="SpeakerDirectory Upload";
	var $allowSelfAdding="Allow speakers to add themselves? Not currently supported.";
	var $avatar="Avatar";
	var $avatar_name="Avatar Name";
	var $avatar_location="Avatar Location";
	var $bio="Bio";
	var $code="Code";
	var $count="Count";
	var $coverImage="Cover Image";
	var $coverImagePath="Cover Image Path";
	var $createDirectory="Create Directory";
	var $directory="Directory";
	var $display="Display #";
	var $displaySettings="Display Settings";
	var $downloadable="Downloadable";
	var $generalSettings="General Settings";
	var $help="Help";
	var $helpSection="Help Section";
	var $home="Home";
	var $id="ID";
	var $intro="Intro";
	var $mailEdit="Email on edit/add";
	var $mailEditDesc="Email admin address when an item is added/edited?";
	var $mainHeight="Speaker Photo from the Main Page Height";
	var $mainHeightDesc="Height of the speaker picture in the main SpeakerDirectory page.";
	var $mainWidth="Speaker Photo from the Main Page Width";
	var $mainWidthDesc="Width of the speaker picture in the main SpeakerDirectory page.";
	var $mediaManager="Media Manager";
	var $name="Name";
	var $nameEnteredBy="Entered By";
	var $notes="Sermon Notes";
	var $numberOfResults="Number of results to show per page on the front end.";
	var $picture="Picture";
	var $published="Published";
	var $reset="Reset";
	var $resultsPerPage="Results Per Page";
	var $scripture="Scripture Reference";
	var $search="Search";
	var $selfAdding="Self-Adding";
	var $series="Series";
	var $SeriesAvatar="Series Avatar";
	var $SeriesDescription = "Series Description";
	var $seriesNav="Add/Edit Series";
	var $seriesTitle="Series Title";
	var $seriestats="Stats for Series";
	var $sermon="Sermon";
	var $sermon_date="Sermon Date (YYYY-MM-DD)";
	var $sermonNumber="Sermon Number";
	var $sermonPath="MP3 Path";
	var $sermonTime="Time";
	var $sermonTitle="Sermon Title";
	var $sermonsNav="Add/Edit Sermon";
	var $sermonstats="Stats for Sermons";
	var $showHelp="Show help section on the frontend?";
	var $showClientDisplay="Optional Columns for Client Display:";
	var $client_col_sermon_number_tag = "Sermon Number";             
	var $client_col_sermon_scripture_reference_tag = "Scripture Reference";   
	var $client_col_sermon_date_tag = "Sermon Date";                  
	var $client_col_sermon_time_tag = "Time Length";                  
	var $client_col_sermon_notes_tag = "Sermon Notes";
	var $client_col_player_tag = "Show Player";
	var $showIcons="Show Speaker Photos";
	var $showIconsDesc="Show speaker photos?";
	var $showIntro="Show Intro";
	var $showIntroDesc="Show intro text on the single speaker screen?";
	var $singleHeight="Speaker Photo Height";
	var $singleHeightDesc="Height of the speaker picture in the single speaker page.";
	var $singleWidth="Speaker Photo Width";
	var $singleWidthDesc="Width of the speaker picture in the speaker speaker page.";
	var $speaker="Speaker";
	var $speakerName="Speaker Names";
	var $speakerIcons="Speaker Photo";
	var $speakerStats="Stats for Speaker";
	var $speakersNav="Add/Edit Speakers";
	var $statisticsSettings="Statistics Settings";
	var $stats="View Stats";
	var $trackSeriesViews="Track Series Views";
	var $trackSeriesViewsDesc="Count the number of times each series gets viewed?";
	var $trackSermonPlays="Track Sermon Plays";
	var $trackSermonPlaysDesc="Count the number of times each sermon gets played?";
	var $trackspeakerViews="Track Speaker Views";
	var $trackspeakerViewsDesc="Count the number of times each speaker gets viewed?";
	var $upload="Upload";
	var $useAdUpload="Use SpeakerDirectory to upload/store sermons/images?";
	var $viewseries="Series";
	var $website="Website";
	var $web_link_description="Go to this website";
	var $web_link_tag="Website of ";
	var $sermoncastSettings="Sermoncast Settings";
	var $sc_cache="Enable Cache";
	var $sc_cacheDesc="Enable caching for podcast file";
	var $sc_cache_time="Cache time";
	var $sc_cache_timeDesc="Cache file refresh every x seconds";
	var $sc_mimetype="MIME Type";
	var $sc_mimetypeDesc="The default MIME type to use for the podcast";
	var $sc_encoding="Character Encoding";
	var $sc_encodingDesc="The encoding type to be used for the feed. iTunes requires UTF-8";
	var $sc_count="# Items";
	var $sc_countDesc="Number of Items to syndicate";
	var $sc_title="Title";
	var $sc_titleDesc="Syndication Title";
	var $sc_description="Description";
	var $sc_descriptionDesc="Syndication Description";
	var $sc_copyright="Copyright";
	var $sc_copyrightDesc="Copyright";
	var $sc_limit_text="Limit Text";
	var $sc_limit_textDesc="Limit the description text to the value below";
	var $sc_text_length="Text Length";
	var $sc_text_lengthDesc="The word length of the description - 0 will show no text";
	var $sc_itauthor="iTunes: Author";
	var $sc_itauthorDesc="Name of the author to display for the podcast in iTunes";
	var $sc_itimage="iTunes: Image";
	var $sc_itimageDesc="Image to use for iTunes feed. iTunes prefers images 300x300px or larger (example: http://www.mychurch.com/itunes.jpg)";
	var $sc_itcat1="iTunes: Category 1";
	var $sc_itcat1Desc="Your first category selection for iTunes";
	var $sc_itcat2="iTunes: Category 2";
	var $sc_itcat2Desc="Your second category selection for iTunes";
	var $sc_itcat3="iTunes: Category 3";
	var $sc_itcat3Desc="Your third category selection for iTunes";
	var $sc_itkeywords="iTunes: Keywords";
	var $sc_itkeywordsDesc="Define keywords describing your podcast. Searchable trough iTunes (not visible, max 12 Keywords separated by comma).";
	var $sc_itowneremail="iTunes: Owner Email";
	var $sc_itowneremailDesc="Enter an address where iTunes users can reach you (not visible).";
	var $sc_itownername="iTunes: Owner Name";
	var $sc_itownernameDesc="Enter your Name for your contact information in iTunes (not visible).";
	var $sc_itsubtitle="iTunes: Subtitle";
	var $sc_itsubtitleDesc="Enter a short title for the Description column in iTunes.";
	var $sc_showpcast="Show Podcast Link";
	var $sc_showpcastDesc="Enables the Podcast Icon on the frontpage (mod_sermoncast must be installed!)";
	var $sc_showplink="Show RSS Link";
	var $sc_showplinkDesc="Enables the RRS Feed on the frontpage (mod_sermoncast must be installed!)";
	var $sc_mod_text="Module text";
	var $sc_mod_textDesc="Text will be displayed in Sermoncast Module";
  var $date_format="Date Format";
  var $date_formatdesc="Show Date in d.m.y instead of m-d-y";
  var $sc_it_prefix="iTunes Prefix";
  var $sc_it_prefix_desc="Prefix used in the iTunes Link (default: pcast, itpc is used for direct subscription in iTunes)";
  var $ordering="Ordering";
  var $up="Up";
  var $down="Down";
  var $startpage="Client Startpage";
  var $startpage_desc="1: Speaker Overview<br>2: Series Overview<br>3: All sermons<br>4: Series/Sermon Listing";
  var $latestsermonsSettings="LatestSermons Settings";
  var $ls_nbr_latest="Items in mod_LatestSermons";
  var $ls_nbr_latest_desc="Number of items mod_latestsermons will show if installed";
  var $sc_itLanguage="iTunes: Language";
  var $sc_itLanguageDesc="Language specification for iTunes in ISO639-1 code. For language codes see <a href=http://www.loc.gov/standards/iso639-2/php/code_list.php target=_new>http://www.loc.gov/standards/iso639-2/php/code_list.php</a>)";
  var $mp_width="Video Player Width";
  var $mp_widthDesc="Width of the Flash Video Player (adjust according to your videos)";
  var $mp_height="Video Player Height";
  var $mp_heightDesc="Height of the Flash Video Player (adjust according to your videos)";
  var $ls_show_mouseover="Show mouseover effect";
  var $ls_show_mouseover_desc="Displays more information on latest Sermons";
  var $ls_show_mo_speaker="Show Speaker";
  var $ls_show_mo_speaker_desc="Displays speaker name if mouseover is enabled";
  var $ls_show_mo_series="Show Series";
  var $ls_show_mo_series_desc="Displays series name if mouseover is enabled";
  var $ls_show_mo_date="Show Date";
  var $ls_show_mo_date_desc="Displays date if mouseover is enabled";
  var $statistics="Statistics";
  var $about="This component was developed by Steve Shiflet and Martin Hess.";
  var $introduction="This component allows one to upload/describe sermons to a Joomla website. You may track the activity of the hit counts for each speaker, each series, and each sermon that has been selected using the Statistics Manager button.";
  var $sc_itRedirect="iTunes Redirect";
  var $sc_itRedirectDesc="URL to redirect iTunes. Used in special cases only, leave blank if not used";
  var $color1="Table Background Color one";
  var $color1Desc="Color definition for table background. (For color codes see <a href=http://www.computerhope.com/htmcolor.htm target=_new>http://www.computerhope.com/htmcolor.htm</a>)";
  var $color2="Table Background Color two";
  var $color2Desc="Second Color definition for table background";
  var $enteredby="Entered by";
  var $controlPanel="Configuration";
  var $sermonlayout="Download Page Layout";
  var $sermonlayoutDesc="1: All in a row<br>2: New Line<br>3: Extended New Line";
  var $ga="Google Analytics Support (Flash Player only)";
  var $gaDesc="To send callbacks automatically to Google Analytics, set this to urchin (if you use the old urchinTracker code) or analytics (if you use the new pageTracker code). Leave empty if not used.";
  var $limitspeaker="Limit shown sermons per speaker:";
  var $limitspeakerDesc="Limit shown sermons (as set by Results per Page)?";
  var $allow_ussp="Allow user to override startpage";
  var $allow_usspDesc="If enabled you can create links, so that the users can choose their startpage (create an external link like <br>\"http://www.mychurch.com/index.php?option=com_sermonspeaker&Itemid=53&myussp=2\" where myssup=x indicates the startpage)";
  var $sermoncast="Sermoncast";
  var $select_file="Select file";
  var $addfile="Additional file path";
  var $addfileDesc="Additional file name / description";
  var $autostart="Flash Player Autostart";
  var $autostartDesc="If enabled audio/video will start automatically";
  var $client_col_sermon_addfile_desc="Show Additional File column";
  var $dl_button="Show Download Button";
  var $popup_player="Show Popup Player Button";
  var $popup_color="Popup Player Background Color";
  var $popup_colorDesc="Color definition for the popup player. (For color codes see <a href=http://www.computerhope.com/htmcolor.htm target=_new>http://www.computerhope.com/htmcolor.htm</a>)";
  var $popup_height="Popup Player window height";
  var $popup_heightDesc="Height of the popup window. Video size will be added automatically.";
  var $sc_showhelp="Show link to help popup";
  var $sc_showhelpDesc="If enabled the user can get some help about podcasting by a popup";
  var $sc_helpeditor="Podcasting help popup";
  var $sc_helpeditorDesc="Specifiy the podcasting help popup.";
  var $sc_helpwidth="Podcasting help popup width";
  var $sc_helpwidthDesc="The width of the popup window in pixel";
  var $sc_helpheight="Podcasting help popup height";
  var $sc_helpheightDesc="The height of the popup window in pixel";
  var $ss_version="SermonSpeaker Version";
  var $ss_ver_mismatch="Your config file is older than the version you are using. Check for new settings and save the config to activate all features!";
  var $c4nv="Check for new version";
  var $err_infalid_rquest="Invalid Request" ;
  var $err_char="Directory name must only contain alphanumeric characters and no spaces please.";
  var $c_series_saved="Changes to Sermon Series saved";
  var $series_saved="Sermon Series Saved";
  var $a_sermon_saved="Changes to Sermon applied";
  var $sermon_saved="Changes to Sermon saved";
  var $err_unwritable="Configuration file not writeable!";
  var $err_sc_unwritable="SermonCast configuration file not writeable!";
  var $saved="Configuration settings saved";
  var $err_filetype="Only files of type gif, png, jpg, or bmp can be uploaded to the avatar directory.  It only makes sense if you think about it.";
  var $err_fileexists="Upload FAILED. File allready exists";
  var $err_upload_type="Only files of type gif, png, jpg, bmp or mp3 can be uploaded";
  var $err_upload_failed="Upload FAILED";
  var $upload_complete="Upload complete";
  var $err_invalid_req="Invalid Request";
  var $err_pcast="Error creating feed file, please check write permissions.";
  var $fronenduploading="Frontend Uploading";
  var $fu_enable="Frontend uploading enable";
  var $fu_enable_desc="If disabled no frontend uploading is possible (disable if not used - if enabled the taskname below must be set!)";
  var $fu_taskname="Taskname";
  var $fu_taskname_desc="Set this to something unique to increase security";
  var $fu_destdir="Destination directory";
  var $fu_destdir_desc="Path relative to the SermonSpeaker directory (see media manager)";
  var $fu_pwd="Password";
  var $fu_pwd_desc="Enter the password twice to set/change it; leave both fields blank to retain it";
  var $pwd_changed=", Password changed";
  var $pwd_short=", Password not set/changed, too short";
  var $pwd_match=", Password not set/changed, no match";
  var $fu_id3_title="ID3 tag for Sermon Title";
  var $fu_id3_title_desc="Select the ID3 tag that contains the information or (-) to ignore the ID3 information";
  var $fu_id3_speaker="ID3 tag for Speaker";
  var $fu_id3_speakere_desc="";
  var $fu_id3_series="ID3 tag for Serie";
  var $fu_id3_series_desc="";
  var $fu_id3_ref="ID3 tag for Scripture Reference";
  var $fu_id3_ref_desc="";
  var $fu_id3_number="ID3 tag for the Sermon Number";
  var $fu_id3_number_desc="";
  var $fu_id3_notes="ID3 tag for the Sermon Notes";
  var $fu_id3_notes_desc="";
  var $hide_dl="Hide download link";
  var $hide_dl_desc="Don't show any link to the file";
} ?>
