<?php
/**
 * MediaLink
 * 
 * @package    MediaLink
 * @subpackage MediaLink Add quicktag
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
 * 
 * @since	4.1
 */
class MediaLinkQuickTag {

	function add_quicktag_select(){

		$all = __('AllData', 'medialink');
		$image = __('Image');
		$video = __('Video');
		$music = __('Music', 'medialink');
		$documents = __('Document', 'medialink');

$quicktag_add_select = <<<QUICKTAGADDSELECT
<select id="medialink_select">
	<option value="">MediaLink</option>
	<option value="[medialink set='all']">{$all}</option>
	<option value="[medialink set='album']">{$image}</option>
	<option value="[medialink set='movie']">{$video}</option>
	<option value="[medialink set='music']">{$music}</option>
	<option value="[medialink set='document']">{$documents}</option>
</select>
QUICKTAGADDSELECT;
		echo $quicktag_add_select;

	}

	function add_quicktag_button_js() {
		if ($this->is_my_plugin_screen()) {

$quicktag_add_js = <<<QUICKTAGADDJS

<!-- BEGIN: MediaLink -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#medialink_select").change(function() {
			send_to_editor(jQuery("#medialink_select :selected").val());
			return false;
		});
	});
</script>
<!-- END: MediaLink -->

QUICKTAGADDJS;
			echo $quicktag_add_js;

		}
	}

	/* ==================================================
	 * For only admin style
	 * @since	7.31
	 */
	function is_my_plugin_screen() {
		$screen = get_current_screen();
		if ( $screen->post_type === 'post' || $screen->post_type === 'page' ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}

?>