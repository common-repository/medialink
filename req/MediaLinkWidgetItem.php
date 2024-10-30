<?php
/**
 * MediaLink
 * 
 * @package    MediaLink
 * @subpackage MediaLink Widget
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

/* ==================================================
 * Widget
 * @since	1.12
 */
class MediaLinkWidgetItem extends WP_Widget {

	function __construct() {
		parent::__construct(
			'MediaLinkWidgetItem', // Base ID
			__( 'MediaLinkRssFeed' ), // Name
			array( 'description' => __( 'Entries of RSS feed from MediaLink.', 'medialink'), ) // Args
		);
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$checkbox1 = apply_filters('widget_checkbox', $instance['checkbox1']);
		$checkbox2 = apply_filters('widget_checkbox', $instance['checkbox2']);
		$checkbox3 = apply_filters('widget_checkbox', $instance['checkbox3']);
		$checkbox4 = apply_filters('widget_checkbox', $instance['checkbox4']);
		$checkbox5 = apply_filters('widget_checkbox', $instance['checkbox5']);
		$checkbox6 = apply_filters('widget_checkbox', $instance['checkbox6']);
		$checkbox7 = apply_filters('widget_checkbox', $instance['checkbox7']);

		$wp_uploads = wp_upload_dir();

		$medialink_album = get_option('medialink_album');
		$medialink_all = get_option('medialink_all');
		$medialink_document = get_option('medialink_document');
		$medialink_movie = get_option('medialink_movie');
		$medialink_music = get_option('medialink_music');

		$xmlurl2 = get_bloginfo('comments_rss2_url');
		$xml3 = '/'.$medialink_all['rssname'].'.xml';
		$xml4 = '/'.$medialink_album['rssname'].'.xml';
		$xml5 = '/'.$medialink_movie['rssname'].'.xml';
		$xml6 = '/'.$medialink_music['rssname'].'.xml';
		$xml7 = '/'.$medialink_document['rssname'].'.xml';
		$iconclass =  'class="dashicons dashicons-rss" style="text-decoration: none;"';
		if ($title) {
			echo $before_widget;
			echo $before_title . $title . $after_title;
			if ($checkbox1) {
				?>
				<div style="font-size:x-small;">
				<a href="<?php echo bloginfo('rss2_url'); ?>" <?php echo $iconclass; ?>></a>
				<?php echo bloginfo('name'); ?>
				</div>
				<?php
			}
			if ($checkbox2) {
				$xmldata2 = @simplexml_load_file($xmlurl2);
				if ( !empty($xmldata2) ) {
					?>
					<div style="font-size:x-small;">
					<a href="<?php echo bloginfo('comments_rss2_url'); ?>" <?php echo $iconclass; ?>></a>
					<?php echo $xmldata2->channel->title; ?>
					</div>
					<?php
				}
			}	
			if ($checkbox3 && file_exists($wp_uploads['basedir'].$xml3)) {
				$xmldata3 = simplexml_load_file($wp_uploads['baseurl'].$xml3);
				?>
				<div style="font-size:x-small;">
				<a href="<?php echo $wp_uploads['baseurl'].$xml3; ?>" <?php echo $iconclass; ?>></a>
				<?php echo $xmldata3->channel->title; ?>
				</div>
				<?php
			}
			if ($checkbox4 && file_exists($wp_uploads['basedir'].$xml4)) {
				$xmldata4 = simplexml_load_file($wp_uploads['baseurl'].$xml4);
				?>
				<div style="font-size:x-small;">
				<a href="<?php echo $wp_uploads['baseurl'].$xml4; ?>" <?php echo $iconclass; ?>></a>
				<?php echo $xmldata4->channel->title; ?>
				</div>
				<?php
			}
			if ($checkbox5 && file_exists($wp_uploads['basedir'].$xml5)) {
				$xmldata5 = simplexml_load_file($wp_uploads['baseurl'].$xml5);
				?>
				<div style="font-size:x-small;">
				<a href="<?php echo $wp_uploads['baseurl'].$xml5; ?>" <?php echo $iconclass; ?>></a>
				<?php echo $xmldata5->channel->title; ?>
				</div>
				<?php
			}
			if ($checkbox6 && file_exists($wp_uploads['basedir'].$xml6)) {
				$xmldata6 = simplexml_load_file($wp_uploads['baseurl'].$xml6);
				?>
				<div style="font-size:x-small;">
				<a href="<?php echo $wp_uploads['baseurl'].$xml6; ?>" <?php echo $iconclass; ?>></a>
				<?php echo $xmldata6->channel->title; ?>
				</div>
				<?php
			}
			if ($checkbox7 && file_exists($wp_uploads['basedir'].$xml7)) {
				$xmldata7 = simplexml_load_file($wp_uploads['baseurl'].$xml7);
				?>
				<div style="font-size:x-small;">
				<a href="<?php echo $wp_uploads['baseurl'].$xml7; ?>" <?php echo $iconclass; ?>></a>
				<?php echo $xmldata7->channel->title; ?>
				</div>
				<?php
			}
			echo $after_widget;
		}
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['checkbox1'] = strip_tags($new_instance['checkbox1']);
		$instance['checkbox2'] = strip_tags($new_instance['checkbox2']);
		$instance['checkbox3'] = strip_tags($new_instance['checkbox3']);
		$instance['checkbox4'] = strip_tags($new_instance['checkbox4']);
		$instance['checkbox5'] = strip_tags($new_instance['checkbox5']);
		$instance['checkbox6'] = strip_tags($new_instance['checkbox6']);
		$instance['checkbox7'] = strip_tags($new_instance['checkbox7']);
		return $instance;
	}
	
	function form($instance) {

		if (isset($instance['title'])) {
			$title = esc_attr($instance['title']);
		} else {
			$title = NULL;
		}
		if (isset($instance['checkbox1'])) {
			$checkbox1 = esc_attr($instance['checkbox1']);
		} else {
			$checkbox1 = NULL;
		}
		if (isset($instance['checkbox2'])) {
			$checkbox2 = esc_attr($instance['checkbox2']);
		} else {
			$checkbox2 = NULL;
		}
		if (isset($instance['checkbox3'])) {
			$checkbox3 = esc_attr($instance['checkbox3']);
		} else {
			$checkbox3 = NULL;
		}
		if (isset($instance['checkbox4'])) {
			$checkbox4 = esc_attr($instance['checkbox4']);
		} else {
			$checkbox4 = NULL;
		}
		if (isset($instance['checkbox5'])) {
			$checkbox5 = esc_attr($instance['checkbox5']);
		} else {
			$checkbox5 = NULL;
		}
		if (isset($instance['checkbox6'])) {
			$checkbox6 = esc_attr($instance['checkbox6']);
		} else {
			$checkbox6 = NULL;
		}
		if (isset($instance['checkbox7'])) {
			$checkbox7 = esc_attr($instance['checkbox7']);
		} else {
			$checkbox7 = NULL;
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<div><?php echo get_bloginfo('name'); ?>:</div>
		<table>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox1'); ?> ">
<input class="widefat" id="<?php echo $this->get_field_id('checkbox1'); ?>" name="<?php echo $this->get_field_name('checkbox1'); ?>" type="checkbox"<?php checked('Blog', $checkbox1); ?> value="Blog" />
			<?php _e('Entries (RSS)'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox2'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox2'); ?>" name="<?php echo $this->get_field_name('checkbox2'); ?>" type="checkbox"<?php checked('Blog Comments', $checkbox2); ?> value="Blog Comments" />
			<?php _e('Comments (RSS)'); ?></label>
		</td>
		</tr>
		</table>
		<div>MediaLink:</div>
		<table>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox3'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox3'); ?>" name="<?php echo $this->get_field_name('checkbox3'); ?>" type="checkbox"<?php checked('All data', $checkbox3); ?> value="All data" />
			<?php _e('All data (Podcast)', 'medialink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox4'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox4'); ?>" name="<?php echo $this->get_field_name('checkbox4'); ?>" type="checkbox"<?php checked('Album', $checkbox4); ?> value="Album" />
			<?php _e('Album (RSS)', 'medialink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox5'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox5'); ?>" name="<?php echo $this->get_field_name('checkbox5'); ?>" type="checkbox"<?php checked('Movie', $checkbox5); ?> value="Movie" />
			<?php _e('Video (Podcast)', 'medialink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox6'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox6'); ?>" name="<?php echo $this->get_field_name('checkbox6'); ?>" type="checkbox"<?php checked('Music', $checkbox6); ?> value="Music" />
			<?php _e('Music (Podcast)', 'medialink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox7'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox7'); ?>" name="<?php echo $this->get_field_name('checkbox7'); ?>" type="checkbox"<?php checked('Document', $checkbox7); ?> value="Document" />
			<?php _e('Document (RSS)', 'medialink'); ?></label>
		</td>
		</tr>
		</table>
		<?php
	}
}

?>