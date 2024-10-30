<?php
/**
 * MediaLink
 * 
 * @package    MediaLink
 * @subpackage MediaLink Management screen
    Copyright (c) 2013- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

class MediaLinkAdmin {

	/* ==================================================
	 * Add a "Settings" link to the plugins page
	 * @since	1.0
	 */
	function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty($this_plugin) ) {
			$this_plugin = MEDIALINK_PLUGIN_BASE_FILE;
		}
		if ( $file == $this_plugin ) {
			$links[] = '<a href="'.admin_url('options-general.php?page=MediaLink').'">'.__( 'Settings').'</a>';
		}
			return $links;
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0
	 */
	function plugin_menu() {
		add_options_page( 'MediaLink Options', 'MediaLink', 'manage_options', 'MediaLink', array($this, 'plugin_options') );
	}

	/* ==================================================
	 * Add Css and Script
	 * @since	2.0
	 */
	function load_custom_wp_admin_style() {
		if ($this->is_my_plugin_screen()) {
			wp_enqueue_style( 'jquery-responsiveTabs', MEDIALINK_PLUGIN_URL.'/css/responsive-tabs.css' );
			wp_enqueue_style( 'jquery-responsiveTabs-style', MEDIALINK_PLUGIN_URL.'/css/style.css' );
			wp_enqueue_style( 'stacktable', MEDIALINK_PLUGIN_URL.'/css/stacktable.css' );
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'jquery-responsiveTabs', MEDIALINK_PLUGIN_URL.'/js/jquery.responsiveTabs.min.js' );
			wp_enqueue_script( 'stacktable', MEDIALINK_PLUGIN_URL.'/js/stacktable.js' );
			wp_enqueue_script( 'medialink-js', MEDIALINK_PLUGIN_URL.'/js/jquery.medialink.js', array('jquery') );
		}
	}

	/* ==================================================
	 * For only admin style
	 * @since	7.31
	 */
	function is_my_plugin_screen() {
		$screen = get_current_screen();
		if (is_object($screen) && $screen->id == 'settings_page_MediaLink') {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0
	 */
	function plugin_options() {

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if( !empty($_POST) ) {
			$this->options_updated(intval($_POST['medialink_admin_tabs']));
		}

		$scriptname = admin_url('options-general.php?page=MediaLink');

		$medialink_character_code = get_option('medialink_character_code');
		$medialink_all = get_option('medialink_all');
		$medialink_album = get_option('medialink_album');
		$medialink_movie = get_option('medialink_movie');
		$medialink_music = get_option('medialink_music');
		$medialink_document = get_option('medialink_document');
		$medialink_css = get_option('medialink_css');
		$medialink_infinite = get_option('medialink_infinite');
		$medialink_masonry = get_option('medialink_masonry');

		?>

		<div id="medialink-loading" style="position: relative; left: 40%; top: 10%;"><img src="<?php echo MEDIALINK_PLUGIN_URL; ?>/css/loading.gif"></div>
		<div class="wrap" id="medialink-loading-container">

		<h2>MediaLink</h2>

	<div id="medialink-admin-tabs">
	  <ul>
	    <li><a href="#medialink-admin-tabs-1"><?php _e('How to use', 'medialink'); ?></a></li>
	    <li><a href="#medialink-admin-tabs-2"><?php _e('Settings'); ?> <?php _e('AllData', 'medialink'); ?></a></li>
	    <li><a href="#medialink-admin-tabs-3"><?php _e('Settings'); ?> <?php _e('Album', 'medialink'); ?></a></li>
	    <li><a href="#medialink-admin-tabs-4"><?php _e('Settings'); ?> <?php _e('Video', 'medialink'); ?></a></li>
	    <li><a href="#medialink-admin-tabs-5"><?php _e('Settings'); ?> <?php _e('Music', 'medialink'); ?></a></li>
	    <li><a href="#medialink-admin-tabs-6"><?php _e('Settings'); ?> <?php _e('Document', 'medialink'); ?></a></li>
		<li><a href="#medialink-admin-tabs-7"><?php _e('Settings'); ?> <?php _e('Other', 'medialink') ?></a></li>
		<li><a href="#medialink-admin-tabs-8"><?php _e('Effect of Images', 'medialink'); ?></a></li>
		<li><a href="#medialink-admin-tabs-9"><?php _e('Caution:'); ?></a></li>
		<li><a href="#medialink-admin-tabs-10"><?php _e('Donate to this plugin &#187;'); ?></a></li>
	<!--
		<li><a href="#medialink-admin-tabs-12">FAQ</a></li>
	 -->
	  </ul>
	  <div id="medialink-admin-tabs-1">
		<h2><?php _e('(In the case of image) Easy use', 'medialink'); ?></h2>
		<p><?php _e('Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.', 'medialink'); ?></p>
		<p><code>&#91;medialink set='album'&#93;</code></p>
		<p><?php _e('When you view this Page, it is displayed in album mode. This is the result of the search of the media library. The Settings> Media, determine the size of the thumbnail. The default value of MediaLink, width 80, height 80. Please set its value. In the Media> Add New, please drag and drop the image. You view the Page again. Should see the image to the Page.', 'medialink'); ?></p>

		<?php _e('MediaLink is also handles video and music and document. If you are dealing with music and video and document, please add the following attributes to the short code.', 'medialink'); ?>
		<p><div><?php _e("Video set = 'movie'", 'medialink'); ?></div>
		<div><?php _e("Music set = 'music'", 'medialink'); ?></div>
		<div><?php _e("Document set = 'document'", 'medialink'); ?></div>
		<p>
		<?php _e("If you want to display in a mix of data, please specify the following attributes to the short code.", 'medialink'); ?>
		<p><div><?php _e("Mix of data set = 'all'", 'medialink'); ?></div>
		<p><div><?php _e('* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.', 'medialink'); ?></div>
		<p><div><?php _e('* When you move to (WordPress > Appearance > Widgets), there is a widget MediaLinkRssFeed. If you place you can set this to display the sidebar link the RSS feed.', 'medialink'); ?></div></p>

		<form method="post" action="<?php echo $scriptname; ?>">
			<input type="hidden" name="medialink_admin_tabs" value="1" />
			<p class="submit">
				<input type="submit" class="button" name="Default" value="<?php _e('Default all settings', 'medialink') ?>" />
			</p>
		</form>

	  </div>

	  <div id="medialink-admin-tabs-2">
		<div class="wrap">

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-2'; ?>">

			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</p>

			<h2><?php _e('Settings'); ?> <?php _e('AllData', 'medialink'); ?></h2>	
			<table id="medialink-table2" border="1">
			<tbody>
				<tr>
					<th align="center" valign="middle"><?php _e('Attribute', 'medialink'); ?></th>
					<th align="center" valign="middle"><?php _e('Value'); ?></th>
					<th align="center" valign="middle"><?php _e('Description'); ?></th>
				</tr>
				<tr>
					<td align="center" valign="middle">set</td>
					<td align="center" valign="middle">all</td>
					<td align="left" valign="middle">
					<?php _e('Next only five. all(all data), album(image), movie(video), music(music), document(document)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sort</td>
					<td align="center" valign="middle">
					<?php $target_all_sort = $medialink_all['sort']; ?>
					<select id="medialink_all_sort" name="medialink_all_sort">
						<option <?php if ('new' == $target_all_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_all_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_all_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_all_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Type of Sort', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix_exclude</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_all_suffix_exclude" name="medialink_all_suffix_exclude" value="<?php echo $medialink_all['suffix_exclude'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Exclude extension.', 'medialink') ?>
						<?php _e('Regular expression is possible.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">display</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_all_display" name="medialink_all_display" value="<?php echo intval($medialink_all['display']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">image_show_size</td>
					<td align="center" valign="middle">
					<?php $target_all_image_show_size = $medialink_all['image_show_size']; ?>
					<select id="medialink_all_image_show_size" name="medialink_all_image_show_size">
						<option <?php if ('Full' == $target_all_image_show_size)echo 'selected="selected"'; ?>>Full</option>
						<option <?php if ('Medium' == $target_all_image_show_size)echo 'selected="selected"'; ?>>Medium</option>
						<option <?php if ('Large' == $target_all_image_show_size)echo 'selected="selected"'; ?>>Large</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Size of the image display. (Media Settings > Image Size)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">thumbnail</td>
					<td align="center" valign="middle">
						-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?>
					</td>
					<td align="left" valign="middle">
						<?php _e('(album) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">generate_rssfeed</td>
					<td align="center" valign="middle">
					<?php $target_all_generate_rssfeed = $medialink_all['generate_rssfeed']; ?>
					<select id="medialink_all_generate_rssfeed" name="medialink_all_generate_rssfeed">
						<option <?php if ('on' == $target_all_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_all_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssname</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_all_rssname" name="medialink_all_rssname" value="<?php echo $medialink_all['rssname'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssmax</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_all_rssmax" name="medialink_all_rssmax" value="<?php echo intval($medialink_all['rssmax']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">filesize_show</td>
					<td align="center" valign="middle">
					<?php $target_all_filesize_show = $medialink_all['filesize_show']; ?>
					<select id="medialink_all_filesize_show" name="medialink_all_filesize_show">
						<option <?php if ('Show' == $target_all_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('File size', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">stamptime_show</td>
					<td align="center" valign="middle">
					<?php $target_all_stamptime_show = $medialink_all['stamptime_show']; ?>
					<select id="medialink_all_stamptime_show" name="medialink_all_stamptime_show">
						<option <?php if ('Show' == $target_all_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Date Time', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">exif_show</td>
					<td align="center" valign="middle">
					<?php
					if ( empty($medialink_all['exif_show']) ) {
						$target_all_exif_show = 'Hide';
					} else {
						$target_all_exif_show = $medialink_all['exif_show'];
					}
					?>
					<select id="medialink_all_exif_show" name="medialink_all_exif_show">
						<option <?php if ('Show' == $target_all_exif_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_exif_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">Exif</td>
				</tr>
				<tr>
					<td align="center" valign="middle">archiveslinks_show</td>
					<td align="center" valign="middle">
					<?php $target_all_archiveslinks_show = $medialink_all['archiveslinks_show']; ?>
					<select id="medialink_all_archiveslinks_show" name="medialink_all_archiveslinks_show">
						<option <?php if ('Show' == $target_all_archiveslinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_archiveslinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of archives.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">pagelinks_show</td>
					<td align="center" valign="middle">
					<?php $target_all_pagelinks_show = $medialink_all['pagelinks_show']; ?>
					<select id="medialink_all_pagelinks_show" name="medialink_all_pagelinks_show">
						<option <?php if ('Show' == $target_all_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sortlinks_show</td>
					<td align="center" valign="middle">
					<?php $target_all_sortlinks_show = $medialink_all['sortlinks_show']; ?>
					<select id="medialink_all_sortlinks_show" name="medialink_all_sortlinks_show">
						<option <?php if ('Show' == $target_all_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">searchbox_show</td>
					<td align="center" valign="middle">
					<?php $target_all_searchbox_show = $medialink_all['searchbox_show']; ?>
					<select id="medialink_all_searchbox_show" name="medialink_all_searchbox_show">
						<option <?php if ('Show' == $target_all_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssicon_show</td>
					<td align="center" valign="middle">
					<?php $target_all_rssicon_show = $medialink_all['rssicon_show']; ?>
					<select id="medialink_all_rssicon_show" name="medialink_all_rssicon_show">
						<option <?php if ('Show' == $target_all_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">credit_show</td>
					<td align="center" valign="middle">
					<?php $target_all_credit_show = $medialink_all['credit_show']; ?>
					<select id="medialink_all_credit_show" name="medialink_all_credit_show">
						<option <?php if ('Show' == $target_all_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'medialink') ?>
					</td>
				</tr>
				<tr>
				<td align="center" valign="middle" colspan="3">
				<?php _e('Alias read extension : ', 'medialink'); ?>
				jpg=(jpg|jpeg|jpe) mp4=(mp4|m4v) mp3=(mp3|m4a|m4b) ogg=(ogg|oga) xls=(xla|xlt|xlw) ppt=(pot|pps)
				</td>
				</tr>
			</tbody>
			</table>

			<input type="hidden" name="medialink_admin_tabs" value="2" />
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-3">
		<div class="wrap">

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-3'; ?>">

			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</p>

			<h2><?php _e('Settings'); ?> <?php _e('Album', 'medialink'); ?></h2>	
			<table id="medialink-table3" border="1">
			<tbody>
				<tr>
					<th align="center" valign="middle"><?php _e('Attribute', 'medialink'); ?></th>
					<th align="center" valign="middle"><?php _e('Value'); ?></th>
					<th align="center" valign="middle"><?php _e('Description'); ?></th>
				</tr>
				<tr>
					<td align="center" valign="middle">set</td>
					<td align="center" valign="middle">album</td>
					<td align="left" valign="middle">
					<?php _e('Next only five. all(all data), album(image), movie(video), music(music), document(document)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sort</td>
					<td align="center" valign="middle">
					<?php $target_album_sort = $medialink_album['sort']; ?>
					<select id="medialink_album_sort" name="medialink_album_sort">
						<option <?php if ('new' == $target_album_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_album_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_album_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_album_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Type of Sort', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix</td>
					<td align="center" valign="middle">
					<?php $target_album_suffix = $medialink_album['suffix']; ?>
					<select id="medialink_album_suffix" name="medialink_album_suffix">
						<option <?php if ('all' == $target_album_suffix)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('image');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_album_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix_exclude</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_album_suffix_exclude" name="medialink_album_suffix_exclude" value="<?php echo $medialink_album['suffix_exclude'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Exclude extension.', 'medialink') ?>
						<?php _e('Regular expression is possible.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">display</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_album_display" name="medialink_album_display" value="<?php echo intval($medialink_album['display']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">image_show_size</td>
					<td align="center" valign="middle">
					<?php $target_album_image_show_size = $medialink_album['image_show_size']; ?>
					<select id="medialink_album_image_show_size" name="medialink_album_image_show_size">
						<option <?php if ('Full' == $target_album_image_show_size)echo 'selected="selected"'; ?>>Full</option>
						<option <?php if ('Medium' == $target_album_image_show_size)echo 'selected="selected"'; ?>>Medium</option>
						<option <?php if ('Large' == $target_album_image_show_size)echo 'selected="selected"'; ?>>Large</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Size of the image display. (Media Settings > Image Size)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">thumbnail</td>
					<td align="center" valign="middle">
						-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?>
					</td>
					<td align="left" valign="middle">
						<?php _e('(album) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">generate_rssfeed</td>
					<td align="center" valign="middle">
					<?php $target_album_generate_rssfeed = $medialink_album['generate_rssfeed']; ?>
					<select id="medialink_album_generate_rssfeed" name="medialink_album_generate_rssfeed">
						<option <?php if ('on' == $target_album_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_album_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssname</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" style="width: 100%;" id="medialink_album_rssname" name="medialink_album_rssname" value="<?php echo $medialink_album['rssname'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssmax</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_album_rssmax" name="medialink_album_rssmax" value="<?php echo intval($medialink_album['rssmax']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">filesize_show</td>
					<td align="center" valign="middle">
					<?php $target_album_filesize_show = $medialink_album['filesize_show']; ?>
					<select id="medialink_album_filesize_show" name="medialink_album_filesize_show">
						<option <?php if ('Show' == $target_album_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('File size', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">stamptime_show</td>
					<td align="center" valign="middle">
					<?php $target_album_stamptime_show = $medialink_album['stamptime_show']; ?>
					<select id="medialink_album_stamptime_show" name="medialink_album_stamptime_show">
						<option <?php if ('Show' == $target_album_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Date Time', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">exif_show</td>
					<td align="center" valign="middle">
					<?php
					if ( empty($medialink_album['exif_show']) ) {
						$target_album_exif_show = 'Hide';
					} else {
						$target_album_exif_show = $medialink_album['exif_show'];
					}
					?>
					<select id="medialink_album_exif_show" name="medialink_album_exif_show">
						<option <?php if ('Show' == $target_album_exif_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_exif_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">Exif</td>
				</tr>
				<tr>
					<td align="center" valign="middle">archiveslinks_show</td>
					<td align="center" valign="middle">
					<?php $target_album_archiveslinks_show = $medialink_album['archiveslinks_show']; ?>
					<select id="medialink_album_archiveslinks_show" name="medialink_album_archiveslinks_show">
						<option <?php if ('Show' == $target_album_archiveslinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_archiveslinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of archives.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">pagelinks_show</td>
					<td align="center" valign="middle">
					<?php $target_album_pagelinks_show = $medialink_album['pagelinks_show']; ?>
					<select id="medialink_album_pagelinks_show" name="medialink_album_pagelinks_show">
						<option <?php if ('Show' == $target_album_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sortlinks_show</td>
					<td align="center" valign="middle">
					<?php $target_album_sortlinks_show = $medialink_album['sortlinks_show']; ?>
					<select id="medialink_album_sortlinks_show" name="medialink_album_sortlinks_show">
						<option <?php if ('Show' == $target_album_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">searchbox_show</td>
					<td align="center" valign="middle">
					<?php $target_album_searchbox_show = $medialink_album['searchbox_show']; ?>
					<select id="medialink_album_searchbox_show" name="medialink_album_searchbox_show">
						<option <?php if ('Show' == $target_album_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssicon_show</td>
					<td align="center" valign="middle">
					<?php $target_album_rssicon_show = $medialink_album['rssicon_show']; ?>
					<select id="medialink_album_rssicon_show" name="medialink_album_rssicon_show">
						<option <?php if ('Show' == $target_album_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">credit_show</td>
					<td align="center" valign="middle">
					<?php $target_album_credit_show = $medialink_album['credit_show']; ?>
					<select id="medialink_album_credit_show" name="medialink_album_credit_show">
						<option <?php if ('Show' == $target_album_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'medialink') ?>
					</td>
				</tr>
				<tr>
				<td align="center" valign="middle" colspan="3">
				<?php _e('Alias read extension : ', 'medialink'); ?>
				jpg=(jpg|jpeg|jpe)
				</td>
				</tr>
			</tbody>
			</table>

			<input type="hidden" name="medialink_admin_tabs" value="3" />
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-4">
		<div class="wrap">

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-4'; ?>">

			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</p>

			<h2><?php _e('Settings'); ?> <?php _e('Video', 'medialink'); ?></h2>	
			<table id="medialink-table4" border="1">
			<tbody>
				<tr>
					<th align="center" valign="middle"><?php _e('Attribute', 'medialink'); ?></th>
					<th align="center" valign="middle"><?php _e('Value'); ?></th>
					<th align="center" valign="middle"><?php _e('Description'); ?></th>
				</tr>
				<tr>
					<td align="center" valign="middle">set</td>
					<td align="center" valign="middle">movie</td>
					<td align="left" valign="middle">
					<?php _e('Next only five. all(all data), album(image), movie(video), music(music), document(document)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sort</td>
					<td align="center" valign="middle">
					<?php $target_movie_sort = $medialink_movie['sort']; ?>
					<select id="medialink_movie_sort" name="medialink_movie_sort">
						<option <?php if ('new' == $target_movie_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_movie_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_movie_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_movie_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Type of Sort', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix = $medialink_movie['suffix']; ?>
					<select id="medialink_movie_suffix" name="medialink_movie_suffix">
						<?php
							$exts = $this->exts('video');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_movie_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">display</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_movie_display" name="medialink_movie_display" value="<?php echo intval($medialink_movie['display']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">thumbnail</td>
					<td align="center" valign="middle">
					<?php $target_movie_thumbnail = $medialink_movie['thumbnail']; ?>
					<select id="medialink_movie_thumbnail" name="medialink_movie_thumbnail">
						<option <?php if ('' == $target_movie_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('icon' == $target_movie_thumbnail)echo 'selected="selected"'; ?>>icon</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('(album) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">generate_rssfeed</td>
					<td align="center" valign="middle">
					<?php $target_movie_generate_rssfeed = $medialink_movie['generate_rssfeed']; ?>
					<select id="medialink_movie_generate_rssfeed" name="medialink_movie_generate_rssfeed">
						<option <?php if ('on' == $target_movie_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_movie_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssname</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_movie_rssname" name="medialink_movie_rssname" value="<?php echo $medialink_movie['rssname'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssmax</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_movie_rssmax" name="medialink_movie_rssmax" value="<?php echo intval($medialink_movie['rssmax']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">filesize_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_filesize_show = $medialink_movie['filesize_show']; ?>
					<select id="medialink_movie_filesize_show" name="medialink_movie_filesize_show">
						<option <?php if ('Show' == $target_movie_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('File size', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">stamptime_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_stamptime_show = $medialink_movie['stamptime_show']; ?>
					<select id="medialink_movie_stamptime_show" name="medialink_movie_stamptime_show">
						<option <?php if ('Show' == $target_movie_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Date Time', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">archiveslinks_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_archiveslinks_show = $medialink_movie['archiveslinks_show']; ?>
					<select id="medialink_movie_archiveslinks_show" name="medialink_movie_archiveslinks_show">
						<option <?php if ('Show' == $target_movie_archiveslinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_archiveslinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of archives.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">pagelinks_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_pagelinks_show = $medialink_movie['pagelinks_show']; ?>
					<select id="medialink_movie_pagelinks_show" name="medialink_movie_pagelinks_show">
						<option <?php if ('Show' == $target_movie_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sortlinks_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_sortlinks_show = $medialink_movie['sortlinks_show']; ?>
					<select id="medialink_movie_sortlinks_show" name="medialink_movie_sortlinks_show">
						<option <?php if ('Show' == $target_movie_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">searchbox_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_searchbox_show = $medialink_movie['searchbox_show']; ?>
					<select id="medialink_movie_searchbox_show" name="medialink_movie_searchbox_show">
						<option <?php if ('Show' == $target_movie_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssicon_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_rssicon_show = $medialink_movie['rssicon_show']; ?>
					<select id="medialink_movie_rssicon_show" name="medialink_movie_rssicon_show">
						<option <?php if ('Show' == $target_movie_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">credit_show</td>
					<td align="center" valign="middle">
					<?php $target_movie_credit_show = $medialink_movie['credit_show']; ?>
					<select id="medialink_movie_credit_show" name="medialink_movie_credit_show">
						<option <?php if ('Show' == $target_movie_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'medialink') ?>
					</td>
				</tr>
				<tr>
				<td align="center" valign="middle" colspan="3">
				<?php _e('Alias read extension : ', 'medialink'); ?>
				mp4=(mp4|m4v)
				</td>
				</tr>
			</tbody>
			</table>

			<input type="hidden" name="medialink_admin_tabs" value="4" />
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-5">
		<div class="wrap">

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-5'; ?>">

			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</p>

			<h2><?php _e('Settings'); ?> <?php _e('Music', 'medialink'); ?></h2>	
			<table id="medialink-table5" border="1">
			<tbody>
				<tr>
					<th align="center" valign="middle"><?php _e('Attribute', 'medialink'); ?></th>
					<th align="center" valign="middle"><?php _e('Value'); ?></th>
					<th align="center" valign="middle"><?php _e('Description'); ?></th>
				</tr>
				<tr>
					<td align="center" valign="middle">set</td>
					<td align="center" valign="middle">music</td>
					<td align="left" valign="middle">
					<?php _e('Next only five. all(all data), album(image), movie(video), music(music), document(document)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sort</td>
					<td align="center" valign="middle">
					<?php $target_music_sort = $medialink_music['sort']; ?>
					<select id="medialink_music_sort" name="medialink_music_sort">
						<option <?php if ('new' == $target_music_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_music_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_music_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_music_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Type of Sort', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix = $medialink_music['suffix']; ?>
					<select id="medialink_music_suffix" name="medialink_music_suffix">
						<?php
							$exts = $this->exts('audio');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_music_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">display</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_music_display" name="medialink_music_display" value="<?php echo intval($medialink_music['display']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">thumbnail</td>
					<td align="center" valign="middle">
					<?php $target_music_thumbnail = $medialink_music['thumbnail']; ?>
					<select id="medialink_music_thumbnail" name="medialink_music_thumbnail">
						<option <?php if ('' == $target_music_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('icon' == $target_music_thumbnail)echo 'selected="selected"'; ?>>icon</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('(album) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">generate_rssfeed</td>
					<td align="center" valign="middle">
					<?php $target_music_generate_rssfeed = $medialink_music['generate_rssfeed']; ?>
					<select id="medialink_music_generate_rssfeed" name="medialink_music_generate_rssfeed">
						<option <?php if ('on' == $target_music_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_music_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssname</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_music_rssname" name="medialink_music_rssname" value="<?php echo $medialink_music['rssname'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssmax</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_music_rssmax" name="medialink_music_rssmax" value="<?php echo intval($medialink_music['rssmax']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">filesize_show</td>
					<td align="center" valign="middle">
					<?php $target_music_filesize_show = $medialink_music['filesize_show']; ?>
					<select id="medialink_music_filesize_show" name="medialink_music_filesize_show">
						<option <?php if ('Show' == $target_music_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('File size', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">stamptime_show</td>
					<td align="center" valign="middle">
					<?php $target_music_stamptime_show = $medialink_music['stamptime_show']; ?>
					<select id="medialink_music_stamptime_show" name="medialink_music_stamptime_show">
						<option <?php if ('Show' == $target_music_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Date Time', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">archiveslinks_show</td>
					<td align="center" valign="middle">
					<?php $target_music_archiveslinks_show = $medialink_music['archiveslinks_show']; ?>
					<select id="medialink_music_archiveslinks_show" name="medialink_music_archiveslinks_show">
						<option <?php if ('Show' == $target_music_archiveslinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_archiveslinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of archives.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">pagelinks_show</td>
					<td align="center" valign="middle">
					<?php $target_music_pagelinks_show = $medialink_music['pagelinks_show']; ?>
					<select id="medialink_music_pagelinks_show" name="medialink_music_pagelinks_show">
						<option <?php if ('Show' == $target_music_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sortlinks_show</td>
					<td align="center" valign="middle">
					<?php $target_music_sortlinks_show = $medialink_music['sortlinks_show']; ?>
					<select id="medialink_music_sortlinks_show" name="medialink_music_sortlinks_show">
						<option <?php if ('Show' == $target_music_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">searchbox_show</td>
					<td align="center" valign="middle">
					<?php $target_music_searchbox_show = $medialink_music['searchbox_show']; ?>
					<select id="medialink_music_searchbox_show" name="medialink_music_searchbox_show">
						<option <?php if ('Show' == $target_music_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssicon_show</td>
					<td align="center" valign="middle">
					<?php $target_music_rssicon_show = $medialink_music['rssicon_show']; ?>
					<select id="medialink_music_rssicon_show" name="medialink_music_rssicon_show">
						<option <?php if ('Show' == $target_music_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">credit_show</td>
					<td align="center" valign="middle">
					<?php $target_music_credit_show = $medialink_music['credit_show']; ?>
					<select id="medialink_music_credit_show" name="medialink_music_credit_show">
						<option <?php if ('Show' == $target_music_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'medialink') ?>
					</td>
				</tr>
				<tr>
				<td align="center" valign="middle" colspan="3">
				<?php _e('Alias read extension : ', 'medialink'); ?>
				mp3=(mp3|m4a|m4b) ogg=(ogg|oga)
				</td>
				</tr>
			</tbody>
			</table>

			<input type="hidden" name="medialink_admin_tabs" value="5" />
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-6">
		<div class="wrap">

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-6'; ?>">

			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</p>

			<h2><?php _e('Settings'); ?> <?php _e('Document', 'medialink'); ?></h2>	
			<table id="medialink-table6" border="1">
			<tbody>
				<tr>
					<th align="center" valign="middle"><?php _e('Attribute', 'medialink'); ?></th>
					<th align="center" valign="middle"><?php _e('Value'); ?></th>
					<th align="center" valign="middle"><?php _e('Description'); ?></th>
				</tr>
				<tr>
					<td align="center" valign="middle">set</td>
					<td align="center" valign="middle">document</td>
					<td align="left" valign="middle">
					<?php _e('Next only five. all(all data), album(image), movie(video), music(music), document(document)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sort</td>
					<td align="center" valign="middle">
					<?php $target_document_sort = $medialink_document['sort']; ?>
					<select id="medialink_document_sort" name="medialink_document_sort">
						<option <?php if ('new' == $target_document_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_document_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_document_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_document_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Type of Sort', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix</td>
					<td align="center" valign="middle">
					<?php $target_document_suffix = $medialink_document['suffix']; ?>
					<select id="medialink_document_suffix" name="medialink_document_suffix">
						<option <?php if ('all' == $target_document_suffix)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('document');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('spreadsheet');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('interactive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('text');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('archive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('code');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">suffix_exclude</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_document_suffix_exclude" name="medialink_document_suffix_exclude" value="<?php echo $medialink_document['suffix_exclude'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Exclude extension.', 'medialink') ?>
						<?php _e('Regular expression is possible.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">display</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_document_display" name="medialink_document_display" value="<?php echo intval($medialink_document['display']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">thumbnail</td>
					<td align="center" valign="middle">
					<?php $target_document_thumbnail = $medialink_document['thumbnail']; ?>
					<select id="medialink_document_thumbnail" name="medialink_document_thumbnail">
						<option <?php if ('' == $target_document_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('icon' == $target_document_thumbnail)echo 'selected="selected"'; ?>>icon</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('(album) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">generate_rssfeed</td>
					<td align="center" valign="middle">
					<?php $target_document_generate_rssfeed = $medialink_document['generate_rssfeed']; ?>
					<select id="medialink_document_generate_rssfeed" name="medialink_document_generate_rssfeed">
						<option <?php if ('on' == $target_document_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_document_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssname</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_document_rssname" name="medialink_document_rssname" value="<?php echo $medialink_document['rssname'] ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'medialink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssmax</td>
					<td align="center" valign="middle">
						<input type="text" style="width: 100%;" id="medialink_document_rssmax" name="medialink_document_rssmax" value="<?php echo intval($medialink_document['rssmax']) ?>" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">filesize_show</td>
					<td align="center" valign="middle">
					<?php $target_document_filesize_show = $medialink_document['filesize_show']; ?>
					<select id="medialink_document_filesize_show" name="medialink_document_filesize_show">
						<option <?php if ('Show' == $target_document_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('File size', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">stamptime_show</td>
					<td align="center" valign="middle">
					<?php $target_document_stamptime_show = $medialink_document['stamptime_show']; ?>
					<select id="medialink_document_stamptime_show" name="medialink_document_stamptime_show">
						<option <?php if ('Show' == $target_document_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Date Time', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">archiveslinks_show</td>
					<td align="center" valign="middle">
					<?php $target_document_archiveslinks_show = $medialink_document['archiveslinks_show']; ?>
					<select id="medialink_document_archiveslinks_show" name="medialink_document_archiveslinks_show">
						<option <?php if ('Show' == $target_document_archiveslinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_archiveslinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of archives.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">pagelinks_show</td>
					<td align="center" valign="middle">
					<?php $target_document_pagelinks_show = $medialink_document['pagelinks_show']; ?>
					<select id="medialink_document_pagelinks_show" name="medialink_document_pagelinks_show">
						<option <?php if ('Show' == $target_document_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">sortlinks_show</td>
					<td align="center" valign="middle">
					<?php $target_document_sortlinks_show = $medialink_document['sortlinks_show']; ?>
					<select id="medialink_document_sortlinks_show" name="medialink_document_sortlinks_show">
						<option <?php if ('Show' == $target_document_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">searchbox_show</td>
					<td align="center" valign="middle">
					<?php $target_document_searchbox_show = $medialink_document['searchbox_show']; ?>
					<select id="medialink_document_searchbox_show" name="medialink_document_searchbox_show">
						<option <?php if ('Show' == $target_document_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">rssicon_show</td>
					<td align="center" valign="middle">
					<?php $target_document_rssicon_show = $medialink_document['rssicon_show']; ?>
					<select id="medialink_document_rssicon_show" name="medialink_document_rssicon_show">
						<option <?php if ('Show' == $target_document_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'medialink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">credit_show</td>
					<td align="center" valign="middle">
					<?php $target_document_credit_show = $medialink_document['credit_show']; ?>
					<select id="medialink_document_credit_show" name="medialink_document_credit_show">
						<option <?php if ('Show' == $target_document_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'medialink') ?>
					</td>
				</tr>
				<tr>
				<td align="center" valign="middle" colspan="3">
				<?php _e('Alias read extension : ', 'medialink'); ?>
				xls=(xla|xlt|xlw) ppt=(pot|pps)
				</td>
				</tr>
			</tbody>
			</table>

			<input type="hidden" name="medialink_admin_tabs" value="7" />
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-7">
		<div class="wrap">

			<h2><?php _e('Settings'); ?> <?php _e('Other', 'medialink') ?></h2>	

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-7'; ?>">

			<div class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</div>

			<div style="padding:10px;border:#CCC 2px solid; margin:0 0 20px 0">
				<h3><?php _e('Size and color.', 'medialink') ?></h3>
				<div style="display: block; padding:5px 20px;">
					<?php _e('The size of the thumbnail in listview.', 'medialink') ?>
					<?php $target_css_listthumbsize = $medialink_css['listthumbsize']; ?>
					<select id="medialink_css_listthumbsize" name="medialink_css_listthumbsize">
						<option <?php if ('40x40' == $target_css_listthumbsize)echo 'selected="selected"'; ?>>40x40</option>
						<option <?php if ('60x60' == $target_css_listthumbsize)echo 'selected="selected"'; ?>>60x60</option>
						<option <?php if ('80x80' == $target_css_listthumbsize)echo 'selected="selected"'; ?>>80x80</option>
					</select>
				</div>
				<div style="display: block; padding:5px 20px;">
					<?php _e('Background color', 'medialink') ?>
					<input type="text" id="medialink_css_linkbackcolor" name="medialink_css_linkbackcolor" value="<?php echo $medialink_css['linkbackcolor'] ?>" size="10" />
				</div>
				<div style="display: block; padding:5px 20px;">
					<?php _e('Hover color', 'medialink') ?>
					<input type="text" id="medialink_css_linkstrcolor" name="medialink_css_linkstrcolor" value="<?php echo $medialink_css['linkstrcolor'] ?>" size="10" />
				</div>
				<div style="display: block; padding:5px 35px;">
					<?php _e('* Color of sorting and pagination. List view is the opposite.', 'medialink') ?>
				</div>
			</div>

			<?php
			if ( function_exists('mb_check_encoding') ) {
			?>
			<div style="width: 100%; height: 100%; margin: 5px; padding: 5px; border: #CCC 2px solid;">
				<h3><?php _e('Character Encodings for Server', 'medialink'); ?></h3>
				<div style="display: block; padding:5px 20px;">
				<?php _e('It may receive an error if you are using a multi-byte name to the file or directory name. In that case, please change.', 'medialink');
				$characterencodings_none_html = '<a href="'.__('https://en.wikipedia.org/wiki/Variable-width_encoding', 'medialink').'" target="_blank" style="text-decoration: none; word-break: break-all;">'.__('variable-width encoding', 'medialink').'</a>';
				echo sprintf(__('If you do not use the filename or directory name of %1$s, please choose "%2$s".','medialink'), $characterencodings_none_html, '<font color="red">none</font>');
				 ?>
				</div>
				<div style="display: block; padding:5px 20px;">
				<select name="medialink_character_code" style="width: 210px">
				<?php
				if ( 'none' === $medialink_character_code ) {
					?>
					<option value="none" selected>none</option>
					<?php
				} else {
					?>
					<option value="none">none</option>
					<?php
				}
				foreach (mb_list_encodings() as $chrcode) {
					if ( $chrcode <> 'pass' && $chrcode <> 'auto' ) {
						if ( $chrcode === $medialink_character_code ) {
							?>
							<option value="<?php echo $chrcode; ?>" selected><?php echo $chrcode; ?></option>
							<?php
						} else {
							?>
							<option value="<?php echo $chrcode; ?>"><?php echo $chrcode; ?></option>
							<?php
						}
					}
				}
				?>
				</select>
				</div>
				<div style="clear: both;"></div>
			</div>
			<?php
			}
			?>

			<div style="clear:both"></div>

			<input type="hidden" name="medialink_admin_tabs" value="8" />
			<div class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</div>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-8">
		<div class="wrap">
		<h2><?php _e('Effect of Images', 'medialink'); ?></h2>

			<form method="post" action="<?php echo $scriptname.'#medialink-admin-tabs-8'; ?>">
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			  <input type="submit" class="button" name="Default" value="<?php _e('Default') ?>" />
			</p>

				<div style="margin: 20px 0; padding: 10px; border: #CCC 2px solid;">
					<h3><?php _e('Infinite Scroll', 'medialink') ?></h3>
					<h4><?php _e('Can apply all.', 'medialink'); ?></h4>
					<div style="display:block; padding: 10px 0;">
						<?php _e('Apply') ?>
					    <input type="checkbox" name="medialink_infinite_apply" value="1" <?php if ( $medialink_infinite['apply'] == TRUE ) { echo 'checked'; }?>>
					</div>
					<div style="display:block; padding: 10px 0;">
						<?php _e('loading_image', 'medialink') ?>
						<input type="text" style="width: 80%;"id="medialink_infinite_loading_image" name="medialink_infinite_loading_image" value="<?php echo $medialink_infinite['loading_image'] ?>" />
					</div>
				</div>
				<div style="clear:both"></div>

				<div style="margin: 20px 0; padding: 10px; border: #CCC 2px solid;">
					<h3><?php _e('Masonry', 'medialink') ?></h3>
					<h4><?php _e('Can apply album only.', 'medialink'); ?></h4>
					<div style="display:block; padding: 10px 0;">
						<?php _e('Apply') ?>
				    	<input type="checkbox" name="medialink_masonry_apply" value="1" <?php if ( $medialink_masonry['apply'] == TRUE ) { echo 'checked'; }?>>
					</div>
					<div style="display:block; padding: 10px 0;">
						<?php _e('Width') ?>
						<input type="text" size=3 id="medialink_masonry_width" name="medialink_masonry_width" value="<?php echo $medialink_masonry['width'] ?>" />px
					</div>
				</div>
				<div style="clear:both"></div>

				<div style="margin: 20px 0; padding: 10px; border: #CCC 2px solid;">
					<h3><?php _e('Filter', 'medialink') ?></h3>
					<?php
						if ( is_multisite() ) {
							$boxersandswipers_install_url = network_admin_url('plugin-install.php?tab=plugin-information&plugin=Boxers+and+Swipers');
						} else {
							$boxersandswipers_install_url = admin_url('plugin-install.php?tab=plugin-information&plugin=Boxers+and+Swipers');
						}
						$boxersandswipers_install_html = '<a href="'.$boxersandswipers_install_url.'" target="_blank" style="text-decoration: none; word-break: break-all;">Boxers and Swipers</a>';
					?>
					<div style="padding: 5px 20px; font-weight: bold;"><?php echo sprintf(__('If you want to use %1$s, add the following sentence to boxersandswipers.php. on line 62', 'medialink'), $boxersandswipers_install_html); ?></div>
					<div style="padding: 5px 35px;">
					<code>add_filter('post_medialink', array($boxersandswipers, 'add_anchor_tag'));</code>
					</div>
					<div style="padding: 5px 20px; font-weight: bold;"><?php _e('In addition, offer the following filters. This filter passes the html that is generated.', 'medialink'); ?></div>
					<div style="padding: 5px 35px;">
					<code>post_medialink</code>
					</div>
				</div>
				<div style="clear:both"></div>

			<input type="hidden" name="medialink_admin_tabs" value="9" />
			<p class="submit">
			  <input type="submit" class="button" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			</form>

		</div>
	  </div>

	  <div id="medialink-admin-tabs-9">
		<div class="wrap">

			<div style="width: 100%; height: 100%; margin: 5px; padding: 5px; border: #CCC 2px solid;">
				<?php
				if ( is_multisite() ) {
					$mimetypesplus_install_url = network_admin_url('plugin-install.php?tab=plugin-information&plugin=mime-types-plus');
				} else {
					$mimetypesplus_install_url = admin_url('plugin-install.php?tab=plugin-information&plugin=mime-types-plus');
				}
				$mimetypesplus_install_html = '<a href="'.$mimetypesplus_install_url.'" target="_blank" style="text-decoration: none; word-break: break-all;">Mime Types Plus</a>';
				?>
				<h3><?php echo sprintf(__('If you want to add the mime type that can be used in the media library to each file type, Please use the %1$s.','medialink'), $mimetypesplus_install_html); ?></div>
				</h3>
			</div>

	  </div>
		<div id="medialink-admin-tabs-10">
		<div class="wrap">
			<?php
			$plugin_datas = get_file_data( MEDIALINK_PLUGIN_BASE_DIR.'/medialink.php', array('version' => 'Version') );
			$plugin_version = __('Version:').' '.$plugin_datas['version'];
			?>
			<h4 style="margin: 5px; padding: 5px;">
			<?php echo $plugin_version; ?>
			</h4>
			<div style="width: 250px; height: 170px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
			<h3><?php _e('Please make a donation if you like my work or would like to further the development of this plugin.', 'medialink'); ?></h3>
			<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
	<a style="margin: 5px; padding: 5px;" href='https://pledgie.com/campaigns/28307' target="_blank"><img alt='Click here to lend your support to: Various Plugins for WordPress and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/28307.png?skin_name=chrome' border='0' ></a>
			</div>
		</div>
		</div>

	<!--
	  <div id="medialink-admin-tabs-11">
		<div class="wrap">
		<h2>FAQ</h2>

		</div>
	  </div>
	-->

	</form>
	</div>

		</div>
		<?php
	}

	/* ==================================================
	 * @param	string	$ext2type
	 * @return	array	$exts
	 * @since	3.2
	 */
	function exts($ext2type){

		global $user_ID;
		$mimes = get_allowed_mime_types($user_ID);

		foreach ($mimes as $ext => $mime) {
			if( strpos($ext,  '|') <> FALSE ) {
				$extstmp = explode('|', $ext );
				foreach ( $extstmp as $exttmp ) {
					if ( wp_ext2type($exttmp) === $ext2type ) {
						$exts[] = $exttmp;
					}
				}
			} else {
				if ( wp_ext2type($ext) === $ext2type ) {
					$exts[] = $ext;
				}
			}
		}

		return $exts;

	}

	/* ==================================================
	 * Update wp_options table.
	 * @param	string	$tabs
	 * @since	4.4
	 */
	function options_updated($tabs){

		if( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && get_locale() === 'ja' ) { // Japanese Windows
			$medialink_character_code_reset = 'CP932';
		} else {
			$medialink_character_code_reset = 'UTF-8';
		}

		$all_reset_tbl = array(
						'sort' => 'new',
						'suffix_exclude' => '',
						'display' => 8, 	
						'image_show_size' => 'Full',
						'generate_rssfeed' => 'on',
						'rssname' => 'medialink_all_feed',
						'rssmax' => 10,
						'filesize_show' => 'Show',
						'stamptime_show' => 'Show',
						'exif_show' => 'Show',
						'archiveslinks_show' => 'Show',
						'pagelinks_show' => 'Show',
						'sortlinks_show' => 'Show',
						'searchbox_show' => 'Show',
						'rssicon_show' => 'Show',
						'credit_show' => 'Show'
					);
		$album_reset_tbl = array(
						'sort' => 'new',
						'suffix' => 'all',
						'suffix_exclude' => '',
						'display' => 20, 	
						'image_show_size' => 'Full',
						'generate_rssfeed' => 'on',
						'rssname' => 'medialink_album_feed',
						'rssmax' => 10,
						'filesize_show' => 'Show',
						'stamptime_show' => 'Show',
						'exif_show' => 'Show',
						'archiveslinks_show' => 'Show',
						'pagelinks_show' => 'Show',
						'sortlinks_show' => 'Show',
						'searchbox_show' => 'Show',
						'rssicon_show' => 'Show',
						'credit_show' => 'Show'
					);
		$movie_reset_tbl = array(
						'sort' => 'new',
						'suffix' => 'mp4',
						'display' => 8,
						'thumbnail' => '',
						'generate_rssfeed' => 'on',
						'rssname' => 'medialink_movie_feed',
						'rssmax' => 10,
						'filesize_show' => 'Show',
						'stamptime_show' => 'Show',
						'archiveslinks_show' => 'Show',
						'pagelinks_show' => 'Show',
						'sortlinks_show' => 'Show',
						'searchbox_show' => 'Show',
						'rssicon_show' => 'Show',
						'credit_show' => 'Show'
					);
		$music_reset_tbl = array(
						'sort' => 'new',
						'suffix' => 'mp3',
						'display' => 8,
						'thumbnail' => '',
						'generate_rssfeed' => 'on',
						'rssname' => 'medialink_music_feed',
						'rssmax' => 10,
						'filesize_show' => 'Show',
						'stamptime_show' => 'Show',
						'archiveslinks_show' => 'Show',
						'pagelinks_show' => 'Show',
						'sortlinks_show' => 'Show',
						'searchbox_show' => 'Show',
						'rssicon_show' => 'Show',
						'credit_show' => 'Show'
					);
		$document_reset_tbl = array(
						'sort' => 'new',
						'suffix' => 'all',
						'suffix_exclude' => '',
						'display' => 20,
						'thumbnail' => 'icon',
						'generate_rssfeed' => 'on',
						'rssname' => 'medialink_document_feed',
						'rssmax' => 10,
						'filesize_show' => 'Show',
						'stamptime_show' => 'Show',
						'archiveslinks_show' => 'Show',
						'pagelinks_show' => 'Show',
						'sortlinks_show' => 'Show',
						'searchbox_show' => 'Show',
						'rssicon_show' => 'Show',
						'credit_show' => 'Show'
					);
		$css_reset_tbl = array(
						'listthumbsize' => '40x40',
						'linkstrcolor' => '#ffffff',
						'linkbackcolor' => '#f6efe2'
					);
		$loading_image = MEDIALINK_PLUGIN_URL.'/img/ajax-loader.gif';
		$infinite_reset_tbl = array(
							'apply' => FALSE,
							'loading_image' => $loading_image
							);
		$masonry_reset_tbl = array(
							'apply' => FALSE,
							'width' => 100
							);

		switch ($tabs) {
			case 1:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_character_code', $medialink_character_code_reset );
					update_option( 'medialink_all', $all_reset_tbl );
					update_option( 'medialink_album', $album_reset_tbl );
					update_option( 'medialink_movie', $movie_reset_tbl );
					update_option( 'medialink_music', $music_reset_tbl );
					update_option( 'medialink_document', $document_reset_tbl );
					update_option( 'medialink_css', $css_reset_tbl );
					update_option( 'medialink_exclude', $exclude_reset_tbl );
					update_option( 'medialink_infinite', $infinite_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('All Settings').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 2:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_all', $all_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('AllData', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					$all_tbl = array(
									'sort' => $_POST['medialink_all_sort'],
									'suffix_exclude' => $_POST['medialink_all_suffix_exclude'],
									'display' => intval($_POST['medialink_all_display']),
									'image_show_size' => $_POST['medialink_all_image_show_size'],
									'generate_rssfeed' => $_POST['medialink_all_generate_rssfeed'],
									'rssname' => $_POST['medialink_all_rssname'],
									'rssmax' => intval($_POST['medialink_all_rssmax']),
									'filesize_show' => $_POST['medialink_all_filesize_show'],
									'stamptime_show' => $_POST['medialink_all_stamptime_show'],
									'exif_show' => $_POST['medialink_all_exif_show'],
									'archiveslinks_show' => $_POST['medialink_all_archiveslinks_show'],
									'pagelinks_show' => $_POST['medialink_all_pagelinks_show'],
									'sortlinks_show' => $_POST['medialink_all_sortlinks_show'],
									'searchbox_show' => $_POST['medialink_all_searchbox_show'],
									'rssicon_show' => $_POST['medialink_all_rssicon_show'],
									'credit_show' => $_POST['medialink_all_credit_show']
								);
					update_option( 'medialink_all', $all_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('AllData', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 3:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_album', $album_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Album', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					$album_tbl = array(
									'sort' => $_POST['medialink_album_sort'],
									'suffix' => $_POST['medialink_album_suffix'],
									'suffix_exclude' => $_POST['medialink_album_suffix_exclude'],
									'display' => intval($_POST['medialink_album_display']),
									'image_show_size' => $_POST['medialink_album_image_show_size'],
									'generate_rssfeed' => $_POST['medialink_album_generate_rssfeed'],
									'rssname' => $_POST['medialink_album_rssname'],
									'rssmax' => intval($_POST['medialink_album_rssmax']),
									'filesize_show' => $_POST['medialink_album_filesize_show'],
									'stamptime_show' => $_POST['medialink_album_stamptime_show'],
									'exif_show' => $_POST['medialink_album_exif_show'],
									'archiveslinks_show' => $_POST['medialink_album_archiveslinks_show'],
									'pagelinks_show' => $_POST['medialink_album_pagelinks_show'],
									'sortlinks_show' => $_POST['medialink_album_sortlinks_show'],
									'searchbox_show' => $_POST['medialink_album_searchbox_show'],
									'rssicon_show' => $_POST['medialink_album_rssicon_show'],
									'credit_show' => $_POST['medialink_album_credit_show']
								);
					update_option( 'medialink_album', $album_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Album', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 4:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_movie', $movie_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Video', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					$movie_tbl = array(
									'sort' => $_POST['medialink_movie_sort'],
									'suffix' => $_POST['medialink_movie_suffix'],
									'display' => intval($_POST['medialink_movie_display']),
									'thumbnail' => $_POST['medialink_movie_thumbnail'],
									'generate_rssfeed' => $_POST['medialink_movie_generate_rssfeed'],
									'rssname' => $_POST['medialink_movie_rssname'],
									'rssmax' => intval($_POST['medialink_movie_rssmax']),
									'filesize_show' => $_POST['medialink_movie_filesize_show'],
									'stamptime_show' => $_POST['medialink_movie_stamptime_show'],
									'archiveslinks_show' => $_POST['medialink_movie_archiveslinks_show'],
									'pagelinks_show' => $_POST['medialink_movie_pagelinks_show'],
									'sortlinks_show' => $_POST['medialink_movie_sortlinks_show'],
									'searchbox_show' => $_POST['medialink_movie_searchbox_show'],
									'rssicon_show' => $_POST['medialink_movie_rssicon_show'],
									'credit_show' => $_POST['medialink_movie_credit_show']
								);
					update_option( 'medialink_movie', $movie_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Video', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 5:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_music', $music_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Music', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					$music_tbl = array(
									'sort' => $_POST['medialink_music_sort'],
									'suffix' => $_POST['medialink_music_suffix'],
									'display' => intval($_POST['medialink_music_display']),
									'thumbnail' => $_POST['medialink_music_thumbnail'],
									'generate_rssfeed' => $_POST['medialink_music_generate_rssfeed'],
									'rssname' => $_POST['medialink_music_rssname'],
									'rssmax' => intval($_POST['medialink_music_rssmax']),
									'filesize_show' => $_POST['medialink_music_filesize_show'],
									'stamptime_show' => $_POST['medialink_music_stamptime_show'],
									'archiveslinks_show' => $_POST['medialink_music_archiveslinks_show'],
									'pagelinks_show' => $_POST['medialink_music_pagelinks_show'],
									'sortlinks_show' => $_POST['medialink_music_sortlinks_show'],
									'searchbox_show' => $_POST['medialink_music_searchbox_show'],
									'rssicon_show' => $_POST['medialink_music_rssicon_show'],
									'credit_show' => $_POST['medialink_music_credit_show']
								);
					update_option( 'medialink_music', $music_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Music', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 6:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_document', $document_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Document', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					$document_tbl = array(
									'sort' => $_POST['medialink_document_sort'],
									'suffix' => $_POST['medialink_document_suffix'],
									'suffix_exclude' => $_POST['medialink_document_suffix_exclude'],
									'display' => intval($_POST['medialink_document_display']),
									'thumbnail' => $_POST['medialink_document_thumbnail'],
									'generate_rssfeed' => $_POST['medialink_document_generate_rssfeed'],
									'rssname' => $_POST['medialink_document_rssname'],
									'rssmax' => intval($_POST['medialink_document_rssmax']),
									'filesize_show' => $_POST['medialink_document_filesize_show'],
									'stamptime_show' => $_POST['medialink_document_stamptime_show'],
									'archiveslinks_show' => $_POST['medialink_document_archiveslinks_show'],
									'pagelinks_show' => $_POST['medialink_document_pagelinks_show'],
									'sortlinks_show' => $_POST['medialink_document_sortlinks_show'],
									'searchbox_show' => $_POST['medialink_document_searchbox_show'],
									'rssicon_show' => $_POST['medialink_document_rssicon_show'],
									'credit_show' => $_POST['medialink_document_credit_show']
								);
					update_option( 'medialink_document', $document_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Document', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 7:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_character_code', $medialink_character_code_reset );
					update_option( 'medialink_css', $css_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Size and color.', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					update_option( 'medialink_character_code', $_POST['medialink_character_code'] );
					$css_tbl = array(
									'listthumbsize' => $_POST['medialink_css_listthumbsize'],
									'linkstrcolor' => $_POST['medialink_css_linkstrcolor'],
									'linkbackcolor' => $_POST['medialink_css_linkbackcolor']
								);
					update_option( 'medialink_css', $css_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Size and color.', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
			case 8:
				if ( !empty($_POST['Default']) ) {
					update_option( 'medialink_infinite', $infinite_reset_tbl );
					update_option( 'medialink_masonry', $masonry_reset_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Effect of Images', 'medialink').' --> '.__('Default').' --> '.__('Changes saved.').'</li></ul></div>';
				} else {
					if ( !empty($_POST['medialink_infinite_apply']) ) {
						$medialink_infinite_apply = intval($_POST['medialink_infinite_apply']);
					} else {
						$medialink_infinite_apply = 0;
					}
					$infinite_tbl = array(
									'apply' => $medialink_infinite_apply,
									'loading_image' => $_POST['medialink_infinite_loading_image']
									);
					update_option( 'medialink_infinite', $infinite_tbl );
					if ( !empty($_POST['medialink_masonry_apply']) ) {
						$medialink_masonry_apply = intval($_POST['medialink_masonry_apply']);
					} else {
						$medialink_masonry_apply = 0;
					}
					$masonry_tbl = array(
										'apply' => $medialink_masonry_apply,
										'width' => intval($_POST['medialink_masonry_width'])
										);
					update_option( 'medialink_masonry', $masonry_tbl );
					echo '<div class="updated"><ul><li>'.__('Settings').__('Effect of Images', 'medialink').' --> '.__('Changes saved.').'</li></ul></div>';
				}
				break;
		}

	}

	/* ==================================================
	 * Closed Plugin
	 */
	function closed_plugin() {

		if ($this->is_my_plugin_screen()) {
			echo '<div class="notice notice-error is-dismissible"><ul><li>'.__('I decided to close this plugin. Because code is complicated and it feels difficult to maintain. Thanks for using it until now. It will be coming soon. Please use it at your own risk after closing.', 'medialink').'</li></ul></div>';
		}

	}

}

?>