<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.08
 
**********************************
*/
if(!defined('PHPOS'))	die();	


class phpos_layout {

	private
		$left,
		$layout_width,
		$layout_height,
		$rowbutton_used,
		$prevbutton_used,
		$nextbutton_used,
		$app_id,
		$href,
		$title,
		$region,
		$split,
		$width,
		$height,
		$fit,
		$icon,
		$collapsed,
		$border,
		$header,
		$cache,
		$loading,
		$id,
		$style,
		$classes,
		$window_id,
		$window_title,
		$td_classes,
		$tbl_counter = 0,
		$render_html = array();
		 
/*
**************************
*/
 		
	public
		$my_app;
		 
/*
**************************
*/
 		
	public function __construct()
	{
		$win_obj = glb::get('apiWindow');		
		$this->app_id = $win_obj->getAPPID();
		$this->window_id = $win_obj->getID();	
		$this->window_title = $win_obj->getTitle();
		$this->href = null;
		$this->title = null;
		$this->split = null;
		$this->fit = null;
		$this->width = null;
		$this->region = null;
		$this->height = null;
		$this->collapsed = null;
		$this->icon = null;
		$this->border = null;
		$this->header = null;
		$this->cache = null;
		$this->style = null;
		$this->classes = null;
		$this->loading = null;
		$this->id = null;
		$this->my_app = glb::get('my_app');
	}

		 
/*
**************************
*/
 	
	public function add_css($css_file)
	{
		$str = '<link href="'.MY_RESOURCES_URL.$css_file.'" type="text/css" rel="stylesheet" />';
		return $str;
	}
	
		 
/*
**************************
*/
 	
	public function set_title($title)
	{
		$this->title = $title;
	}
		 
/*
**************************
*/
 	
	public function set_header($header)
	{
		$this->header = $header;
	}
		 
/*
**************************
*/
 	
	public function set_style($style)
	{
		$this->style = $style;
	}
		 
/*
**************************
*/
 	
	public function set_classes($classes)
	{
		$this->classes = $classes;
	}
		 
/*
**************************
*/
 	
	public function set_loading($loading)
	{
		$this->loading = $loading;
	}
		 
/*
**************************
*/
 	
	public function set_cache($cache)
	{
		$this->cache = $cache;
	}
		 
/*
**************************
*/
 	
	public function set_id($id)
	{
		$this->id = $id;
	}
		 
/*
**************************
*/
 	
	public function set_region($region)
	{
		$this->region = $region;
	}
	 
/*
**************************
*/
 	
	public function set_icon($icon)
	{
		$this->icon = $icon;
	}
		 
/*
**************************
*/
 	
	public function set_border($border)
	{
		$this->border = $border;
	}
		 
/*
**************************
*/
 	
	public function set_collapsed($collapsed)
	{
		$this->collapsed = $collapsed;
	}
		 
/*
**************************
*/
 	
	public function set_href($url)
	{
		$this->href = $url;
	}
		 
/*
**************************
*/
 	
	public function set_width($width)
	{
		$this->width = $width;
	}
		 
/*
**************************
*/
 	
	public function set_height($height)
	{
		$this->height = $height;
	}
		 
/*
**************************
*/
 	
	public function set_split($split)
	{
		$this->split = $split;
	}
		 
/*
**************************
*/
 	
	public function set_fit($fit)
	{
		$this->fit = $fit;
	}
		 
/*
**************************
*/
 	
	private function reset_params()
	{
		$this->href = null;
		$this->region = null;
		$this->title = null;
		$this->url = null;
		$this->width = null;
		$this->height = null;
		$this->split = null;
		$this->fit = null;
		$this->icon = null;
		$this->border = null;
		$this->header = null;
		$this->collapsed = null;
		$this->loading = null;
		$this->cache = null;
		$this->id = null;
		$this->style = null;
		$this->classes = null;
	}
		 
/*
**************************
*/
 	
	public function get_id($element = null)
	{
		if(empty($this->id)) 
		{		
			$id = 'phpos_layout_'.$element.'_'.$this->app_id.'_'.$this->window_id;
			
		} else {
		
			$id = $this->id;
		}		
		return $id;	
	}
		 
/*
**************************
*/
 		
		
	private function get_classes($start_class)
	{
		$first_class= '';
		
		if(!empty($start_class))
		{
			$first_class = $start_class.' ';
		}
		
		if(empty($this->classes)) 
		{		
			$classes = $first_class.$this->classes;
			
		} else {
		
			$classes = $first_class;
		}		
		
		return $classes;	
	}	
			 
/*
**************************
*/
 	
	public function data_options()	
	{
		$data_array = array();
		if(!empty($this->href)) $data_array['href'] = "href:'".$this->href."'";
		if(!empty($this->region)) $data_array['region'] = "region:'".$this->region."'";
		if(!empty($this->title)) $data_array['title'] = "title:'".$this->title."'";		
		if(!empty($this->icon)) $data_array['icon'] = "iconCls:'".$this->icon."'";	
		if(!empty($this->height)) $data_array['height'] = "minHeight:'".$this->height."'";	
		if(!empty($this->loading)) $data_array['loading'] = "loadingMessage:'".$this->loading."'";	
		$data_array['loading'] = "loadingMessage:''";	
		
		if($this->border == 'true') 
		{
			$data_array['border'] = "border:true";
			
		} else {
		
			$data_array['border'] = "border:false";
		}
		
		if($this->cache == 'true') 
		{
			$data_array['cache'] = "cache:true";
			
		} else {
		
			$data_array['cache'] = "cache:false";
		}
		
		if($this->split == 'true') $data_array['split'] = "split:true";
		if($this->header == 'false') $data_array['header'] = "noheader:true";
		if($this->collapsed == 'true') $data_array['collapsed'] = "collapsed:true";		
		
		$data_options = implode(",", $data_array);		
		return $data_options;
	}
		 
/*
**************************
*/
 	
	public function panel()
	{			
		if(empty($this->title)) $this->title = '';	
		if(empty($this->border)) $this->border = 'false';
		if(empty($this->cache)) $this->cache = 'false';
		if(empty($this->loading)) $this->loading = '';
		if(empty($this->header)) $this->header = 'false';	
		if(empty($this->fit)) $this->fit = 'true';		
		
		$str = '<div id="'.$this->get_id('panel').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('easyui-panel').'"  style="padding:10px">';			
		return $str;	
	}
		 
/*
**************************
*/
 	
		
	public function start()
	{
		if(empty($this->height) && empty($this->width))
		{
			$def_style = 'width:auto;height:400px;margin:0';
		}		
		
		$str = '<div id="'.$this->get_id('layout').'" class="'.$this->get_classes('easyui-layout').'" style="'.$this->get_style($def_style).'"  data-options="fit:true,split:false">';	
		$this->reset_params();
		return $str;
	}
	
		 
/*
**************************
*/
 	
	
	public function end($info = null)
	{
		$str = '</div>';	
		$this->reset_params();
		return $str;
	}
		 
/*
**************************
*/
 	
	public function region_start($region)
	{
	
	}
		 
/*
**************************
*/
 	
	public function footer($msg = null, $no_tag = null)
	{
		if(empty($this->region)) $this->region = 'south';
		if(empty($this->title)) $this->title = '';
		if(empty($this->height)) $this->height = '50';
		if(empty($this->split)) $this->split = 'true';			

		$css_height = $this->height;
		
		$str = '<div id="'.$this->get_id('footer').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('phpos_layout_footer').'" style="'.$this->get_style('background-color:#eff5fb').'">';	
		$this->reset_params();
		$str.= $this->footer_info($msg, $no_tag);
		return $str;
	}
	 
/*
**************************
*/
 	
	public function main()
	{
		if(empty($this->region)) $this->region = 'center';		
		
		$str = '<div id="'.$this->get_id('main').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('').'" style="'.$this->get_style().'">';
		$this->reset_params();			
		return $str;
	}
		 
/*
**************************
*/
 	
	public function left()
	{
		if(empty($this->region)) $this->region = 'west';
		if(empty($this->width)) $this->width = '400';
		if(empty($this->split)) $this->split = 'true';	
				
		$css_width = $this->width;
		
		$str = '<div id="'.$this->get_id('left').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('').'" style="'.$this->get_style().'">';	
		$this->reset_params();
		return $str;
	}
		 
/*
**************************
*/
 	
	public function right()
	{
		if(empty($this->region)) $this->region = 'east';
		if(empty($this->width)) $this->width = '400';
		if(empty($this->split)) $this->split = 'true';	
			
		$css_width = $this->width;		
	
		$str = '<div id="'.$this->get_id('right').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('').'" style="'.$this->get_style().'">';
		$this->reset_params();
		return $str;
	}
	
		 
/*
**************************
*/
 	
	
	private function get_style($style = null)
	{
		$styles = array();
		if(!empty($style)) $styles[] = $style;
		if(!empty($this->height)) $styles[] = 'height:'.$this->height.'px';
		if(!empty($this->width)) $styles[] = 'width:'.$this->width.'px';
		if(!empty($this->style)) $styles[] = $this->style;
		
		$str = implode(";", $styles);
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function title($title, $icon = null)
	{
		$img = '';		
		if(!empty($icon) && file_exists(MY_RESOURCES_DIR.$icon))
		{
			$img = '<img src="'.MY_RESOURCES_URL.$icon.'" style="height:25px;display:inline-block; vertical-align:middle; padding-right:5px" />';
		}
		
		$str = '<div class="phpos_layout_title"><img src="'.MY_RESOURCES_URL.'window_icon.png" style="height:20px; display:inline-block;vertical-align:middle;padding-right:10px"><b>'.$this->window_title.'</b><img src="'.THEME_URL.'icons/arrow_small_right_light.png" style="height:10px;display:inline-block; vertical-align:middle; padding-left:10px; padding-right:10px" />'.$title.'</div>';
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function subtitle($title, $icon = null)
	{			
		if(!empty($icon)) $img = '<img src="'.$icon.'" style="height:30px;display:inline-block; vertical-align:middle; padding-right:5px" />';
		
		$str ='
		<div class="form_area_row_header input_row_mouseleave" style="margin-bottom:10px">'.$img.$title.'</div>';				
		return $str;	
	}
		 
/*
**************************
*/
 		
	public function column($width)
	{
		$str = '<div style="float:left; vertical-align:top; width:'.$width.'">';
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function clr()
	{
		$str = '<div style="clear:both"></div>';
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function menu($norender = null)
	{
		if(empty($this->region)) $this->region = 'north';
		if(empty($this->split)) $this->split = 'false';
		if(empty($this->fit)) $this->fit = 'true';
		if(empty($this->height)) $this->height = '45';
				
		$css_height = $this->height;
		
		$str = '<div id="'.$this->get_id('menu').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('').'" style="'.$this->get_style().'">';	
	
		$menu_html = $this->my_app->window->get_layout_menu_html();
		$menu = glb::get('window_menu');
		
			if($norender != 'norender')
			{
			$str.='<div id="api_window_headermenu_container" style="background-color:#eff5fb">'.$menu_html.'</div>';
			} else {
				$html['menu'] = $menu_html;
				glb::set('html', $html);
			}
			
		$this->reset_params();
		return $str;
	}
		 
/*
**************************
*/
 	
	public function toolbar()
	{
		if(empty($this->region)) $this->region = 'north';
		if(empty($this->split)) $this->split = 'false';
		if(empty($this->height)) $this->height = '70';				
	
		$toolbar_html = $this->my_app->window->get_layout_toolbar_html();
		
		$str = '<div id="'.$this->get_id('menu').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('').'" style="'.$this->get_style('background-color:#eff5fb;background-image:url('.THEME_URL.'windows/toolbar_bg.png)').'">';	
	
	
		$str.='<div style="padding-top:8px;padding-left:10px;">'.$toolbar_html.'</div>';

		$this->reset_params();
		return $str;
	}
		
		 
/*
**************************
*/
 		
	public function custom()
	{			
		$str = '<div id="'.$this->get_id('custom').'" data-options="'.$this->data_options().'" class="'.$this->get_classes('').'" style="'.$this->get_style().'">';	
		
		$this->reset_params();
		return $str;
	}
	 
/*
**************************
*/
 	
	
	public function render()
	{
		
	}
	 
/*
**************************
*/
 		
	public function tbl_start()
	{
		$this->tbl_counter = 0;
		$str= '<table width="100%" class="phpos_layout_table">';
		return $str;	
	}
	
	 
/*
**************************
*/
 		
	
	public function tbl_end()
	{
		$str = '</table>';
		
		$jquery_code = "
		$('.phpos_layout_table tr').mouseenter(function() {			
					$(this).addClass('row3');	
			});
			
		$('.phpos_layout_table tr').mouseleave(function() {		
				$(this).removeClass('row3');	
		});
		";
		
		global $my_app;		
		$my_app->jquery_onready($jquery_code);		
		$this->td_classes = array();
		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function td_classes($classes)
	{
		$this->td_classes = $classes;
	}	
		 
/*
**************************
*/
 	
	public function row($columns, $tip = null)
	{
		$this->tbl_counter++;		
		$class='row1';
		
		if($this->tbl_counter%2==0) $class = 'row2';
	
		$tip_class = '';
		$tip_info = '';
		if(!empty($tip))
		{		
			$tip_class =' easyui-tooltip';
			$tip_info = ' title="'.$tip.'" ';
		}
		
		$str='<tr'.$tip_info.' class="'.$class.$tip_class.'">';	
		
		
		$i=0;
		foreach($columns as $td)
		{
			
			if(!empty($this->td_classes[$i])) $class = ' '.$this->td_classes[$i];
			$str.='<td class="phpos_layout_row_td'.$class.'">'.$td.'</td>';	
			$i++;
		}
		
		$str.='</tr>';
		
		return $str;		
	}
		 
/*
**************************
*/
 	
	public function head($columns)
	{
		$str='<tr class="phpos_layout_table_header">';
		
		foreach($columns as $id => $size)
		{			
			$str.='<td style="width:'.$size.'">'.$id.'</td>';	
		}
		
		$str.='</tr>';
		return $str;		
	}
	 
/*
**************************
*/
 	
	public function div_ok($msg)
	{
		$str.='<div class="phpos_result phpos_result_ok"><img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/status_ok.png" /><p>'.$msg.'</p></div>';
		return $str;
	}
		 
/*
**************************
*/
 	
	public function div_error($msg)
	{
		$str.='<div class="phpos_result phpos_result_error"><img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/status_error.png" /><p>'.$msg.'</p></div>';
		return $str;
	}
		 
/*
**************************
*/
 	
	public function button($title, $action = null, $icon = null)
	{
		$str.='<a style="margin-top:10px" id="btn" href="javascript:void(0);" onclick="'.$action.'" class="easyui-linkbutton" data-options="iconCls:\'icon-'.$icon.'\'">'.$title.'</a>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function area_start($title = null, $desc = null, $id = null)
	{
		$t = '';
		$d = '';
		$l='';
		if(!empty($title)) $t = '<h1>'.$title.'</h1>';
		if(!empty($desc)) $d = '<h2>'.$desc.'</h2>';
		if(!empty($title) || !empty($desc)) $l = '<div class="line"></div>';
		$str.='<div class="phpos_layout_area">'.$t.$d.$l;		
		return $str;	
	}
	 
/*
**************************
*/
 		
	public function area_end()
	{
		$str.='</div>';		
		return $str;	
	}
	
	
	public function rowbutton($title, $icon = null, $action = null, $tip = null)
	{
		$img = '';
		$onclick = '';
		$tip_class = '';
		$tip_msg = '';
		if(!empty($icon)) $img = '<img src="'.$icon.'" />';
		if(!empty($action)) $onclick = ' onclick="'.$action.'"';
		if(!empty($tip)) 
		{
			$tip_msg = ' title="'.$tip.'"';
			//$tip_class = ' easyui-tooltip';
		}
		
		$str = '<div class="phpos_rowbutton_container'.$tip_class.'"'.$onclick.$tip_msg.'>'.$img.'<p>'.$title.'</p></div>';		
		
		if($this->rowbutton_used != WIN_ID)
		{
			$jquery_code = "
			$('.phpos_rowbutton_container').mouseenter(function() {			
						$(this).addClass('rowbtn_hover');	
				});
				
			$('.phpos_rowbutton_container').mouseleave(function() {		
					$(this).removeClass('rowbtn_hover');	
			});
			";
			
			global $my_app;		
			$my_app->jquery_onready($jquery_code);		
			$this->rowbutton = WIN_ID;
		}		
		
		return $str;	
	}
			 
/*
**************************
*/
 	
	public function back_button($title = null, $action=null, $tip = null, $inactive = null)
	{		
		$t = '<p>Back</p>';
		$onclick = '';
		$tip_class = '';
		$tip_msg = '';	
		
		if(!empty($title)) $t = '<p>'.$title.'</p/>';
		if(!empty($action)) $onclick = ' onclick="'.$action.'"';
		if(!empty($tip)) 
		{
			$tip_msg = ' title="'.$tip.'"';
			$tip_class = ' easyui-tooltip';
		}		
		
		$str = '<div class="phpos_layout_navibuttons_prev'.$tip_class.'"'.$tip_msg.$onclick.'><img src="'.ICONS.'navbuttons/btn_navi_prev.png" />'.$t.'</div>';		
			
		if($this->prevbutton_used != WIN_ID)
		{
			$jquery_code = "
			$('.phpos_layout_navibuttons_prev').mouseenter(function() {		
				var x = $(this).find('img');
				x.attr('src', '".ICONS."navbuttons/btn_navi_prev_hover.png');
				$(this).addClass('navbtn_hover');	
				});
				
			$('.phpos_layout_navibuttons_prev').mouseleave(function() {		
				var x = $(this).find('img');
				x.attr('src', '".ICONS."navbuttons/btn_navi_prev.png');
				$(this).removeClass('navbtn_hover');
				
			});
			";		
		
			global $my_app;		
			$my_app->jquery_onready($jquery_code);		
			$this->prevbutton_used = WIN_ID;
		}
		
		return $str;
	}	
			 
/*
**************************
*/
 	
	public function next_button($title = null, $action=null, $tip = null, $inactive = null, $id = null)
	{		
		$t = '<p>Next</p>';
		$onclick = '';
		$tip_class = '';
		$tip_msg = '';	
		$id_tag = '';	
		
		if(!empty($id)) $id_tag = ' id="phpos_form_submit_btn_'.$id.'"';
		if(!empty($title)) $t = '<p>'.$title.'</p/>';		
		if(!empty($action)) $onclick = ' onclick="'.$action.'"';
		if(!empty($tip)) 
		{
			$tip_msg = ' title="'.$tip.'"';
			$tip_class = ' easyui-tooltip';
		}		
		
		$str = '<div class="phpos_layout_navibuttons_next'.$tip_class.'"'.$tip_msg.$onclick.$id_tag.' style="text-align:right">'.$t.'<img src="'.ICONS.'navbuttons/btn_navi_next.png" /></div>';		
			
		if($this->navbutton_used != WIN_ID)
		{
			$jquery_code = "
			$('.phpos_layout_navibuttons_next').mouseenter(function() {		
				var x = $(this).find('img');
				x.attr('src', '".ICONS."navbuttons/btn_navi_next_hover.png');
				$(this).addClass('navbtn_hover');	
				});
				
			$('.phpos_layout_navibuttons_next').mouseleave(function() {		
				var x = $(this).find('img');
				x.attr('src', '".ICONS."navbuttons/btn_navi_next.png');
				$(this).removeClass('navbtn_hover');
				
			});
			";		
		
			global $my_app;		
			$my_app->jquery_onready($jquery_code);		
			$this->navbutton_used = WIN_ID;
		}
		
		return $str;
	}	
	
			 
/*
**************************
*/
 	
	public function nothing_to_edit($msg)
	{
		$str = '<div class="phpos_layout_no_records">'.$msg.'</div>';
		return $str;
	}
			 
/*
**************************
*/
 	
	public function txtdesc($msg)
	{
		$str = '<div class="phpos_layout_txtdesc">'.$msg.'</div>';
		return $str;
	}
			 
/*
**************************
*/
 	
	public function footer_info($msg = null, $no_tag = null)
	{
		global $my_app;
		$app_title = $my_app->get_title();
		$app_desc = $my_app->get_desc();
		$app_version = $my_app->get_version();
		$app_icon = $my_app->get_icon();
		
		if($msg === null)
		{
			$msg = '<div class="phpos_layout_footer_info"><img src="'.$app_icon.'" /><span><b>'.strip_tags($app_title).'</b>, <b>'.txt('app_footer_version').'</b> '.strip_tags($app_version).'</span></div>';
			
		} else {
			
			if($no_tag === null)
			{
				$msg = '<div class="phpos_layout_footer_info"><p>'.$msg.'</p></div>';
			} 			
		}		
	
		return $msg;
	}
			 
/*
**************************
*/
 	
	public function empty_list($msg = null)
	{
		if($msg === null) $msg = txt('no_records_msg');
		$str.= '<div class="phpos_empty_list"><img src="'.ICONS.'status/status_warn.png" /><span>'.$msg.'</span></div>';
		return $str;	
	}
			 
/*
**************************
*/
 	
	public function access_denied($msg = null)
	{
		if($msg === null) $msg = txt('no_records_msg');
		$str.= '<div class="phpos_access_denied"><img src="'.ICONS.'status/status_warn.png" /><br /><span>ACCESS DENIED</span></div>';
		return $str;	
	}
}
?>