<?php
/**
 * MediaLink
 * 
 * @package    MediaLink
 * @subpackage MediaLink registered in the database and generate header
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

class MediaLinkRegistAndHeader {

	/* ==================================================
	 * Settings register
	 * @since	1.1
	 */
	function register_settings(){

		if( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && get_locale() === 'ja' ) { // Japanese Windows
			$character_code = 'CP932';
		} else {
			$character_code = 'UTF-8';
		}
		if ( !get_option('medialink_character_code') ) {
			update_option('medialink_character_code', $character_code);
		}

		if ( !get_option('medialink_all') ) {
			$all_tbl = array(
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
			update_option( 'medialink_all', $all_tbl );
		}

		if ( !get_option('medialink_album') ) {
			$album_tbl = array(
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
			update_option( 'medialink_album', $album_tbl );
		}

		if ( !get_option('medialink_movie') ) {
			$movie_tbl = array(
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
			update_option( 'medialink_movie', $movie_tbl );
		} else { // Version < 7.40
			$medialink_movie = get_option('medialink_movie');
			if ( array_key_exists( "suffix_2", $medialink_movie ) ) {
				$movie_tbl = array(
								'sort' => $medialink_movie['sort'],
								'suffix' => $medialink_movie['suffix'],
								'display' => intval($medialink_movie['display']),
								'thumbnail' => $medialink_movie['thumbnail'],
								'generate_rssfeed' => $medialink_movie['generate_rssfeed'],
								'rssname' => $medialink_movie['rssname'],
								'rssmax' => intval($medialink_movie['rssmax']),
								'filesize_show' => $medialink_movie['filesize_show'],
								'stamptime_show' => $medialink_movie['stamptime_show'],
								'archiveslinks_show' => $medialink_movie['archiveslinks_show'],
								'pagelinks_show' => $medialink_movie['pagelinks_show'],
								'sortlinks_show' => $medialink_movie['sortlinks_show'],
								'searchbox_show' => $medialink_movie['searchbox_show'],
								'rssicon_show' => $medialink_movie['rssicon_show'],
								'credit_show' => $medialink_movie['credit_show']
							);
				update_option( 'medialink_movie', $movie_tbl );
			}
		}

		if ( !get_option('medialink_music') ) {
			$music_tbl = array(
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
			update_option( 'medialink_music', $music_tbl );
		} else { // Version < 7.40
			$medialink_music = get_option('medialink_music');
			if ( array_key_exists( "suffix_2", $medialink_music ) ) {
				$music_tbl = array(
								'sort' => $medialink_music['sort'],
								'suffix' => $medialink_music['suffix'],
								'display' => intval($medialink_music['display']),
								'thumbnail' => $medialink_music['thumbnail'],
								'generate_rssfeed' => $medialink_music['generate_rssfeed'],
								'rssname' => $medialink_music['rssname'],
								'rssmax' => intval($medialink_music['rssmax']),
								'filesize_show' => $medialink_music['filesize_show'],
								'stamptime_show' => $medialink_music['stamptime_show'],
								'archiveslinks_show' => $medialink_music['archiveslinks_show'],
								'pagelinks_show' => $medialink_music['pagelinks_show'],
								'sortlinks_show' => $medialink_music['sortlinks_show'],
								'searchbox_show' => $medialink_music['searchbox_show'],
								'rssicon_show' => $medialink_music['rssicon_show'],
								'credit_show' => $medialink_music['credit_show']
							);
				update_option( 'medialink_music', $music_tbl );
			}
		}

		if ( !get_option('medialink_document') ) {
			$document_tbl = array(
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
			update_option( 'medialink_document', $document_tbl );
		}

		if ( !get_option('medialink_css') ) {
			$css_tbl = array(
							'listthumbsize' => '40x40',
							'linkstrcolor' => '#ffffff',
							'linkbackcolor' => '#f6efe2'
							);
			update_option( 'medialink_css', $css_tbl );
		}

		$loading_image = MEDIALINK_PLUGIN_URL.'/img/ajax-loader.gif';
		if ( !get_option('medialink_infinite') ) {
			$infinite_tbl = array(
								'apply' => FALSE,
								'loading_image' => $loading_image
								);
			update_option( 'medialink_infinite', $infinite_tbl );
		}

		if ( !get_option('medialink_masonry') ) {
			$masonry_tbl = array(
								'apply' => FALSE,
								'width' => 100
								);
			update_option( 'medialink_masonry', $masonry_tbl );
		}

	}

	/* ==================================================
	 * Add FeedLink
	 * @since	1.16
	 */
	function add_feedlink(){

		$medialink_all = get_option('medialink_all');
		$medialink_album = get_option('medialink_album');
		$medialink_movie = get_option('medialink_movie');
		$medialink_music = get_option('medialink_music');
		$medialink_document = get_option('medialink_document');

		$wp_uploads = wp_upload_dir();

		$xml_all = '/'.$medialink_all['rssname'].'.xml';
		$xml_album = '/'.$medialink_album['rssname'].'.xml';
		$xml_movie = '/'.$medialink_movie['rssname'].'.xml';
		$xml_music = '/'.$medialink_music['rssname'].'.xml';
		$xml_document = '/'.$medialink_document['rssname'].'.xml';

		echo '<!-- Start Medialink feed -->'."\n";
		if (file_exists($wp_uploads['basedir'].$xml_all)) {
			$xml_all_data = simplexml_load_file($wp_uploads['basedir'].$xml_all);
			echo '<link rel="alternate" type="application/rss+xml" href="'.$wp_uploads['baseurl'].$xml_all.'" title="'.$xml_all_data->channel->title.'" />'."\n";
		}
		if (file_exists($wp_uploads['basedir'].$xml_album)) {
			$xml_album_data = simplexml_load_file($wp_uploads['basedir'].$xml_album);
			echo '<link rel="alternate" type="application/rss+xml" href="'.$wp_uploads['baseurl'].$xml_album.'" title="'.$xml_album_data->channel->title.'" />'."\n";
		}
		if (file_exists($wp_uploads['basedir'].$xml_movie)) {
			$xml_movie_data = simplexml_load_file($wp_uploads['basedir'].$xml_movie);
			echo '<link rel="alternate" type="application/rss+xml" href="'.$wp_uploads['baseurl'].$xml_movie.'" title="'.$xml_movie_data->channel->title.'" />'."\n";
		}
		if (file_exists($wp_uploads['basedir'].$xml_music)) {
			$xml_music_data = simplexml_load_file($wp_uploads['basedir'].$xml_music);
			echo '<link rel="alternate" type="application/rss+xml" href="'.$wp_uploads['baseurl'].$xml_music.'" title="'.$xml_music_data->channel->title.'" />'."\n";
		}
		if (file_exists($wp_uploads['basedir'].$xml_document)) {
			$xml_document_data = simplexml_load_file($wp_uploads['basedir'].$xml_document);
			echo '<link rel="alternate" type="application/rss+xml" href="'.$wp_uploads['baseurl'].$xml_document.'" title="'.$xml_document_data->channel->title.'" />'."\n";
		}
		echo '<!-- End Medialink feed -->'."\n";

	}

	/* ==================================================
	 * Load Dashicons
	 * @since	7.3
	 */
	function load_styles() {
		wp_enqueue_style('dashicons');
	}

	/* ==================================================
	 * Delete wp_options table of old version.
	 * @since	4.4
	 */
	function delete_old_versions_wp_options(){

		$delete_old_options = FALSE;

		if ( get_option('medialink_exclude') || get_option('medialink_useragent') ) {
			$delete_old_options = TRUE;
			$option_names = array(
								'medialink_exclude',
								'medialink_useragent'
						);
		}

		if ( $delete_old_options ) {
			// For Single site
			if ( !is_multisite() ) {
				foreach( $option_names as $option_name ) {
				    delete_option( $option_name );
				}
			} else {
			// For Multisite
			    // For regular options.
			    global $wpdb;
			    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			    $original_blog_id = get_current_blog_id();
			    foreach ( $blog_ids as $blog_id ) {
			        switch_to_blog( $blog_id );
					foreach( $option_names as $option_name ) {
					    delete_option( $option_name );
					}
			    }
			    switch_to_blog( $original_blog_id );

			    // For site options.
				foreach( $option_names as $option_name ) {
				    delete_site_option( $option_name );  
				}
			}
		}

	}

}

?>