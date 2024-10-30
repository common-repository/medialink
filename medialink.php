<?php
/*
Plugin Name: MediaLink
Plugin URI: https://wordpress.org/plugins/medialink/
Version: 7.46
Description: MediaLink outputs as a gallery from the media library(image and music and video and document).
Author: Katsushi Kawamori
Author URI: http://riverforest-wp.info/
Text Domain: medialink
Domain Path: /languages
*/

/*  Copyright (c) 2013- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

	load_plugin_textdomain('medialink');
//	load_plugin_textdomain('medialink', false, basename( dirname( __FILE__ ) ) . '/languages' );

	define("MEDIALINK_PLUGIN_BASE_FILE", plugin_basename(__FILE__));
	define("MEDIALINK_PLUGIN_BASE_DIR", dirname(__FILE__));
	define("MEDIALINK_PLUGIN_URL", plugins_url($path='medialink',$scheme=null));

	require_once( MEDIALINK_PLUGIN_BASE_DIR . '/req/MediaLinkRegistAndHeader.php' );
	$medialinkregistandheader = new MediaLinkRegistAndHeader();
	add_action('admin_init', array($medialinkregistandheader, 'register_settings'));
	add_action('admin_init', array($medialinkregistandheader, 'delete_old_versions_wp_options'));
	add_action('wp_head', array($medialinkregistandheader, 'add_feedlink'));
	add_action('wp_print_styles', array($medialinkregistandheader, 'load_styles'));
	unset($medialinkregistandheader);

	require_once( MEDIALINK_PLUGIN_BASE_DIR . '/req/MediaLinkAdmin.php' );
	$medialinkadmin = new MediaLinkAdmin();
	add_action( 'admin_menu', array($medialinkadmin, 'plugin_menu'));
	add_action( 'admin_enqueue_scripts', array($medialinkadmin, 'load_custom_wp_admin_style') );
	add_filter( 'plugin_action_links', array($medialinkadmin, 'settings_link'), 10, 2 );
	add_action( 'admin_notices', array($medialinkadmin, 'closed_plugin'));
	unset($medialinkadmin);

	add_shortcode( 'medialink', 'medialink_func' );

	require_once( MEDIALINK_PLUGIN_BASE_DIR . '/req/MediaLinkWidgetItem.php' );
	add_action('widgets_init', create_function('', 'return register_widget("MediaLinkWidgetItem");'));

	require_once( MEDIALINK_PLUGIN_BASE_DIR . '/req/MediaLinkQuickTag.php' );
	$medialinkquicktag = new MediaLinkQuickTag();
	add_action('media_buttons', array($medialinkquicktag, 'add_quicktag_select'));
	add_action('admin_print_footer_scripts', array($medialinkquicktag, 'add_quicktag_button_js'));
	unset($medialinkquicktag);

/* ==================================================
 * Main
 */
function medialink_func( $atts, $html = NULL ) {

	include_once MEDIALINK_PLUGIN_BASE_DIR.'/inc/MediaLink.php';
	$medialink = new MediaLink();

	extract(shortcode_atts(array(
        'set' => '',
        'sort' => '',
        'suffix' => '',
		'suffix_exclude' => '',
        'display' => '',
        'image_show_size' => '',
        'thumbnail'  => '',
        'generate_rssfeed' => '',
        'rssname' => '',
        'rssmax'  => '',
        'filesize_show'  => '',
        'stamptime_show'  => '',
        'exif_show'  => '',
        'archiveslinks_show'  => '',
        'pagelinks_show'  => '',
        'sortlinks_show'  => '',
        'searchbox_show'  => '',
        'rssicon_show'  => '',
        'credit_show'  => ''
	), $atts));

	$wp_uploads = wp_upload_dir();
	$wp_uploads_baseurl = $wp_uploads['baseurl'];
	$document_root = $wp_uploads['basedir'];
	$topurl = $wp_uploads['baseurl'];

	if ( empty($set) ){
		$set = 'all';
	}
	$medialink->set = $set;

	$character_code = get_option('medialink_character_code');
	$medialink_album = get_option('medialink_album');
	$medialink_all = get_option('medialink_all');
	$medialink_document = get_option('medialink_document');
	$medialink_movie = get_option('medialink_movie');
	$medialink_music = get_option('medialink_music');
	$medialink_css = get_option('medialink_css');

	$rssdef = false;
	if ( $set === 'all' ){
		if( empty($sort) ) { $sort = $medialink_all['sort']; }
		if( empty($suffix_exclude) ) { $suffix_exclude = $medialink_all['suffix_exclude']; }
		$suffix_pattern = $medialink->extpattern($suffix_exclude);
		if( empty($display) ) { $display = intval($medialink_all['display']); }
		if( empty($image_show_size) ) { $image_show_size = $medialink_all['image_show_size']; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $medialink_all['generate_rssfeed']; }
		if( empty($rssname) ) {
			$rssname = $medialink_all['rssname'];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($medialink_all['rssmax']); }
		if( empty($filesize_show) ) { $filesize_show = $medialink_all['filesize_show']; }
		if( empty($stamptime_show) ) { $stamptime_show = $medialink_all['stamptime_show']; }
		if( empty($exif_show) && !empty($medialink_all['exif_show']) ) { $exif_show = $medialink_all['exif_show']; }
		if( empty($archiveslinks_show) ) { $archiveslinks_show = $medialink_all['archiveslinks_show']; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $medialink_all['pagelinks_show']; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $medialink_all['sortlinks_show']; }
		if( empty($searchbox_show) ) { $searchbox_show = $medialink_all['searchbox_show']; }
		if( empty($rssicon_show) ) { $rssicon_show = $medialink_all['rssicon_show']; }
		if( empty($credit_show) ) { $credit_show = $medialink_all['credit_show']; }
	} else if ( $set === 'album' ){
		if( empty($sort) ) { $sort = $medialink_album['sort']; }
		if( empty($suffix_exclude) ) { $suffix_exclude = $medialink_album['suffix_exclude']; }
		if( empty($suffix) ) {
			if ( $medialink_album['suffix'] === 'all' ) {
				$suffix_pattern = $medialink->extpattern($suffix_exclude);
			} else {
				$suffix_pattern = strtoupper($medialink_album['suffix']).','.strtolower($medialink_album['suffix']);
			}
		} else {
			if ( $suffix === 'all' ) {
				$suffix_pattern = $medialink->extpattern($suffix_exclude);
			} else {
				$suffix_pattern = strtoupper($suffix).','.strtolower($suffix);
			}
		}
		if( empty($display) ) { $display = intval($medialink_album['display']); }
		if( empty($image_show_size) ) { $image_show_size = $medialink_album['image_show_size']; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $medialink_album['generate_rssfeed']; }
		if( empty($rssname) ) {
			$rssname = $medialink_album['rssname'];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($medialink_album['rssmax']); }
		if( empty($filesize_show) ) { $filesize_show = $medialink_album['filesize_show']; }
		if( empty($stamptime_show) ) { $stamptime_show = $medialink_album['stamptime_show']; }
		if( empty($exif_show) && !empty($medialink_album['exif_show']) ) { $exif_show = $medialink_album['exif_show']; }
		if( empty($archiveslinks_show) ) { $archiveslinks_show = $medialink_album['archiveslinks_show']; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $medialink_album['pagelinks_show']; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $medialink_album['sortlinks_show']; }
		if( empty($searchbox_show) ) { $searchbox_show = $medialink_album['searchbox_show']; }
		if( empty($rssicon_show) ) { $rssicon_show = $medialink_album['rssicon_show']; }
		if( empty($credit_show) ) { $credit_show = $medialink_album['credit_show']; }
	} else if ( $set === 'movie' ){
		if( empty($sort) ) { $sort = $medialink_movie['sort']; }
		if( empty($suffix) ) {
			$suffix_pattern = strtoupper($medialink_movie['suffix']).','.strtolower($medialink_movie['suffix']);
		} else {
			$suffix_pattern = strtoupper($suffix).','.strtolower($suffix);
		}
		if( empty($display) ) { $display = intval($medialink_movie['display']); }
		if( empty($thumbnail) ) { $thumbnail = $medialink_movie['thumbnail']; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $medialink_movie['generate_rssfeed']; }
		if( empty($rssname) ) {
			$rssname = $medialink_movie['rssname'];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($medialink_movie['rssmax']); }
		if( empty($filesize_show) ) { $filesize_show = $medialink_movie['filesize_show']; }
		if( empty($stamptime_show) ) { $stamptime_show = $medialink_movie['stamptime_show']; }
		if( empty($archiveslinks_show) ) { $archiveslinks_show = $medialink_movie['archiveslinks_show']; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $medialink_movie['pagelinks_show']; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $medialink_movie['sortlinks_show']; }
		if( empty($searchbox_show) ) { $searchbox_show = $medialink_movie['searchbox_show']; }
		if( empty($rssicon_show) ) { $rssicon_show = $medialink_movie['rssicon_show']; }
		if( empty($credit_show) ) { $credit_show = $medialink_movie['credit_show']; }
	} else if ( $set === 'music' ){
		if( empty($sort) ) { $sort = $medialink_music['sort']; }
		if( empty($suffix) ) {
			$suffix_pattern = strtoupper($medialink_music['suffix']).','.strtolower($medialink_music['suffix']);
		} else {
			$suffix_pattern = strtoupper($suffix).','.strtolower($suffix);
		}
		if( empty($display) ) { $display = intval($medialink_music['display']); }
		if( empty($thumbnail) ) { $thumbnail = $medialink_music['thumbnail']; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $medialink_music['generate_rssfeed']; }
		if( empty($rssname) ) {
			$rssname = $medialink_music['rssname'];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($medialink_music['rssmax']); }
		if( empty($filesize_show) ) { $filesize_show = $medialink_music['filesize_show']; }
		if( empty($stamptime_show) ) { $stamptime_show = $medialink_music['stamptime_show']; }
		if( empty($archiveslinks_show) ) { $archiveslinks_show = $medialink_music['archiveslinks_show']; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $medialink_music['pagelinks_show']; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $medialink_music['sortlinks_show']; }
		if( empty($searchbox_show) ) { $searchbox_show = $medialink_music['searchbox_show']; }
		if( empty($rssicon_show) ) { $rssicon_show = $medialink_music['rssicon_show']; }
		if( empty($credit_show) ) { $credit_show = $medialink_music['credit_show']; }
	} else if ( $set === 'document' ){
		if( empty($sort) ) { $sort = $medialink_document['sort']; }
		if( empty($suffix_exclude) ) { $suffix_exclude = $medialink_document['suffix_exclude']; }
		if( empty($suffix) ) {
			if ( $medialink_document['suffix'] === 'all' ) {
				$suffix_pattern = $medialink->extpattern($suffix_exclude);
			} else {
				$suffix_pattern = strtoupper($medialink_document['suffix']).','.strtolower($medialink_document['suffix']);
			}
		} else {
			if ( $suffix === 'all' ) {
				$suffix_pattern = $medialink->extpattern($suffix_exclude);
			} else {
				$suffix_pattern = strtoupper($suffix).','.strtolower($suffix);
			}
		}
		if( empty($display) ) { $display = intval($medialink_document['display']); }
		if( empty($thumbnail) ) { $thumbnail = $medialink_document['thumbnail']; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $medialink_document['generate_rssfeed']; }
		if( empty($rssname) ) {
			$rssname = $medialink_document['rssname'];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($medialink_document['rssmax']); }
		if( empty($filesize_show) ) { $filesize_show = $medialink_document['filesize_show']; }
		if( empty($stamptime_show) ) { $stamptime_show = $medialink_document['stamptime_show']; }
		if( empty($archiveslinks_show) ) { $archiveslinks_show = $medialink_document['archiveslinks_show']; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $medialink_document['pagelinks_show']; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $medialink_document['sortlinks_show']; }
		if( empty($searchbox_show) ) { $searchbox_show = $medialink_document['searchbox_show']; }
		if( empty($rssicon_show) ) { $rssicon_show = $medialink_document['rssicon_show']; }
		if( empty($credit_show) ) { $credit_show = $medialink_document['credit_show']; }
	}

	$mode = NULL;
	$suffix = NULL;

	$archiveparam = NULL;
	$fparam = NULL;
	$page = NULL;
	$search = NULL;
	if (!empty($_GET['mlacv'])){
		$archiveparam = $_GET['mlacv'];	//archives
	}
	if (!empty($_GET['f'])){
		$fparam = $_GET['f'];			//files
	}
	if (!empty($_GET['mlp'])){
		$page = $_GET['mlp'];			//pages
	}
	if (!empty($_GET['mls'])){
		$search = $_GET['mls'];			//search word
	}
	if (!empty($_GET['sort'])){
		$sort = $_GET['sort'];			//sort
	}

	$medialink->character_code = $character_code;
	$medialink->thumbnail = $thumbnail;
	$medialink->image_show_size = $image_show_size;
	$medialink->generate_rssfeed = $generate_rssfeed;
	$medialink->search = $search;
	$medialink->archiveparam = $archiveparam;
	$medialink->topurl = $topurl;
	$medialink->wp_uploads_baseurl = $wp_uploads_baseurl;
	$medialink->document_root = $document_root;
	$medialink->mode = $mode;
	$medialink->rssname = $rssname;
	$medialink->rssmax = $rssmax;
	$medialink->sort = $sort;
	$medialink->filesize_show = $filesize_show;
	$medialink->stamptime_show = $stamptime_show;
	$medialink->exif_show = $exif_show;

	$files = array();
	$titles = array();
	$rssfiles = array();

	$sort_key = NULL;
	$sort_order = NULL;
	if ( $sort === 'new' || empty($sort) ) {
		$sort_key = 'post_date';
		$sort_order = 'DESC';
	} else if ($sort === 'old') {
		$sort_key = 'post_date';
		$sort_order = 'ASC';
	} else if ($sort === 'des') {
		$sort_key = 'post_title';
		$sort_order = 'DESC';
	} else if ($sort === 'asc') {
		$sort_key = 'post_title';
		$sort_order = 'ASC';
	}
	$medialink->sort_order = $sort_order;

	$suffix_patterns = explode(',',$suffix_pattern);
	foreach ( $suffix_patterns as $suffix ) {
		$postmimes[] = $medialink->mime_type('.'.$suffix);
	}
	$postmimes = array_unique($postmimes);
	$mimepattern_count = 0;
	$postmimetype = NULL;
	foreach ( $postmimes as $postmime ) {
		if ( $mimepattern_count == 0 ) {
			$postmimetype .= 'post_mime_type IN("'.$postmime.'"';
		} else {
			$postmimetype .= ',"'.$postmime.'"';
		}
		++ $mimepattern_count;
	}
	$postmimetype .= ')';

	unset ( $suffix_patterns, $postmimes );

	$titlesearch = NULL;
	if ( !empty($search) ) {
		$titlesearch = "AND post_title LIKE '%%$search%%'";
	}

	global $wpdb;
	$attachments = $wpdb->get_results("
					SELECT	ID, guid, post_title, post_date
					FROM	$wpdb->posts
					WHERE	$postmimetype
							$titlesearch
							ORDER BY $sort_key $sort_order
					");

	list($files, $archives, $rssfiles, $rsscount) = $medialink->scan_media($attachments);
	unset($attachments);

	$maxpage = ceil(count($files) / $display);
	if(empty($page)){
		$page = 1;
	}
	$medialink->page = $page;
	$medialink->maxpage = $maxpage;

	add_action( 'wp_footer', array($medialink, 'add_js') );

	$beginfiles = 0;
	$endfiles = 0;
	if( $page == $maxpage){
		$beginfiles = $display * ( $page - 1 );
		$endfiles = count($files) - 1;
	}else{
		$beginfiles = $display * ( $page - 1 );
		$endfiles = ( $display * $page ) - 1;
	}

	$linkfiles = NULL;
	$selectedfilename = NULL;
	if ($files) {
		for ( $i = $beginfiles; $i <= $endfiles; $i++ ) {
			$linkfile = $medialink->print_file($files[$i]['file'],$files[$i]['title'],$files[$i]['thumblink'],$files[$i]['largemediumlink'],$files[$i]['metadata']);
			$linkfiles = $linkfiles.$linkfile;
			if ( $files[$i]['file'] === '/'.$fparam ) {
				$selectedfilename = $files[$i]['title'];
			}
		}
	}

	$archives = array_unique($archives);
	$linkarchives = NULL;
	foreach ($archives as $linkarchive) {
		if( $archiveparam === $linkarchive ){
			$linkarchive = '<option value="'.$linkarchive.'" selected>'.$linkarchive.'</option>';
		}else{
			$linkarchive = '<option value="'.$linkarchive.'">'.$linkarchive.'</option>';
		}
		$linkarchives = $linkarchives.$linkarchive;
	}
	if(empty($archiveparam)){
		$linkarchive = '<option value="" selected>'.__('all', 'medialink').'</option>';
	}else{
		$linkarchive = '<option value="">'.__('all', 'medialink').'</option>';
	}
	$linkarchives = $linkarchives.$linkarchive;

	$linkpages = NULL;
	$linkpages = $medialink->print_pages();

	$scriptname = get_permalink();
	$permlinkstrform = $medialink->permlink_form();

	$prevfile = "";
	if (!empty($fparam)) {
		$prevfile = $topurl.'/'.str_replace("%2F","/",urlencode($fparam));
	}

	$sortlinks = $medialink->sort_pages();

$archiveselectbox = <<<ARCHIVESELECTBOX
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<select name="mlacv" onchange="submit(this.form)">
{$linkarchives}
</select>
</form>
ARCHIVESELECTBOX;

	$searchbutton = __('Search', 'medialink');

$searchform = <<<SEARCHFORM
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<input type="text" name="mls" value="{$search}">
<input type="submit" value="{$searchbutton}">
</form>
SEARCHFORM;

//MoviePlayerContainer
$movieplayercontainer = <<<MOVIEPLAYERCONTAINER
<div id="PlayerContainer-medialink">
<video controls autoplay style="width: 100%;">
<source src="{$prevfile}">
</video>
</div>
MOVIEPLAYERCONTAINER;

//MusicPlayerContainer
$musicplayercontainer = <<<MUSICPLAYERCONTAINER
<div id="PlayerContainer-medialink">
<audio controls autoplay>
<source src="{$prevfile}">
<div id="FlashContainer"></div>
</audio>
</div>
MUSICPLAYERCONTAINER;

	if ( is_single() || is_page() ) {
		wp_enqueue_script('jquery');
		$medialink_infinite = get_option('medialink_infinite');
		$medialink_masonry = get_option('medialink_masonry');
		if ( $medialink_masonry['apply'] && $set === 'album' ) {
			wp_enqueue_script('imagesloaded', MEDIALINK_PLUGIN_URL.'/js/imagesloaded.pkgd.min.js', null, '4.1.0');
			wp_enqueue_script('masonry');
		}
		if ( $medialink_infinite['apply'] ) {
			wp_enqueue_script('infinitescroll', MEDIALINK_PLUGIN_URL.'/js/jquery.infinitescroll.min.js', null, '2.1.0');
		}
	}

	if ( $set === 'all' ){
		if( !empty($selectedfilename) ) { $html .= '<h2>'.$selectedfilename.'</h2>'; }
	} else {
		if ( $set <> 'document' && !empty($selectedfilename) ){
			$html .= '<h2>'.$selectedfilename.'</h2>';
		}
	}

	$fparamexts = explode('.', $fparam);
	$fparamext = end($fparamexts);
	if ( !empty($fparam) ) {
		if ( wp_ext2type($fparamext) === 'video' ) {
			$html .= $movieplayercontainer;
		} else if ( wp_ext2type($fparamext) === 'audio' ) {
			$html .= $musicplayercontainer;
		}
	}

	$linkfiles_begin = NULL;
	$linkfiles_end = NULL;
	$archiveselectbox_begin = NULL;
	$archiveselectbox_end = NULL;
	$linkpages_begin = NULL;
	$linkpages_end = NULL;
	$sortlink_begin = NULL;
	$sortlink_end = NULL;
	$searchform_begin = NULL;
	$searchform_end = NULL;
	$rssfeeds_icon = NULL;

	$archiveselectbox_begin = '<div align="left" style="float: left;">';
	$archiveselectbox_end = '</div>';
	$searchform_begin = '<div align="right">';
	$searchform_end = '</div><div style="clear: both;"></div>';
	$sortlink_begin = '<div style="width: 100%; text-align: center; margin: 15px 0px 20px;">';
	$sortlink_end = '</div></p>';
	$linkfiles_begin = '<div class = "medialink">';
	$linkfiles_end = '</div><div style="clear: both;"></div>';
	$linkpages_begin = '<div style="width: 100%; text-align: center; margin: 15px 0px 20px;">';
	$linkpages_end = '</div>';

	if ( $archiveslinks_show === 'Show' ) {
		$html .= $archiveselectbox_begin;
		$html .= $archiveselectbox;
		$html .= $archiveselectbox_end;
	}

	if ( $searchbox_show === 'Show' ) {
		$html .= $searchform_begin;
		$html .= $searchform;
		$html .= $searchform_end;
	}

	if ( $sortlinks_show === 'Show' ) {
		$html .= $sortlink_begin;
		$html .= $sortlinks;
		$html .= $sortlink_end;
	}

	// RSS Feeds
	if ($generate_rssfeed === 'on') {
		$xml_title =  get_bloginfo('name').' | '.get_the_title();

		$rssfeed_url = $topurl.'/'.$rssname.'.xml';
		$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'" class="dashicons dashicons-rss" style="text-decoration: none;"></a></div>';
		if ( $rssicon_show === 'Show' ) { $html .= $rssfeeds_icon; }
		if ( $rssdef === false ) {
			$html .= '<link rel="alternate" type="application/rss+xml" href="'.$rssfeed_url.'" title="'.$xml_title.'" />';
		}
		if(!empty($rssfiles)){
			$medialink->rss_wirte($xml_title, $rssfiles, $rsscount);
		}
	}

	if ( $credit_show === 'Show' ) {
		$html .= '<div align = "right"><a href="https://wordpress.org/plugins/medialink/"><span style="font-size : xx-small">by MediaLink</span></a></div>';
	}

	$html .= $linkfiles_begin;
	$html .= $linkfiles;
	$html .= $linkfiles_end;

	if ( $pagelinks_show === 'Show' ) {
		$html .= $linkpages_begin;
		$html .= $linkpages;
		$html .= $linkpages_end;
	}

	$html = apply_filters( 'post_medialink', $html );

	return $html;

}

?>