<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.2, 2013.10.31
 
**********************************
*/
if(!defined('PHPOS'))	die();	

	$lang_date_format =	'H:i:s d.m.Y';	
	
	$txt['demo_mode'] = 'DEMO MODE';
	$txt['demo_mode_desc'] = '<b>PHPOS is running in demo mode.</b> You can only preview some features.<br />All features like saving data or creating files are disabled. Enjoy!';	
	
	$txt['calendar'] = 'Calendar';
	$txt['calendar_weeks_0'] = 'S';
	$txt['calendar_weeks_1'] = 'M';
	$txt['calendar_weeks_2'] = 'T';
	$txt['calendar_weeks_3'] = 'W';
	$txt['calendar_weeks_4'] = 'T';
	$txt['calendar_weeks_5'] = 'F';
	$txt['calendar_weeks_6'] = 'S';
	
	$txt['calendar_month_1'] = 'Jan';
	$txt['calendar_month_2'] = 'Febr';
	$txt['calendar_month_3'] = 'Mar';
	$txt['calendar_month_4'] = 'Apr';
	$txt['calendar_month_5'] = 'May';
	$txt['calendar_month_6'] = 'June';
	$txt['calendar_month_7'] = 'July';
	$txt['calendar_month_8'] = 'Aug';
	$txt['calendar_month_9'] = 'Sep';
	$txt['calendar_month_10'] = 'Oct';
	$txt['calendar_month_11'] = 'Nov';
	$txt['calendar_month_12'] = 'Dec';
	
	
	
	$txt['new_folder'] = 'New folder';	
	$txt['plugins'] = 'Plugins';
	$txt['update'] = 'Save & update';
	$txt['app_footer_version'] = 'Version:';
	
	$txt['waiting_progress'] = 'Work in progress...Please wait...';
	
	$txt['files_packed'] = 'Files was packed into .zip archive';
	$txt['zip_archive_prefix'] = 'Archive';

	// console
	$txt['console_clean'] = 'Clear console';	
	$txt['console_hide'] = 'Hide to tray';	
	$txt['console_tray_title'] = 'PHPOS Console';	
	$txt['console_events'] = 'Events log';	
	$txt['console_params'] = 'App Params';	
	$txt['console_clipboard'] = 'Clipboard';	
	$txt['console_click_to_show_params'] = 'Click on window on left list to show app params for this window';	
	$txt['console_legend'] = 'Legend';
	$txt['console_legend_time'] = 'TIME';
	$txt['console_legend_key'] = 'KEY/VARIABLE';
	$txt['console_legend_value'] = 'VALUE';
	$txt['console_legend_winid'] = 'WIN_ID';
	$txt['console_legend_appid'] = 'APP_ID';
	$txt['console_legend_appaction'] = 'APP_ACTION';
	
	
// MONTHS	
	$txt['month_1'] = 'January';
	$txt['month_2'] = 'February';
	$txt['month_3'] = 'March';
	$txt['month_4'] = 'April';
	$txt['month_5'] = 'May';
	$txt['month_6'] = 'June';
	$txt['month_7'] = 'July';
	$txt['month_8'] = 'August';
	$txt['month_9'] = 'September';
	$txt['month_10'] = 'October';
	$txt['month_11'] = 'November';
	$txt['month_12'] = 'December';	
	$txt['today'] = 'today';
	
	$txt['week_0'] = 'Sunday';
	$txt['week_1'] = 'Monday';
	$txt['week_2'] = 'Tuesday';
	$txt['week_3'] = 'Wednesday';
	$txt['week_4'] = 'Thursday';
	$txt['week_5'] = 'Friday';
	$txt['week_6'] = 'Saturday';
	
	
	$txt['yes'] = 'Yes';
	$txt['no'] = 'No';
	$txt['active'] = 'Active';
	
	
// NAV
	$txt['navi_prev'] = 'Go Backward';
	$txt['navi_next'] = 'Go Forward';
	$txt['navi_up'] = 'Go to Parent';
	
	
// ICONS
	$txt['my_server'] = 'My server';
	$txt['my_documents'] = 'My documents';
	$txt['task_manager'] = 'Task manager';	
	$txt['api_documentation'] = 'API documentation';
	
	$txt['home_local_folder'] = 'Home folder';
	$txt['home_mysql_folder'] = 'MySQL folder';
	$txt['home_db_folder'] = 'MySQL folder';
	$txt['ftp_folders'] = 'FTP Folders';
	$txt['mstart_apps'] = 'Apps';
	$txt['account_settings'] = 'Account settings';
	$txt['sys_info'] = 'System info';
	$txt['help'] = 'PHPOS Online';
	$txt['updates'] = 'Updates';
	$txt['logout'] = 'Logout';
	$txt['control_panel'] = 'Control Panel';
	$txt['control_panel_desc'] = 'Control Panel in the place with all of settings of system and applications installed on it. If application have control panel it will be showed here. Some of the features are available only for administrators and are hidden for normal users.';
	$txt['folder_not_found'] = 'Folder not found';
	$txt['access_denied'] = 'Access denied';
	
	$txt['language'] = 'Language';
	$txt['btn_delete'] = 'Delete';	
	$txt['icon_size'] = 'Icons size';
	$txt['icon_size_s'] = 'Small';
	$txt['icon_size_m'] = 'Medium';
	
	
	// Menu up files
	$txt['view_icons'] = 'Icons view';
	$txt['view_list'] = 'List view';
	$txt['view_thumbs'] = 'Thumbnails';
	$txt['view_extensions'] = 'Files extensions';
	$txt['view_extensions_show'] = 'Show extensions';
	$txt['view_extensions_hide'] = 'Hide extensions';
	$txt['view_sortby'] = 'Sort files';
	$txt['view_sortby_type'] = 'by Type';
	$txt['view_sortby_name'] = 'by Name';
	$txt['view_sortby_date'] = 'by Date of modification';
	$txt['view_sortby_size'] = 'by Filesize';
	$txt['view_sortby_asc'] = 'Ascending';
	$txt['view_sortby_desc'] = 'Descending';
	
	
	
	// Toolbar list
	$txt['list_copy_desc'] = 'Copy selected files/folders to clipboard';
	$txt['list_cut_desc'] = 'Cut selected files/folders to clipboard';
	$txt['list_zip_desc'] = 'Pack selected files with Zip';
	$txt['list_pack_zip'] = 'Pack (.zip)';
	$txt['list_delete_desc'] = 'Delete selected files/folders';
	$txt['list_select_all'] = 'Select All';
	$txt['list_select_none'] = 'Select None';
	$txt['list_select_reverse'] = 'Reverse selection';
	$txt['list_select_all_desc'] = 'Select all files/folders';
	$txt['list_select_none_desc'] = 'Unselect all files/folders';
	$txt['list_select_reverse_desc'] = 'Reverse selection';
	
	// GoogleDrive
	$txt['googledrive_loginscreen_info'] = '<b>Google Drive is now supported!</b><br />From version 1.28 Google Drive is fully supported. You can manage all your files placed on your Google Drive just like a normal folder. Check the features live!  // 2013.10.26';
	$txt['googledrive_header_connected'] = 'Connected to your Google Drive Account';
	$txt['googledrive_right_clickhere'] = 'Click here';
	$txt['googledrive_right_clickhere_desc'] = 'to login to your Google Drive';
	$txt['googledrive_header_must_login'] = 'At first you must login to your Google Drive Account here below';
	$txt['googledrive_auth_url'] = 'Login to Google Account';
	$txt['googledrive_need_login_help'] = 'Google Drive requires login and accept access to your files. When you click on <b>Login to Google Account</b> you will be redirected to Google and you must accept request for agree to showing files from your Google Drive. Google Drive API must be enable in your account settings. <b>PHPOS will <u>not store</u> any data about your Google Account. <br />PHPOS Private Policy about usage Google Drive on this system is here: <a href="http://www.phpos.pl/?v=google_drive_policy" target="blank"><u>http://phpos.pl/?v=google_drive_policy</u></a></b>';
	
	$txt['googledrive_right_info_nologged'] = 'With Google Drive support you can manage your files like normal folder. You can creating new files and folders, deleting them, moving (between other filesystems also!), copying, downloading and uploading new files from other filesystems or from your computer via <b>Drag&Drop</b>.';

	
// CONTEXT MENUS
	$txt['open'] = 'Open';
	$txt['open_with'] = 'Open with';
	$txt['connect_to'] = 'Connect';
	$txt['download'] = 'Download';
	$txt['download_to_disk'] = 'Download to your computer';
	$txt['download_to_server'] = 'Download to server';
	$txt['copy'] = 'Copy';
	$txt['copy_server'] = 'Copy between filesystems';
	$txt['paste'] = 'Paste';
	$txt['cut'] = 'Cut';
	$txt['delete'] = 'Delete';
	$txt['delete_confirm'] = 'Are you sure to delete';
	$txt['delete_from_clipboard'] = 'Delete from clipboard';
	$txt['clean_clipboard'] = 'Delete all from clipboard';
	$txt['rename'] = 'Rename';	
	$txt['home_dir'] = 'Home Dir';	
	$txt['privilleges'] = 'Privilleges';	
	$txt['try_again'] = 'Try again';	
	$txt['never'] = 'Never';
	
// DESKTOP CONTEXT MENU
	$txt['link_on_desktop'] = 'Create shortcut to this folder on desktop';
	$txt['change_desktop_wallpaper'] = 'Change desktop wallpaper';
	$txt['context_to_db'] = 'Switch to database desktop';
	$txt['context_to_local'] = 'Switch to local files desktop';
	
	$txt['workgroup'] = 'Workgroup';
	$txt['shared'] = 'Shared';	
	$txt['opened_windows'] = 'Opened windows';	
	$txt['new_shortcut'] = 'New shortcut';
	$txt['new_folder'] = 'New folder';
	$txt['share_folder'] = 'Share this folder';
	$txt['stop_share_folder'] = 'Stop share this folder';
	$txt['in_web_browser'] = 'Web browser';
	$txt['in_new_win'] = 'New window';
	$txt['to_mstart'] = 'Add to menu start';
	$txt['edit_shortcut'] = 'Change shortcut';
	
	$txt['open'] = 'Open';
	
// MSG
	$txt['msg_success'] = 'Success';
	$txt['msg_info'] = 'Info';
	$txt['msg_error'] = 'Error';	
	$txt['new_win'] = 'New window';
	$txt['error_rename'] = 'Error with renaming file/folder';
	
	
// LIBS	
	$txt['libs'] = 'Libraries';
	$txt['lib_clipboard'] = 'Clipboard';
	$txt['lib_download'] = 'Download';
	$txt['lib_desktop'] = 'Desktop';
	$txt['lib_docs'] = 'Documents';
	$txt['lib_wallpapers'] = 'Wallpapers';
	$txt['lib_pics'] = 'Pictures';
	$txt['lib_media'] = 'Media';
	$txt['lib_icons'] = 'Icons';
	$txt['lib_temp'] = 'Temp files';	
	
// LIBS	RENAME	
	$txt['lib_Clipboard'] = $txt['lib_clipboard'];
	$txt['lib_Download'] = $txt['lib_download'];
	$txt['lib_Desktop'] = $txt['lib_desktop'];
	$txt['lib_Documents'] = $txt['lib_docs'];
	$txt['lib_Wallpapers'] = $txt['lib_wallpapers'];
	$txt['lib_Pictures'] = $txt['lib_pics'];
	$txt['lib_Video'] = $txt['lib_media'];
	$txt['lib_Icons'] = $txt['lib_icons'];
	$txt['lib_Temp'] = $txt['lib_temp'];	
		
	
// USER TYPES
	$txt['user_user'] = 'User';
	$txt['user_admin'] = 'Administrator';
	$txt['user_admins'] = 'Administrators';
	$txt['user_root'] = 'User root';

	
// SERVER SUBTITLES
	$txt['st_ftp'] = 'With FTP accounts you can have access to your data on your own FTP servers.  You can browse, download and upload files to your FTP server from here. You can create FTP account via Control Panel and connect to them like a normal folder.';	
	$txt['st_shared'] = 'This in the list of shared folders. Users can share their own local files and folders with another users in the same workgroup. When you sharing your files you can set status "readonly" for other users. Shared folders are visible in all workgroups where user is.';	
	$txt['st_localfiles'] = 'This is your local home folder on this server. <br />Every user have folder like that. It is your private place, nobody against you cant access to your data. <br />You can browse, download and upload your files here.';	
	$txt['st_db'] = 'This is your virtual database folder. <br />This folder is not real. It is only in database, but you can navigate on them like on real local folder, and create shortcuts to apps, and more. <br />Nobody against you cant access to this folder.';
	$txt['control_panel_right_desc'] = 'Click on the the item to open specified control panel and follow the instructions.'; 
	$txt['ip_server'] = 'SERVER IP';
	
// SERVER	/ FS
	$txt['local_fsystems'] = 'Local filesystems';
	$txt['home_local_folder_desc'] = 'Local folder on your server';	
	$txt['home_db_folder_desc'] = 'Virtual folder in database';		
	$txt['favorites'] = 'Favorites';
	
	$txt['explorer_right_db'] = 'Database folder';
	$txt['explorer_right_db_desc'] = 'This folder is virtual and exists only in database filesystem. In this folders you can create your own folders and shortcuts to apps and more. Upload of files is not available in database folders.';
	
	$txt['explorer_right_local'] = 'Local HOME folder';
	$txt['explorer_right_local_desc_drag_active'] = '<b>Drag & drop upload</b> is active in this window. To upload your files from your computer drag them into this window. You can drop here <b>multiple files at once</b>';
	
	$txt['folder_is_empty'] = 'This folder is empty';	
	
	
// TASKS
	$txt['close_win'] = 'Close this window';
	$txt['closeall_win'] = 'Close all windows';
	$txt['showhide_win'] = 'Show/hide';
	$txt['center_win'] = 'Center window';	

	
// DESKTOP SWITCH
	$txt['desktop_switch_to'] = 'Switch to';	
	$txt['desktop_switch_up_desktop'] = 'Desktop:';
	$txt['desktop_switch_up_local'] = 'Local home dir';
	$txt['desktop_switch_up_db'] = 'Database';	
	$txt['desktop_switch_tray_to_db'] = 'Switch to Database';
	$txt['desktop_switch_tray_to_local'] = 'Switch to Local home dir';	
	
// MENU START
	$txt['click_to_logout'] = 'Click to logout from PHPOS';	
	$txt['start_phpos_online'] = 'PHPOS Website';	
	$txt['readonly_right_msg'] = 'This folder is <b>readonly</b> for your account.<br />You can browse and open files but you can\'t create folders, renaming files and uploading new files.';
	$txt['msg_added_to_menustart'] = 'Link was added to menu start';
	$txt['del_from_start'] = 'Delete from menustart';
	
// MSG STATUSES
	$txt['updated'] = 'Updated';
	$txt['created'] = 'Created';
	$txt['uploaded'] = 'Uploaded';
	$txt['deleted'] = 'Deleted';
	$txt['shared'] = 'Shared';	
	$txt['owner'] = 'Owner';		
	$txt['icon'] = 'Icon';
	$txt['your_icons_tip'] = 'You can upload your icons to your Icons library';
	
// WARNS
	$txt['name_empty'] = 'Name is empty';
	$txt['url_empty'] = 'URL is empty';	

	
// NAVBAR
	$txt['upload'] = 'Upload file';
	$txt['tip_nav_go_to'] = 'Go to';
	$txt['tip_explorer_dblclick_to_input_address'] = 'Double click to enter adrress manualy';
	$txt['tip_explorer_upload_file'] = 'Click on [choose file] and upload now!';
	
	
/* ====== EXPLORER API ===== */
	$txt['explorer_api_window_view_allowed'] = 'Allowed filetypes';
	$txt['explorer_api_window_view_all'] = 'All filetypes';
	$txt['explorer_api_window_open_title'] = 'Open file';
	$txt['explorer_api_window_save_title'] = 'Save as';
	$txt['explorer_api_file_name'] = 'File name';
	$txt['explorer_api_file_btn'] = 'Save file';
	$txt['explorer_api_file_name_desc'] = 'Specify file name. Name must be not empty. If file exists will be overwriten.';
		


/* ====== SHORTCUTS ===== */	
	
// SHORTCUTS
	$txt['new_icon_title'] = 'New icon';
	$txt['shortcut_phpos'] = 'PHPOS App';
	$txt['shortcut_webframe'] = 'Webframe';
	$txt['shortcut_url'] = 'URL';
	$txt['shortcut_mediaurl'] = 'Media frame';
	$txt['shortcut_folder'] = 'Folder';
	$txt['shortcut_upload'] = 'File upload';		
	$txt['shortcut_phpos_tip'] = 'Link to new app';
	$txt['shortcut_webframe_tip'] = 'Webframe';
	$txt['shortcut_url_tip'] = 'URL';
	$txt['shortcut_folder_tip'] = 'Folder';
	$txt['shortcut_upload_tip'] = 'File upload';	
	$txt['shortcut_mediaurl_action'] = 'Media type';
	
// SHORTCUTS DESCS
	$txt['st_shortcut_new_dir'] = 'Please specify the name of folder. The name must be not empty.';
	$txt['st_shortcut_new_dir'] = 'Please specify the name of folder. The name must be not empty.';
	$txt['st_shortcut_link'] = 'Link is the special icon whitch opens real URL in new window. You can create link to your favorite sites and put it into PHPOS database as quick shortcut to this.';
	$txt['st_shortcut_medialink'] = 'You can create link to media on YouTube, Vimeo and more. Just specify url to video - it will be shown in PHPOS window. Medialinks can be extended by plugins';
	$txt['st_shortcut_iframe'] = 'With webframe you can specify link to your application or website. It will be opened in PHPOS window as internal iframe.';
	$txt['st_shortcut_newdir'] = 'Create new folder here.';
	$txt['st_shortcut_newapp'] = 'Create new shortcut to PHPOS Application and specify start parameters.';
	$txt['st_shortcut_newapp1'] = 'Create new shortcut to PHPOS Application and specify start parameters. <br />Select application and go to next step.';
	$txt['st_shortcut_newapp2'] = 'Create new shortcut to PHPOS Application and specify start parameters. <br />Specify application parameters.';
	$txt['st_shortcut_upload'] = 'Upload your local files to this folder.';
	
// FORM NAMES
	$txt['action_name'] = 'Action name';
	$txt['action_name_tip'] = 'Action name';	
	$txt['start_window'] = 'Start window';
	$txt['start_window_tip'] = 'Start window';	
	$txt['icon_name'] = 'Icon name';
	$txt['start_parameters'] = 'Start parameters';	
	$txt['folder_name'] = 'Folder name';
	$txt['desc'] = 'Description';
	$txt['shared_name'] = 'Shared name';
	$txt['folder'] = 'Folder';	
	
// BUTTONS
	$txt['btn_back'] = 'Back';
	$txt['btn_next'] = 'Next';
	$txt['btn_create'] = 'Create';
	$txt['btn_update'] = 'Update';
	$txt['btn_share'] = 'Share';	
	$txt['btn_back_tip'] = 'Back';
	$txt['btn_next_tip'] = 'Next';
	$txt['btn_create_tip'] = 'Create';
	$txt['btn_update_tip'] = 'Update';
	$txt['btn_share_tip'] = 'Share';
	
//  SHORTCUTS - APPS
	$txt['shortcuts_index_footer'] = 'Choose shortcut type';
	$txt['shortcuts_icon_for_title'] = 'Custom icon for shortcut';
	$txt['shortcuts_icon_for_name'] = 'User icon';
	$txt['shortcuts_icon_for_desc'] = 'You can choose you own icon for any shortcut.<br />If you want to add your icon to this list just upload a new PNG file with icon into your Icons Library folder. If you dont select icon default app icon will be used.';	
	$txt['shortcuts_form_icon_name'] = 'Shortcut name';
	$txt['shortcuts_form_icon_name_desc'] = 'Specify the name for this icon.<br />Icon name is required.';	
	$txt['shortcuts_app_form_choose_params'] = 'Choose icon parameters';
	$txt['shortcuts_app_form_choose_params_desc'] = 'Now you must specify the start parameters for this application. You can specify icon name, start action and other app parameter. Those parameters will be used when you will click on app shortcut icon. You can also specify your own icon for shortcut.';
	$txt['shortcuts_app_form_actions_desc'] = 'Please specify default action. Every app can have unlimited number of actions. <br />Action are something like app modules.';
	$txt['shortcuts_app_form_param_desc'] = 'Please choose a parameter';	
	$txt['shortcuts_app_form_step1_desc'] = 'You can create a shortcut to PHPOS application from here. There is a list of application of installed apps for your account type.<br /><b>Click on application name to go to the next step</b>';
	
// SHORTCUTS - URL
	$txt['shortcuts_url_title'] = 'Website URL shortcut';
	$txt['shortcuts_url_desc'] = 'URL shortcut is a special icon with URL to another website.<br />If you click on this type icon you just open new window with website specified in URL.';
	$txt['shortcuts_url_form_url'] = 'URL';
	$txt['shortcuts_url_form_url_desc'] = 'Specify URL to website you want, eg. http://google.com';
	
//  SHORTCUTS - IFRAME
	$txt['shortcuts_iframe_title'] = 'Webframe shortcut';
	$txt['shortcuts_iframe_desc'] = 'With webrame you can specify URL to your another webapplication, e.g. PHPMyAdmin or Wordpress Admin Panel. Application will be displayed in PHPOS window as an iframe.<br /><b>Important things:<br /> 1) Not every website can be displayed in iframe. <br />2) Your browser must supporting HTML5 sandbox iframes.</b>';
	$txt['shortcuts_iframe_form_url'] = 'URL to your webapplication or website';
	$txt['shortcuts_iframe_form_url_desc'] = 'Specify URL to webapplication or website, eg. http://localhost/phpmyadmin/ or http://google.com';	
	$txt['iframe_warn_sandbox'] = 'It is a iframe sandbox. Site displayed below has no access to your PHPOS window.<br /><b>WARNING:</b> Many sites, like Google/YouTube can\'t be displayed in iframe sandbox.<br />If you don\'t see your site here remember that is not an error - it\'s just for security reasons.';
	
//  SHORTCUTS - SHARE
	$txt['share_form_readonly'] = 'Read only for others';
	$txt['share_form_readonly_desc'] = 'If set to YES, nobody cant be allowed to changing your files and uploading to your folder. <br />If set to NO everybody in group will be have full access to this folder and its subfolders and files';
	$txt['shared_error'] = 'Shared error';
	$txt['msg_stop_shared'] = 'Folder is not shared now';
	$txt['shortcuts_share_title'] = 'Share your folder';
	$txt['shortcuts_share_id_title'] = 'Your folder name';
	$txt['shortcuts_share_network_name'] = 'Shared folder network name';
	$txt['shortcuts_share_network_name_desc'] = 'Specify network name for your folder. Another users will be see your folder by this name. <br />Network name is required.';
	$txt['shortcuts_share_network_name_tip'] = 'Specify newtork name, e.g. \'My shared pictures\'';
	$txt['shortcuts_share_access_title'] = 'Permissions for others';
	$txt['shortcuts_share_desc'] = 'You can share your folders and files with another users. If you share your folder they will be visible to another users and there users will be have access to this folder. <br /><b>Folder will be visible only for users in this same workgroup as you. <br />Only local folders can be shared.<br />You can unshare your folder in every time.</b>';	
	$txt['shortcuts_share_form_folder'] = 'Real folder name';
	$txt['shortcuts_share_form_folder_desc'] = 'Specify URL to website you want, eg. http://google.com';	
	$txt['shortcuts_share_form_name'] = 'Network name';
	$txt['shortcuts_share_form_name_desc'] = 'Specify URL to website you want, eg. http://google.com';	
	$txt['shortcuts_share_form_desc'] = 'Description';
	$txt['shortcuts_share_form_desc_desc'] = 'You can specify description for your shared folder, e.g. \'There are my vacations photos from last year\'.';	
	$txt['shortcuts_share_form_readonly'] = 'Read only';
	$txt['shortcuts_share_form_readonly_desc'] = 'If set to YES, nobody cant be allowed to changing your files and uploading to your folder. If set to NO everybody in group will be have full access to this folder and their subfolders and files.<br /><b>Please use this option carefuly.</b>';	
	$txt['shortcuts_share_btn'] = 'Share this folder';	
	$txt['shortcuts_icon_explorer_shared'] = 'Shared folder';
	
	
//  SHORTCUTS - MEDIA
	$txt['shortcuts_media_type_title'] = 'Media type';
	$txt['shortcuts_media_type_choose'] = 'Choose site from list';
	$txt['shortcuts_media_type_desc'] = 'Please choose media type. All suported sites are showed on this list.<br />This list can be extended by plugins, in future there will be more supported sites here.';
	$txt['shortcuts_media_shortcut_title'] = 'Shortcut';
	$txt['shortcuts_media_shortcut_desc'] = 'Specify the shortcut for icon. This name can not be empty. You will able to edit this icon name later.';
	$txt['shortcuts_media_url_title'] = 'Media URL';
	$txt['shortcuts_media_url_desc'] = 'Please specify link to media on internet. If you want to create link to movie on YouTube just paste here url from YT, e.g. http://www.youtube.com/watch?movie_link.<br />Remember to pasting full links - they will be parsed by PHPOS automaticly.'; 
	
//  SHORTCUTS - NEW DIR
	$txt['folder_create_error'] = 'Error creating folder';
	$txt['folder_readonly_msg'] = 'This folder is <b>read-only</b> for your account.';	
	$txt['shortcuts_newdir_title'] = 'Create new folder';
	$txt['shortcuts_newdir_desc'] = 'You can create new folders and their subfolders in every filesystem supporting by PHPOS.<br />To create new directory just type the name and click on the Create Button.';
	$txt['shortcuts_newdir_tip'] = 'Folder name must be not empty and without special chars like slashes';
	
// SHORTCUTS - RENAME
	$txt['shortcuts_rename_title'] = 'Change name';
	$txt['shortcuts_rename_desc'] = 'Specify new name for your file or folder. Name must be not empty and without special chars like slashes';
	$txt['shortcuts_rename_tip'] = 'Enter new name and click on the Change Name Button';
	
//  SHORTCUTS - UPLOAD
	$txt['shortcuts_upload_title'] = 'Upload single file into folder';
	$txt['shortcuts_upload_desc'] = 'You can upload file from here. Just select file and click on upload button.<br />You can also uploading by drag&drop by dragging them to window area';	
	$txt['shortcuts_upload_file_title'] = 'File to upload';
	$txt['shortcuts_upload_file_desc'] = 'Choose file from disk and upload.<br />Some filetypes may be blocked to upload.';
	
/* ====== SHORTCUTS - WINDOW TITLES ===== */			
	$txt['shortcuts_window_title_index'] = 'Create new shortcut';
	$txt['shortcuts_window_title_new_folder'] = 'Create new folder';
	$txt['shortcuts_window_title_new_iframe'] = 'Create new webframe';
	$txt['shortcuts_window_title_new_mediaframe'] = 'Create new media link';	
	$txt['shortcuts_window_title_new_url'] = 'Create new URL to website';
	$txt['shortcuts_window_title_upload'] = 'Upload file to server';
	$txt['shortcuts_window_title_app'] = 'Create link to PHPOS application';
	$txt['shortcuts_window_title_app_step2'] = 'Specify parameters for application';
	$txt['shortcuts_window_title_app_update'] = 'Update link to PHPOS application';
	$txt['shortcuts_window_title_share'] = 'Share folder with another users';	
	$txt['shortcuts_window_title_update_iframe'] = 'Update webframe';
	$txt['shortcuts_window_title_update_mediaframe'] = 'Update media link';
	$txt['shortcuts_window_title_update_url'] = 'Update URL';	
	$txt['shortcuts_window_title_rename'] = 'Rename file or folder';
	
/* ====== SHORTCUTS - BUTTONS ===== */			
	$txt['shortcuts_window_btn_new_dir'] = 'Create new folder';
	$txt['shortcuts_window_btn_rename'] = 'Change name';
	$txt['shortcuts_window_btn_new_url'] = 'Create URL link';
	$txt['shortcuts_window_btn_upload'] = 'Upload file';
	$txt['shortcuts_window_btn_app_new'] = 'Create link to application';
	$txt['shortcuts_window_btn_app_update'] = 'Update link to application';	
	$txt['shortcuts_window_btn_new_iframe'] = 'Create new webframe link';
	$txt['shortcuts_window_btn_update_iframe'] = 'Update webframe link';
	$txt['shortcuts_window_btn_update_url'] = 'Update URL link';	
	$txt['shortcuts_window_btn_new_mediaframe'] = 'Create new media link';
	$txt['shortcuts_window_btn_update_mediaframe'] = 'Update media link';
	$txt['shortcuts_window_back_to_index'] = 'Back to shortcuts';
	$txt['shortcuts_window_back_to_apps'] = 'Back to apps list';

/* ====== SHORTCUTS - MESSAGES ===== */				
	$txt['shortcuts_window_msg_new_dir'] = 'New folder was created';
	$txt['shortcuts_window_msg_shared'] = 'Folder is shared';
	$txt['shortcuts_window_msg_rename'] = 'Name was updated';
	$txt['shortcuts_window_msg_iframe_created'] = 'New webframe was created';
	$txt['shortcuts_window_msg_iframe_updated'] = 'Webrame was updated';
	$txt['shortcuts_window_msg_media_created'] = 'New media link was created';
	$txt['shortcuts_window_msg_media_updated'] = 'Media link was updated';
	$txt['shortcuts_window_msg_url_created'] = 'New URL link was created';
	$txt['shortcuts_window_msg_url_updated'] = 'URL link was updated';
	$txt['shortcuts_window_msg_upload'] = 'File was uploaded';	
	$txt['shortcuts_window_msg_app_created'] = 'New Application link was created';
	$txt['shortcuts_window_msg_app_updated'] = 'Application link was updated';
	
	
/* ====== SYSINFO ===== */		
	
	$txt['cp_system_info_title'] = 'System info';
	$txt['cp_system_info_desc'] = 'Informations about your PHPOS and server';
	$txt['cp_system_info_desc_cp'] = 'Server informations';	
	$txt['cp_system_info_phpos_title'] = 'PHPOS';
	$txt['cp_system_info_phpos_desc'] = 'Informations about your PHPOS installation.<br />Please remember to always check for updates on PHPOS website or GitHub repositories.';	
	$txt['cp_system_info_php_title'] = 'PHP';
	$txt['cp_system_info_php_desc'] = 'Info of PHP installed on server';
	
	
// DB
	$txt['cp_system_info_db_title'] = 'Database';
	$txt['cp_system_info_db_desc'] = 'This is your database connection info whitch you specified in installation.<br />Your password for database will not showed here.';		
	$txt['cp_system_info_db_adapter_title'] = 'Database engine';
	$txt['cp_system_info_db_auth_title'] = 'Connection data';	
	$txt['cp_system_info_db_form_adapter_title'] = 'Database adapter';
	$txt['cp_system_info_db_form_host_title'] = 'Database server';
	$txt['cp_system_info_db_form_user_title'] = 'Database user';
	$txt['cp_system_info_db_form_pass_title'] = 'Database password';
	$txt['cp_system_info_db_form_dbname_title'] = 'Database name';
	$txt['cp_system_info_db_form_prefix_title'] = 'Prefix for PHPOS tables';
	$txt['cp_system_info_db_form_pass_hidden'] = '(password not showed here)';
	$txt['cp_system_info_db_adapter_desc'] = 'This is your your database type. <br />Adpater is a special class witch can you gave access to specified database engine.';		
	$txt['cp_system_info_db_auth_desc'] = 'This is your your database connection data.<br /> You can change this data only by editing config database files generated on installation.';
	
// SERVER
	$txt['cp_system_info_server_form_ip_title'] = 'Server IP address';
	$txt['cp_system_info_server_form_os_title'] = 'Server operation system';
	$txt['cp_system_info_server_form_name_title'] = 'Server name/host';
	$txt['cp_system_info_server_form_soft_title'] = 'Server software';
	$txt['cp_system_info_server_form_protocol_title'] = 'Server protocol';
	$txt['cp_system_info_server_title'] = 'Your server';
	$txt['cp_system_info_server_desc'] = 'This is info about server where you installed this PHPOS edition.<br />If your server have disabled showing info about itself you may not see some info here.';
	$txt['cp_system_info_server_form_basic_title'] = 'Server info';
		

// INFO
	$txt['cp_system_info_phpos_github_dsc'] = 'All updates of PHPS are uploaded on the GitHub servers at first.<br/> So, you can check this url to have always actually version.';	
	$txt['cp_system_info_phpos_www_dsc'] = 'You can visit PHPOS official website for check to new updates or download the new add-ons and more.';	
	$txt['cp_system_info_phpos_contact_dsc'] = 'You can contact with author(s) of PHPOS by emails showed here.<br /> Every contact is approved, so if you want to contact just send the email.';	
	$txt['cp_system_info_phpos_homedirs_dsc'] = 'This is the folder where users stores their own files.<br /> Every user have specified their own hashed folder.';	
	$txt['cp_system_info_phpos_paths_dsc'] = 'This is the list of paths declared in this system. <br />DIR paths are used by applications and system via PHP, WEB paths are used by webbrowser.';	
	$txt['cp_system_info_phpos_version_dsc'] = 'This is the version info about your PHPOS installation. <br />
	You can update your version by visiting PHPOS website/or GitHUB account and download files.';	
	$txt['cp_system_info_key_show_dsc'] = 'This is your installation key.';
	$txt['cp_system_info_key_show_dsc2'] = '<b>Please <u>save this key</u> in secure place.</b><br />Without this key you will be can not recover your data from this installation of PHPOS.';		

	
// KEY
	$txt['cp_system_info_key_title'] = 'Security key';
	$txt['cp_system_info_key_desc'] = 'In every installation of PHPOS new installation key is generated.<br />This is for security reasons - users folders and users passwords are hashed by this key.<br />Installation key is placed in your <b>config folder</b>. If you want to move your PHPOS installation to another server you must move this key too';
	
// PHPOS
	$txt['cp_system_info_phpos_form_title_version'] = 'Installed version';
	$txt['cp_system_info_phpos_form_title_variables'] = 'System variables';
	$txt['cp_system_info_phpos_form_title_paths'] = 'System paths';
	$txt['cp_system_info_phpos_form_title_www'] = 'PHPOS website';
	$txt['cp_system_info_phpos_form_title_contact'] = 'Contact with author(s)';
	$txt['cp_system_info_phpos_form_title_home'] = 'PHPOS Home dir';	
	$txt['cp_system_info_phpos_form_title_time'] = 'Install/update dates';	
	$txt['cp_system_info_phpos_form_time_install'] = 'Installed at';
	$txt['cp_system_info_phpos_form_time_update'] = 'Updated at';	
	$txt['cp_system_info_phpos_form_version'] = 'PHPOS Version';
	$txt['cp_system_info_phpos_form_version_name'] = 'PHPOS Version name';
	$txt['cp_system_info_phpos_form_build'] = 'PHPOS Build time';	

	
/* ====== MESSENGER ===== */			
	$txt['app_messager'] = 'Messenger';
	$txt['tray_messager_open'] = 'Open Messenger';
	$txt['messager_section_new'] = 'Send new';
	$txt['messager_section_received'] = 'Inbox';
	$txt['messager_section_sended'] = 'Outbox';	
	$txt['messager_section_new_desc'] = 'Send new message';
	$txt['messager_section_received_desc'] = 'Received messages';
	$txt['messager_section_sended_desc'] = 'Sended messages';
	$txt['messager_sent'] = 'Sent';
	$txt['messager_form_title'] = 'Subject';
	$txt['messager_form_to'] = 'To';
	$txt['messager_form_from'] = 'From';
	$txt['messager_form_msg'] = 'Message body';	
	$txt['messager_form_title_desc'] = 'Specify subject for this message.<br />Subject must be not empty.';
	$txt['messager_form_to_desc'] = 'Select user to whitch you want send this message.';	
	$txt['messager_tbl_message'] = 'Message';
	$txt['messager_tbl_from'] = 'From';
	$txt['messager_tbl_to'] = 'To';
	$txt['messager_tbl_me'] = '(me)';
	$txt['messager_tbl_received'] = 'Received';
	$txt['messager_tbl_actions'] = 'Actions';
	$txt['messager_tbl_sended'] = 'Sended';
	$txt['messager_tbl_readed'] = 'Readed';	
	$txt['messager_btn_send'] = 'Send message';
	$txt['messager_btn_reply'] = 'Reply';	
	$txt['messager_tbl_not_yet'] = '(not yet)';	
	$txt['messager_received_title'] = 'Received private messages';
	$txt['messager_received_desc'] = 'You can read message sended by other user to you by click on message topic title.<br />You can also reply for message by clicking on Reply button when message will be displayed.<br/><b>Unreaded messages are marked by green icon.</b>';	
	$txt['messager_sended_title'] = 'Sended private messages';
	$txt['messager_sended_desc'] = 'This is a list of messages sended by you. <br />You can preview sended message by click on topic title. You can also check when message was readed by user.<br/><b>Unreaded messages are marked by green icon.</b>';	
// msg tray
	$txt['messager_tray_got_now_messages'] = 'You have new unreaded message!';
	$txt['messager_tray_click_to_read'] = 'Click here to read message';
	$txt['messager_tray_tip_new_messages'] = 'New unreaded messages';
	$txt['messager_tray_tip_no_messages'] = 'No new messages';
	
	
	
// SHARED
	$txt['shared_no_folders'] = 'You dont share any folders';
	$txt['shared_folders'] = 'Shared folders';	
	$txt['shared_folders_serv_desc'] = 'This is the list of users in this workgroup. Users in the same group can sharing their own folders and files with another users in workgroup. Click on user name to see folders shared by this user.';	
	$txt['groups_serv_desc'] = 'This is the list of workgroups created on this server. With workgroups users can share their own folders and files with another users in the same group. Only administrators can create workgroups and invite users to them. ';
	
		

	
//  ACCOUNTS
	$txt['user_login_data'] = 'User data';
	$txt['users'] = 'Users';
	$txt['users_desc'] = 'Manage users';	
	$txt['usr_cp_account'] = 'Account';
	$txt['usr_cp_account_desc'] = 'Settings';
	$txt['usr_cp_admin'] = 'User accounts';
	$txt['usr_cp_admin_desc'] = 'Manage users';
	$txt['type'] = 'Type';
	$txt['your_account'] = 'Your account';
	$txt['edit_user'] = 'Edit user account';
	$txt['usr_basic_info'] = 'User basic info';
	$txt['create_home'] = 'Create home dir';
	$txt['home_dir'] = 'Home dir';
	$txt['usr_new'] = 'Create new user account';
	$txt['usr_account_params'] = 'Account parameters';
	$txt['usr_account_info'] = 'Account informations';
	$txt['last_login'] = 'Last login';
	$txt['old_pass'] = 'Old password';
	$txt['new_pass'] = 'New password';
	$txt['new_pass_c'] = 'Confirm new password';
	$txt['pass'] = 'Password';
	$txt['pass_c'] = 'Confirm password';
	$txt['change_pass'] = 'Change password';
	$txt['change_email'] = 'Change email';
	$txt['pass_min_chars'] = 'Required minimum chars';
	$txt['login_empty'] = 'Login is empty';
	$txt['no_homedir'] = 'No home dir';
	$txt['login_min'] = 'Login must have min 4 chars';
	$txt['login_max'] = 'Login can have max 30 chars';	
	$txt['pass_min'] = 'Login must have min 6 chars';
	$txt['pass_max'] = 'Login can have max 30 chars';	
	$txt['banned_users'] = 'Banned users';	
	$txt['last_activity'] = 'Last activity';
	$txt['created_at'] = 'Created at';	
	$txt['no_rec_selected'] = 'No record selected';	
// PASSWORDS
	$txt['pass_not_match'] = 'Passwords not match';
	$txt['pass_length'] = 'Password have incorrent length';
	$txt['pass_old_need'] = 'Old password is required';
	$txt['pass_old_wrong'] = 'Old password is wrong';
	$txt['pass_empty'] = 'Password is empty';
	$txt['login_exists'] = 'Login exists';
	$txt['all_fields_req'] = 'All fields required';
	
	
// WALLPAPERS
	$txt['g_wallpapers'] = 'Global wallpapers';
	$txt['u_wallpapers'] = 'User wallpapers';
	$txt['wallpaper_image'] = 'Image';
	$txt['wallpapers'] = 'Wallpapers';
	$txt['set_wallpaper'] = 'Set wallpaper';
	$txt['preview'] = 'Preview';
	$txt['st_usr_wall_g'] = 'List of global wallpapers. Those wallpapers are default PHOS wallpapers and there are included in system. Click to see preview.';	
	$txt['st_usr_wall_u'] = 'List of your wallpapers. Those wallpapers is from your "Wallpapers" folder in your local dir. If you want to add wallpapers here just upload new image to these folder. Click to see preview.';
	$txt['st_usr_wall_p'] = 'Preview of the selected wallpaper';
	$txt['st_usr_wall_s'] = 'To set wallpaper just click on "set wallpaper" button. <br />Wallpaper will be set to your account.';
	$txt['st_usr_wall_c'] = 'Click to see preview';
	
// FTP	
	$txt['ftp_form_public'] = 'Public FTP';
	$txt['ftp_form_public_desc'] = 'Public FTP will be avialbable for <b>all users</b>, but users can not be have access to edit them. They can be only connect to this account.';
	$txt['ftp_no_accounts'] = 'No accounts';
	$txt['explorer_right_ftp'] = 'FTP Accounts';
	$txt['explorer_right_ftp_desc'] = 'Click on account name to connect to your FTP server';
	$txt['ftp_folders_desc'] = 'Setup FTP connections';
	$txt['ftp_my'] = 'My FTP';
	$txt['ftp_all'] = 'All FTP';
	$txt['ftp_public'] = 'Public FTP';
	$txt['ftp_account'] = 'FTP account';
	$txt['ftp_user'] = 'User';
	$txt['ftp_authentication'] = 'Authentication';
	$txt['title'] = 'Title';
	$txt['new_ftp'] = 'New FTP';
	$txt['add_new_ftp'] = 'Add new FTP account';
	$txt['edit_ftp'] = 'Edit FTP account';	
	$txt['ftp_section_new_account'] = 'Add new account';
	$txt['ftp_section_edit_account'] = 'Edit account';
	$txt['ftp_section_list'] = 'Browse ftp';
	$txt['ftp_connected'] = 'Connected to FTP account.';
	$txt['ftp_not_connected'] = 'Error to connect to your FTP account.';	
	$txt['dsc_ftp_title'] = 'You can create and manage FTP accounts here. <br />With your own FTP accounts you can access to your files on ftp servers just like local files.';		
	$txt['dsc_ftp_list_own'] = 'This is list of FTP accounts witch you created.<br />Nobody against you cant access to this accounts.<br /><b>Please click on account name to edit them</b>';	
	$txt['dsc_ftp_list_all'] = 'This is list of ALL FTP accounts created by users.<br /><b>Please click on account name to edit them</b>';		
	$txt['dsc_ftp_list_public'] = 'This is list of public FTP accounts.<br />Every user in this system have access to this accounts.<br/><b>Please click on account name to edit them</b>';	
	$txt['dsc_ftp_list_public_user'] = 'This is list of public FTP accounts.<br />Every user in this system have access to this accounts.<br/><b>You can\'t edit this but you can access to them.</b>';	
	$txt['dsc_ftp_list_empty'] = 'No FTP accounts in this list';
	$txt['dsc_ftp_desc_new'] = 'Create new FTP account';	
	$txt['dsc_ftp_name'] = 'Specify the name to this FTP account';
	$txt['dsc_ftp_desc'] = 'This fields is not required, but you can specify a description for this account';
	$txt['dsc_ftp_host'] = 'Specify hostname or IP of your FTP server';
	$txt['dsc_ftp_login'] = 'Specify user name (login) to your FTP account. Anonymous FTPs is not supported by PHPOS.';
	$txt['dsc_ftp_pass'] = 'Specify password your FTP server';
	$txt['dsc_ftp_port'] = 'Specify port to connection with your FTP server. Default port is: 21';	
	$txt['dsc_ftp_a_new'] = 'Create new FTP account';
	$txt['dsc_ftp_a_edit'] = 'Edit FTP account';
	$txt['dsc_ftp_a_list'] = 'Browse FTP accounts';	
	$txt['public'] = 'Public';
	
	
// LOGS	
	$txt['logs'] = 'Logs and sessions';
	$txt['logs_list'] = 'This is the list of logs created by PHPOS at this day. These files are placed in <b>_phpos/logs/</b> folder.<br /> You can download any log file via click on the button showed below.<br />Log files created by PHPOS are very easy to <b>grep on Unix based systems</b> ';	
	$txt['logs_folders'] = 'This is the list of all logs created by PHPOS. Click on the year, month and day to view the logs from specified day. ';	
	$txt['logs_sessions_fulltime'] = 'Full datetime';	
	$txt['logs_log_from_title'] = 'You are viewing log file from: ';
	$txt['logs_log_folders_title'] = 'Log files';	
	$txt['logs_section_logs_title'] = 'Log files';
	$txt['logs_section_logs_title_desc'] = 'Log files';	
	$txt['logs_section_sessions_title'] = 'Sessions';
	$txt['logs_section_sessions_desc'] = 'Sessions';	
	$txt['logs_app_title'] = 'Logs and sessions';
	$txt['logs_app_title_desc'] = 'All important actions are logged into files. You can have access to this files and view what users do.';

// SESSIONS
	$txt['logs_section_sessions_subdesc'] = 'Every session of users are logged in DB.<br />Those sessions are connected with <b>log system</b>. You can see from here and when users was logged to PHPOS.';	
	$txt['logs_section_sessions_last_title'] = 'List of last %limit% user sessions';
	$txt['logs_section_sessions_view_title'] = 'You are viewing user session';
	$txt['logs_section_sessions_view_desc'] = 'This is the session of user you can selected on "log section".<br />You can see when user was logged, their last activity and more data.';	
	$txt['logs_section_sessions_last_desc'] = 'This is the list of last %limit% user sessions. <br />You can also view specify user session by clicking on <b>View session button</b> in log file.';		
	$txt['logs_section_btn_see_session'] = 'View';	
	$txt['logs_section_btn_download'] = 'Download raw log file';	
	$txt['logs_section_btn_see_raw'] = 'View raw log file';	
	$txt['logs_section_btn_see_session_empty'] = '(no session)';		
	$txt['logs_section_sessions_tbl_id'] = 'ID';
	$txt['logs_section_sessions_tbl_sid'] = 'SID';
	$txt['logs_section_sessions_tbl_starttime'] = 'Start time';
	$txt['logs_section_sessions_tbl_endtime'] = 'Endtime';
	$txt['logs_section_sessions_tbl_user'] = 'User';
	$txt['logs_section_sessions_tbl_ip'] = 'User IP';
	$txt['logs_section_sessions_tbl_browser'] = 'User browser';
	$txt['logs_section_sessions_tbl_action'] = 'Action';	
	$txt['logs_section_tbl_id'] = 'ID';
	$txt['logs_section_tbl_sid'] = 'SID';
	$txt['logs_section_tbl_time'] = 'Start time';
	$txt['logs_section_tbl_fulltime'] = 'Full time';
	$txt['logs_section_tbl_user'] = 'User';
	$txt['logs_section_tbl_ip'] = 'User IP';
	$txt['logs_section_tbl_session'] = 'Session check';
	$txt['logs_section_tbl_action'] = 'Action';
	
	
	
// UPDATER
	$txt['cp_updater_autocheck'] = 'Auto check for updates';
	$txt['cp_updater_autocheck_title'] = 'Enable/or disable auto-check for updates';
	$txt['cp_updater_autocheck_desc'] = 'If this option is enabled, PHPOS will be connect to update server at every time, and will be downloading info about new updates. Its may slow PHPOS rendering speed.<br /><b>Any private data will sent to update server - only info about your version and IP of the server.</b>';	
	$txt['cp_updater_autocheck_timeout'] = 'Updater connection timeout';
	$txt['cp_updater_autocheck_timeout_title'] = 'Enable/or disable auto-check for updates';
	$txt['cp_updater_autocheck_timeout_desc'] = 'When autoupdates are enabled your server is connecting with PHPOS server for check updates. <br />When server have problems or connection is slow your system mayble freeze for a while. <br />You can specify timeout for this connection here (in seconds). <br />When connection will be longer than that then connection will be canceled.</b>';	
	$txt['updater_tray_offline'] = 'OFFLINE'; 
	$txt['updater_tray_disabled'] = 'OFFLINE (autoupdate OFF)'; 
	$txt['updater_tray_online'] = 'ONLINE'; 	
	$txt['updater_tray_title'] = 'Auto updates'; 
	$txt['updater_app_title'] = 'Auto updater';
	$txt['updater_tray_visit_www'] = 'Visit PHPOS Website'; 
	$txt['updater_tray_visit_git'] = 'Visit PHPOS GitHUB'; 
	$txt['updater_tray_your_version'] = 'Your version'; 
	$txt['updater_tray_newest_version'] = 'Newest version'; 
	$txt['updater_tray_launch_updater'] = 'Launch updater'; 
	$txt['updater_tray_msg_click'] = 'Click here'; 
	$txt['updater_tray_msg_click_download'] = 'to download update.'; 
	$txt['updater_tray_msg_new'] = 'New version of PHPOS is available: %version%.<br/>Released date: %date%.'; 	
	$txt['cp_updater_check_title'] = 'Check online'; 	
	$txt['cp_updater_check_status_actual'] = 'Your version is up to date.'; 
	$txt['cp_updater_check_status_notactual'] = 'You need to update your version'; 	
	$txt['cp_updater_last_version'] = 'Latest version'; 
	$txt['cp_updater_your_version'] = 'Your version'; 
	$txt['cp_updater_rel_date'] = 'Release date'; 
	$txt['cp_updater_your_date'] = 'Your build'; 
	$txt['cp_updater_changelog'] = 'Changes log'; 
	$txt['cp_updater_online_info'] = 'Info from server';
	$txt['cp_updater_update_type'] = 'Update type';
	$txt['cp_updater_update_info'] = 'Update info';
	$txt['cp_updater_download_last'] = 'Download latest version';
	$txt['cp_updater_download_btn_www'] = 'Download from PHPOS server';
	$txt['cp_updater_download_btn_git'] = 'Download from GitHUB';
	$txt['cp_updater_download_zip'] = 'Download .zip archive';	
	$txt['cp_updater_desc_main'] = 'Auto updater is application whitch can connect to PHPOS main server and check for new updates.<br />Informations about latest available version is always showed here and compared with your version.<Br/>You can also always check for new updates on GitHUB. <br /><b>Please download and update your system always when new version is released.</b>';	
	$txt['cp_updater_desc_download'] = 'You can download latest versionf of PHPOS directly from links below.<br />You can download archive from PHPOS server or download/or clone repository on GitHUB.</b>';	
	$txt['cp_updater_desc_info'] = 'This the information about latest version.<br />It is very important to download and install all updates marked as CRITICAL.';	
	$txt['cp_updater_desc_changes'] = 'This the the changes log download from server.<Br />This features are added/updated in latest version of PHPOS.';
	
//  SETTINGS
	$txt['cp_settings_title'] = 'Settings';
	$txt['cp_settings_section_site'] = 'Site config';
	$txt['cp_settings_section_wallpapers'] = 'Wallpapers';
	$txt['cp_settings_section_themes'] = 'Themes';
	$txt['cp_settings_section_updater'] = 'Updater';
	$txt['cp_settings_section_security'] = 'Security';
	$txt['cp_settings_section_others'] = 'Other config';	
	$txt['cp_security_title'] = 'Security options';
	$txt['cp_security_desc'] = 'In this section you can define security options.<Br />You can allow or disable some options for better security of the system';	
	$txt['cp_security_logins_title'] = 'Users access';	
	$txt['cp_security_disable_login_users'] = 'Disable users access';
	$txt['cp_security_disable_login_admins'] = 'Disable admins access';	
	$txt['cp_security_disable_login_users_desc'] = 'You can disable user access to the system.<br/>If you set this option to YES - any user can not be allowed to login into system.';
	$txt['cp_security_disable_login_admins_desc'] = 'You can disable administrators access to the system.<br/>If you set this option to YES - any administrator can not be allowed to login into system.';	
	$txt['cp_security_upload'] = 'File uploading';
	$txt['cp_security_disable_upload'] = 'Disable upload files to server';
	$txt['cp_security_disable_upload_desc'] = 'You can disable upload of files to server.<br/>If you set this option to YES - anybody against you cant be allowed to uploading.';	
	$txt['cp_security_upload_whitelist'] = 'Upload whitelist';
	$txt['cp_security_upload_blacklist'] = 'Upload blacklist';	
	$txt['cp_security_disable_explorer'] = 'Disable changing files';
	$txt['cp_security_disable_explorer_desc'] = 'If you disable changing files users will be have \'read only\' access to all folders. <br /> Creating new files, folders, renaming and upload will be disabled in all cases.';	
	$txt['cp_demomode'] = 'Demo mode';
	$txt['cp_demomode_desc'] = 'If demo mode is enable, users cant saving any changes in system. All options and functions are only "read only" in demo mode.';	
	$txt['cp_security_upload_whitelist_desc'] = 'You can specify whitch filetypes are allowed to be uploaded to server.<br />Type the list of allowed files into textarea. Separate them by \',\'. If this list is empty all filetypes are allowed.<br/><b>E.g. gif,jpg,pdf,doc,txt</b>';	
	$txt['cp_security_upload_blacklist_desc'] = 'You can specify whitch filetypes are disabled for uploading to server. If this list is not empty, whitelist will be ignored and allowed will be all files against files specified in blacklist.<br/><b>E.g. php,html,js,php5,exe,bin,bat,sh</b>';		
	$txt['cp_settings_section_site_desc'] = 'You can configure your PHPOS installation here';
	$txt['cp_settings_section_site_meta'] = 'Site metadata';
	$txt['cp_settings_section_site_language'] = 'Site default language';
	$txt['cp_settings_section_site_theme'] = 'Site default theme';
	$txt['cp_settings_section_site_wallpaper'] = 'Site default wallpaper';	
	$txt['cp_settings_section_site_language_desc'] = 'Specify default PHPOS language. Every user can change their own language. <br />This language in default and is using on login screen.<br />You can download another language packs from PHPOS website.';	
	$txt['cp_settings_section_themes_desc'] = 'You can specify global theme here. Global theme is a default theme for all users. Every user can change their own theme. <br />Themes are located in you <b>web/_phpos/themes/</b> folder. Only server admin can upload new themes to this folder. You can download themes from PHPOS website.';	
	$txt['cp_settings_section_wallpapers_desc'] = 'You can specify global wallpaper here. Global wallpaper is a default wallpaper for all users. Every user can change their own wallpaper. <br />Wallpapers are located in you <b>web/_phpos/wallpapers/</b> folder. Only server admin can upload new wallpapers to this folder.';	
	$txt['cp_themes_global_themes'] = 'Global themes';
	$txt['cp_themes_preview'] = 'Theme preview';
	$txt['cp_themes_preview_desc'] = 'Preview of the selected theme';
	$txt['cp_themes_global_themes_desc'] = 'This the list of available themes on this PHPOS installation.<br />Click on theme name to see preview  of theme.';
	$txt['cp_themes_theme_name'] = 'Theme name';
	$txt['cp_themes_set_global'] = 'Set as global theme';
	$txt['cp_themes_set_global_desc'] = 'Click to set default theme for all users.';	
	$txt['cp_settings_desc'] = 'Configure PHPOS';
	
// WORKGROUPS
	$txt['workgroups'] = 'Workgroups';
	$txt['workgroups_empty'] = 'You are not in any group.';
	$txt['workgroups_last_owner_activity'] = 'Last owner\'s activity:';
	$txt['workgroups_last_user_activity'] = 'Last user\'s activity:';
	$txt['workgroups_nosharing_title'] = 'No shared folders';
	$txt['workgroups_nosharing_desc'] = 'This user not sharing any folders.';
	$txt['workgroup_users'] = 'Users';
	$txt['guest'] = 'Guest';
	$txt['choose_group'] = 'Choose your workgroup';
	$txt['workgroup_num_folders'] = 'Folders';
	$txt['workgroup_shared_fullaccess'] = 'Full access';
	$txt['workgroup_shared_readonly'] = 'Read Only';
	$txt['explorer_right_group_users'] = 'Users in group';
	$txt['explorer_right_group_users_desc'] = 'Select user to see shared folders';
	$txt['explorer_right_groups'] = 'Workgroups';
	$txt['explorer_right_groups_desc'] = 'Select workgroup to enter them';
	$txt['group_no_users'] = 'No users in group';
	$txt['group_not_exists'] = 'Group not exists or you dont have access';
	$txt['group_error'] = 'Workgroup error';
	$txt['groups_title'] = 'Workgroups';
	$txt['groups_desc'] = 'Managing workgroups';	
	$txt['groups_cp_index'] = 'Workgroups';
	$txt['groups_cp_index_desc'] = 'Setup your groups';	
	$txt['groups_cp_admin'] = 'Workgroups';
	$txt['groups_cp_admin_desc'] = 'Admin Workgroups';	
	$txt['group_section_new_group'] = 'Add new workgroup';
	$txt['group_section_edit_group'] = 'Edit workgroup';
	$txt['group_section_list'] = 'Browse groups';
	$txt['group_section_group_users'] = 'Group users';
	$txt['group_new'] = 'New group';
	$txt['group_edit'] = 'Edit group';
	$txt['group_msg'] = 'Welcome message';
	$txt['name'] = 'Name';
	$txt['group_in_group'] = 'Users in group';
	$txt['group_out_group'] = 'Users outside group';
	$txt['group_add_user'] = 'Add';
	$txt['group_remove_user'] = 'Remove';
	$txt['action'] = 'Action';	
	$txt['groups_my'] = 'You are in groups';
	$txt['groups_all'] = 'All groups';
	$txt['groups_owner'] = 'My own groups';	
	$txt['form_empty_field'] = 'Empty field: ';
	$txt['dsc_cp_newgroup'] = 'You can create your own workgoup here. <br />After create you can invite another users on this server to this group via "Group users" section. After that you can share your data and work in group. <br />If you want to share folder in workgroup, just click on the folder and select "Share this folder" option.';	
	$txt['dsc_cp_newgroup_name'] = 'Specify workgroup name here. Every user will be see your group by this name. <br />Name for workgroup is required.';	
	$txt['dsc_cp_newgroup_desc'] = 'You can specify description of workgroup. If is not required, but recommended.';	
	$txt['dsc_cp_newgroup_msg'] = 'You can specify welcome message. This message will be sent to all users witch you invite to this workgroup.';	
	$txt['dsc_cp_groups_users_in'] = 'This is the list of users whitch are in this workgroup. These users can share folders and files against themself becose they are in the same workgroup. You can sign out user from group by clicking on the Remove button. Workgroups can have unlimited number of users.';	
	$txt['dsc_cp_groups_users_out'] = 'This is the list of users whitch are not in this workgroup. This workgroup is invisible for those users. You can invite users to this workgroup by clicking on the Add button. User will be addedd to the list on left.';	
	$txt['dsc_cp_groups_users_empty'] = 'There is no one user.';	
	$txt['no_records_msg'] = 'This list is empty (no records)';		
	$txt['dsc_cp_groups'] = 'Here is the list of workgroups. Please click on group to edit them.<br />When you click on workgroup you will be redirected to section where you can adding and removing users to group.<br />Users in workgroup can share files and folders against workgroup. Only admins and root user can create workgroups.';
	$txt['groups_my_desc'] = 'There is a list of groups where you have account. <br />You have access to this groups and you can share files against users whitch are in this group.';
	$txt['groups_all_desc'] = 'There is a list of all workgroups on this server. <br />Server root have access to all of this groups and can add or remove users from them. ';
	$txt['groups_own_desc'] = 'There is a list of groups whitch you created on this server.<br /> Owner can adding and removing users from their own group.';
	$txt['group_back_to'] = 'Back to workgroup';	

		
// FILE INFO
	$txt['fileinfo_title'] = 'File properties';
	$txt['fileinfo_context'] = 'File properties';
	$txt['fileinfo_name'] = 'File name';
	$txt['fileinfo_fs'] = 'Filesystem';
	$txt['fileinfo_dir'] = 'Location';
	$txt['fileinfo_type'] = 'File type';
	$txt['fileinfo_created'] = 'Created time';
	$txt['fileinfo_modified'] = 'Last modification';
	$txt['fileinfo_chmod'] = 'File permissions';		
	
	
// USER ACCOUNT
	$txt['dsc_'] = 'Login must be not in database. Plese specify unique name.';
	$txt['dsc_'] = 'You can change your data here. If you want to change your passord to your account you must know old password. If you don\'t remember your password - contact to server admin.';	
	$txt['dsc_users_change_pass'] = 'If you want to change your password you must specify old password and then specify new.';
	$txt['dsc_users_edit_list'] = 'You can edit this user accounts data, becose you are the admin on this server';
	$txt['dsc_users_list_click'] = 'Please click on user account name to edit them';
	$txt['dsc_users_click'] = 'Click on login name to edit account data';
	$txt['dsc_users_list_users'] = 'This is the list of normal users.<br /><b>Please click on user account name to edit them</b>';
	$txt['dsc_users_list_admins'] = 'This is the list of administrators.<br /><b>Please click on user account name to edit them</b>';
	$txt['dsc_users_list_banned'] = 'This is the list of inactive users.<br /><b>Please click on user account name to edit them</b>';
	$txt['dsc_users_records_empty'] = 'No users in this list';
	$txt['dsc_users_account_type'] = 'Specify account type. Normal user is a standard account whitch don\'t have access to administration data. <br />Administrator account have access to administration data panels.';
	$txt['dsc_users_account_active'] = 'Only active users can login to the system. Inactive users are still in database but they can\'t login to system.<br />Inactive user is banned user.';
	$txt['dsc_users_account_lang'] = 'Specify default system language. Every user can change language to own language.';
	$txt['dsc_users_account_pass'] = 'Password is required for every account. <br />Empty password is not allowed. Password must have minimum 6 chars and maximum 30 chars. <br />Passwords are saved in database hashed by installation key and can\'t be recovered.';
	$txt['dsc_users_account_pass_c'] = 'You must confirm your password. If confirm will not match to password operation will be failed';
	$txt['dsc_users_account_email'] = 'Email address is not required, but if you specify it another users in workgroup will have quickly contact to this account. ';
	$txt['dsc_users_account_login'] = 'Login is required. Must have minimum 4 chars and maximum 30 chars. <br />Login must be unique and not exists in database. ';
	$txt['dsc_users_account_new'] = 'You can create new user account here.';
	$txt['dsc_users_account_old_pass_please'] = 'You must specify your actual password if you want to change this.';
	$txt['dsc_users_account_wallpapers'] = 'You can change desktop wallpaper here.';
	
	
	$txt['ftp_upmenu_new'] = 'Add FTP Account';
	$txt['ftp_upmenu_manage'] = 'Manage FTP Accounts';
// CLOUDS
	$txt['clouds_title'] = 'Cloud folders';
	$txt['clouds_upmenu_new'] = 'Add Cloud Account';
	$txt['clouds_upmenu_manage'] = 'Manage Cloud Accounts';
	$txt['clouds_right_desc'] = 'With Cloud Accounts you have access to your files in clouds just like to normal folder. You can create new accounts via Control Panel.';
	$txt['clouds_right_desc2'] = 'Click on cloud icon to connect to your cloud. In most cases you will be asked for confirm access to displaying and managing your files via PHPOS. ';
	$txt['cloud_folders_desc'] = 'Setup cloud connections';
	$txt['cloud_my'] = 'My Clouds';
	$txt['cloud_all'] = 'All Clouds';
	$txt['cloud_public'] = 'Public Clouds';
	$txt['cloud_account'] = 'Cloud account';
	$txt['cloud_type'] = 'Cloud type';
	$txt['cloud_authentication'] = 'Authentication';
	$txt['title'] = 'Title';
	$txt['new_cloud'] = 'New Cloud';
	$txt['add_new_cloud'] = 'Add new Cloud account';
	$txt['edit_cloud'] = 'Edit Cloud account';	
	$txt['cloud_section_new_account'] = 'Add new account';
	$txt['cloud_section_edit_account'] = 'Edit account';
	$txt['cloud_section_list'] = 'Browse Clouds';	
	// cloud: google drive 
	$txt['cloud_google_help_title'] = 'How to enable access to your Google Drive?';
	$txt['cloud_google_help_step1'] = '<b>Step 1:</b> Google Drive requires enable access to drive API.<br />Please login to your Google Account and go to: <a href=\'https://code.google.com/apis/console\' target=\'_blank\'><b>Google API console</b><a/>.<br /> Go to section named <b>\'Services\'</b> and enable those two features:';
	$txt['cloud_google_help_step2'] = '<b>Step 2:</b> In next step, you must create Google API Client ID. Click on the <b>\'API Access section\'</b> and create new <b>Google OAuth 2.0 Client ID.</b>';	
	$txt['cloud_google_help_step3'] = '<b>Step 3:</b> In next step, you must create new Google project. Specify the name, e.g. \'My project\'. Logo is not required. Click \'next\' and save your project. In <b>Client ID</b> settings set to <b>Web application</b> and paste the URL of your PHP installation. For your installation it is: <b>'.$_SESSION['PHPOS_NETURL'].'</b>';		
	$txt['cloud_google_help_step4'] = '<b>Step 4:</b> Client ID and Client Secret will be generated. Paste them at right side at this form and click on the create/update button. Your account will be added to PHPOS and will be available on this server.';	
	$txt['cloud_connected'] = 'Connected to Cloud account.';
	$txt['cloud_not_connected'] = 'Error to connect to your Cloud account.';	
	$txt['cloud_folders'] = 'Clouds';	
	$txt['dsc_cloud_title'] = 'You can create and manage Cloud accounts here. <br />With your own Cloud accounts you can access to your files on ftp servers just like local files.';	
	$txt['dsc_cloud_public'] = 'Public account will be available to ALL users.';		
	$txt['dsc_cloud_list_own'] = 'This is list of Cloud accounts witch you created.<br />Nobody against you cant access to this accounts.<br /><b>Please click on account name to edit them</b>';	
	$txt['dsc_cloud_list_all'] = 'This is list of ALL Cloud accounts created by users.<br /><b>Please click on account name to edit them</b>';		
	$txt['dsc_cloud_list_public'] = 'This is list of public Cloud accounts.<br />Every user in this system have access to this accounts.<br/><b>Please click on account name to edit them</b>';	
	$txt['dsc_cloud_list_public_user'] = 'This is list of public Cloud accounts.<br />Every user in this system have access to this accounts.<br/><b>You can\'t edit this but you can access to them.</b>';	
	$txt['dsc_cloud_list_empty'] = 'No Cloud accounts in this list';
	$txt['dsc_cloud_desc_new'] = 'Create new Cloud account';	
	$txt['dsc_cloud_name'] = 'Specify the name to this Cloud account';
	$txt['dsc_cloud_desc'] = 'This fields is not required, but you can specify a description for this account';
	$txt['dsc_cloud_host'] = 'Specify Project/Product name generated in <a href=\'https://code.google.com/apis/console\' target=\'_blank\'><b>Google API console</b><a/>';
	$txt['dsc_cloud_login'] = 'Specify Client ID generated in <a href=\'https://code.google.com/apis/console\' target=\'_blank\'><b>Google API console</b><a/>';
	$txt['dsc_cloud_pass'] = 'Specify Client Secret generated in <a href=\'https://code.google.com/apis/console\' target=\'_blank\'><b>Google API console</b><a/>';
	$txt['dsc_cloud_port'] = 'Specify Redirect URL for receive tokens from Google. This URL must be also added into your <a href=\'https://code.google.com/apis/console\' target=\'_blank\'><b>Google API console</b><a/>';	
	$txt['dsc_cloud_google_info'] = 'If you want to connect with your Google Drive account you must enable this feature in your Google Account. At first, you must go to: <a href=\'https://code.google.com/apis/console\' target=\'_blank\'><b>Google API console</b><a/> and enable Google Drive API. In next step, you must create new project in Google API as an \'installed application\' and you must generate ClientID and Client Secret. After that, you must allow URL of PHPOS installation to receive Google tokens.';	
	$txt['dsc_cloud_a_new'] = 'Create new Cloud account';
	$txt['dsc_cloud_a_edit'] = 'Edit Cloud account';
	$txt['dsc_cloud_a_list'] = 'Browse Cloud accounts';	
	$txt['cloud_select_new'] = 'At first, select cloud witch you want to use:';
		
	
// Login screen	
	$txt['login_title'] = 'PHPOS Login screen';	
	$txt['password'] = 'Password';
	$txt['login_btn_txt'] = 'Login me';
	$txt['login_title_you_are_not_logged'] = 'You are not logged :(';
	$txt['login_title_please_login'] = 'Please login here:';
	$txt['login_empty_fields'] = 'Please correct your login, or password';
	$txt['login'] = 'Login';
	$txt['login_btn_tip'] = 'Click here to login';
	$txt['enter_login_here'] = 'Your login here';
	$txt['enter_pass_here'] = 'Your password here';
	$txt['wrong_login'] = 'Incorrect login or password';
	$txt['msg_logged'] = 'You have been logged in';
	
	
// Installer	
	$txt['installer_s1'] = 'License';	
	$txt['installer_s2'] = 'System requirements';	
	$txt['installer_s3'] = 'Administrator account';
	$txt['installer_s4'] = 'Database configuration';
	$txt['installer_s5'] = 'System configuration';
	$txt['installer_s6'] = 'Directories privilleges';
	$txt['installer_s7'] = 'Installation';
	$txt['installer_s8'] = 'Finish :)';	
	$txt['installer_h1'] = 'PHPOS is not installed yet.<br />Dont\'t worry, we will fix this problem quicly :)<br />Installation is very easy, just follow the steps. <br/><br /><b>At first, you must accept following license to install PHPOS.</b>';	
	$txt['installer_h2'] = 'PHPOS have some requirements, this step will help you to check that your server configuration is supported by this system. Now you can see your machine configuration and info about compatibility.<br/><br/><b>You can see your configuration with compare with PHPOS requirements below:</b>';	
	$txt['installer_h3'] = 'Root acoount is the super-administartor account for PHPOS. It is the most important account in system. Only with this account you will have access to all administartion privilleges. Only one root account is allowed in system.<br/><br/><b>Please specify the password to your "root" account:</b><br/>If you will lost your root password, see the documentaion how to reset it.';	
	$txt['installer_h4'] = 'PHPOS is using database to store data. In this version only MySQL databases are supported. In next versions, in future support will be extended to another database engines.<br /><br /><b>Please specify configuration of your database here:</b>';	
	$txt['installer_h5'] = 'At now, you must specify the basic PHPOS configuration. This configuration will be your default system configuration. <br /><br /><b>Please specify the basic configuration options below:</b>';
	$txt['installer_'] = '';	
	$txt['installer_h6'] = 'PHPOS required some folders to be "writable". If you are now on unix-based system, we will setup the chmod settings. PHPOS will now try to do this automatically. If operation will not give a result, you will need to set chmod manualy. <br/><br/><b>There is the list of folders which requires chmod privilleges to write files with results. If some folder can be chmodem by PHPOS, you must set them chmod 777 provilleges manually:</b>';	
	$txt['installer_h7'] = 'In this step your database will be installed, and the PHPOS will install the tables in your database.<br /><br /><br /><b>If there will be an error follow the instructions. <br />You can also import the "sql" file manualy via e.g. PHPMyAdmin.</b>';	
	$txt['installer_h8'] = 'Well done! PHPOS was succesfult installed on your server. When you click "finish" button you will be redirected to login screen. Login as "root" acoount and create another accounts for your users.<br/><br/><b>Thanks for installing PHPOS :)</b>';	
	$txt['installer_o1'] = 'Security key was generated.';			
	$txt['installer_o2'] = 'Installer file was created.';	
	$txt['installer_o3'] = 'Config file was created.';	
	$txt['installer_o4'] = 'MySQL OK. Connection to database succesful.';	
	$txt['installer_o5'] = 'MySQL OK. Database was installed.';		
	$txt['installer_o6'] = 'OK. Database config file was created.';	
	$txt['installer_o7'] = 'atabase config file was created.';	
	$txt['installer_o8'] = 'PHPOS was reinstalled.';	
	$txt['installer_o9'] = 'Well done. It\'s look like everything is ok and your version of PHPOS has been succesfuly installed. When you click on "finish" button you will be redirected to login area. Login as "root" with password which you setted.';		
	$txt['installer_o10'] = 'Home dir for root created.';	
	$txt['installer_w1'] = 'You are using database without password. It \'s very dangerous.';	
	$txt['installer_w2'] = 'Security key was exists. It was been overwriten.';	
	$txt['installer_w3'] = 'Old database config was exists. It was been overwriten.';		
	$txt['installer_w4'] = 'Old config file was exists. It was been overwriten.';	
	$txt['installer_w5'] = 'Old installer config file was exists. It was been overwriten';	
	$txt['installer_w6'] = 'Home dir was not created (chmod problem?).';	
	$txt['installer_e1'] = 'There is a problem with generate security key';		
	$txt['installer_e2'] = 'There is a problem with generate installer file.';	
	$txt['installer_e3'] = 'ERROR. Problem with saving config file.';	
	$txt['installer_e4'] = 'Error connecting to database.';	
	$txt['installer_e5'] = 'Error installing database.';		
	$txt['installer_e6'] = 'Problem with save DB config file.';	
	$txt['installer_e7'] = 'Database config file was created.';
	$txt['installer_e8'] = 'I\'m sorry. There was an errors with installing PHPOS. Please see errors below and back to previous steps to correct your data.';	
	$txt['installer_e9'] = 'Error with reinstall';		
	$txt['installer_e10'] = 'PHPOS is already installed in this database. Please remove old version from database and refresh this step or back to previous steps and choose another database/prefix for tables.';	
	$txt['installer_i1'] = 'I understand and accept this license.';	
	$txt['installer_i2'] = 'If your MySQL server is on another machine, version will not show here';	
	$txt['installer_i3'] = 'Password must have 6 - 30 chars';		
	$txt['installer_pwd'] = 'Password';	
	$txt['installer_cpwd'] = 'Confirm password';	
	$txt['installer_dbv'] = 'in this beta version only MySQL is supported';	
	$txt['installer_dbtype'] = 'DB Type';		
	$txt['installer_pwdnreq'] = 'not required, but using DB without password is seriously dangerous';	
	$txt['installer_iprx'] = 'You can specify prefix for tables, e.g. "phpos_"';	
	$txt['installer_cfg1'] = 'Site title';	
	$txt['installer_cfg2'] = 'Default language';	
	$txt['installer_cfg3'] = 'Default wallpaper';	
	$txt['installer_m1'] = 'ERROR';	
	$txt['installer_m2'] = 'SQL ERROR';	
	$txt['installer_m3'] = 'OK';	
	$txt['installer_m4'] = 'WARNING';	
	$txt['installer_req'] = 'Required';	
	$txt['installer_your'] = 'Yours';	
	$txt['installer_er1'] = 'You must accept license to go to the next step';	
	$txt['installer_er2'] = 'Passwords must be not empty';	
	$txt['installer_er3'] = 'Passwords not match!';	
	$txt['installer_er4'] = 'Wrong length of passwords!';	
	$txt['installer_er5'] = 'Required fields are empty';	
	$txt['installer_dbtype'] = 'DB Type';	
	$txt['installer_db'] = 'Database';	
	$txt['installer_req'] = 'required';	
	$txt['installer_title'] = 'PHPOS Installer';	
	$txt['installer_title2'] = 'PHPOS Installation';	
	$txt['installer_your_v'] = 'your version';	
	$txt['installer_step'] = 'Step';	
	$txt['installer_reinstall'] = 'Reinstall';	
	$txt['installer_next_step'] = 'Next step';	
	$txt['installer_prev_step'] = 'Prev step';	
	$txt['installer_finish_step'] = 'Finish installation';	
	$txt['installer_finishlogin_step'] = 'Finish & log in';	
	$txt['installer_reinstall_msg'] = 'Reinstall will destroy all PHPOS tables and data in database. Do you want to continue?';	
	$txt['installer_key_msg'] = 'Please save your installation key in safety place. This key is unique for every installation and will be needed to restore installation or when you need to move your installation to another server.';	
	$txt['installer_your_key'] = 'Your installation key:';
	
	
	

	
	// AFTER INSTALL START DATA
	$txt['after_install_msg_title'] = 'Welcome message';
	$txt['after_install_msg_body'] = '<p>Welcome in PHPOS.</p>
	<p>This is the test message.</p>
	<p>As you see - PHPOS have private messages system.</p>
	<p>Users can sending and receiving message.</p>
	<p><strong>Enjoy!</strong></p>';
	
	$txt['after_install_group_name'] = 'Test group';
	$txt['after_install_group_desc'] = 'This is you first workgroup';
	
	$txt['after_install_shortcut_phpos_www'] = 'PHPOS Home Website';
	$txt['after_install_shortcut_frame_wiki'] = 'Webapp in a window - Wikipedia.org';
	$txt['after_install_shortcut_link_barok'] = 'Barok 3D Engine';
	$txt['after_install_shortcut_yt_militia'] = 'PHPOS author vs. Robocain - YouTube';
	$txt['after_install_folder_links'] = 'Test links';
	$txt['after_install_readme_title'] = 'Readme.txt';
	$txt['after_install_readme_file'] = '<p><strong>Your version of PHP was succesfuly installed on this server.</strong></p>
	<p>This is a test document.</p>
	<p>As you see - PHPOS have filestem API to reading and saving files.</p>
	<p><strong>This is the power of PHPOS.</strong></p>';
	
	$txt['notepad_app_title'] = 'Notepad';
	$txt['langs_tray_title'] = 'Change language';
	$txt['wallpaper_tray_title'] = 'Change wallpaper';
	
	$txt['uploading'] = 'Sending file. Please wait...';
	$txt['uploaded'] = 'File was uploaded on server';
	$txt['upload_here'] = 'Upload here';
	
	$txt['app_notepad_new'] = 'New document';
	$txt['save'] = 'Save';
	$txt['save_as'] = 'Save as';
	$txt['open'] = 'Open';
	$txt['app_notepad_new_unsaved'] = 'New unsaved document';
	
	$txt['filesystem'] = 'Filesystem';
	$txt['last_mod'] = 'Latest modification';
	
	$txt['file_saved'] = 'File was saved';
	
	$txt['fs_local_files'] = 'Local files';
	$txt['fs_db_mysql'] = 'Database';
	$txt['fs_ftp'] = 'FTP connection';
	$txt['fs_cloud'] = 'Cloud';
	$txt['renamed'] = 'Name was changed';
	$txt['folder_created'] = 'New folder was created';
	$txt['file_deleted'] = 'File/folder was deleted';
	$txt['file_pasted'] = 'Pasted from clipboard';
	$txt['copied_to_clip'] = 'Copied to clipboard';
	$txt['cutted_to_clip'] = 'Pasted from clipboard';
	$txt['wait_for_download'] = 'Please wait. Downloading...';

	$txt['start_ip'] = 'Server IP';
	$txt['start_db'] = 'Database';
	$txt['cloud_no_accounts'] = 'No clouds';
	
	
	// bugtracker, 2013.10.11
	$txt['bugtracker_app'] = 'Report a bug';
	$txt['bugtracker_app_tray'] = 'Report bug';
	$txt['bugtracker_index_app'] = 'Bug reporting';
	$txt['bugtracker_app_desc'] = 'If you find a bug please type it here and click on \'Send report\'.<br />It will be reported to PHPOS servers.';
	$txt['bugtracker_report_btn'] = 'Send report';
	$txt['bugtracker_sended_msg'] = 'Thanks. Your report was sent to our servers.';
	$txt['bugtracker_name'] = 'Your name';
	$txt['bugtracker_name_desc'] = 'Name is not required, but you can specify this if you want';
	
	$txt['fs_cloud_gdrive'] = 'Google Drive Cloud';
	$txt['fs_clouds_right'] = 'Google Drive';
	$txt['cloud_google_connected'] = 'Connected to Google API';
	
	$txt['connecting_ftp_wait'] = 'Connecting to FTP. Please wait...';
	
?>