=== MediaLink ===
Contributors: Katsushi Kawamori
Donate link: https://pledgie.com/campaigns/28307
Tags: audio,feed,feeds,gallery,html5,image,images,list,music,photo,photos,picture,pictures,rss,shortcode,video,xml
Requires at least: 3.0.1
Tested up to: 4.7
Stable tag: 7.46
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

MediaLink outputs as a gallery from the media library(image and music and video and document).

== Description ==

Create a playlist (image, music, video, document) of data in the media library below the specified, MediaLink displays Pages by passing the data to various software.

In the media uploader, you may not be able to upload by the environment of server. That's when the files are large. If you want to upload to the media library without having to worry about the file size, please use the [Media from FTP](https://wordpress.org/plugins/media-from-ftp/).

You write and use short codes to page.

Bundled software and function

*   HTML5 player (video, music)
*   Create RSS feeds of data (XML). It support to the podcast.
*   Works with [Masonry](http://masonry.desandro.com/).
*   Works with [Infinite Scroll](http://www.infinite-scroll.com/).

== Installation ==

1. Upload `medialink` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add a new Page
4. Write a short code. The following text field. `[medialink]`
5. For pictures `[medialink]`. For video `[medialink set='movie']`. For music `[medialink set='music']`. For document `[medialink set='document']`.
6. Please read. (Settings > MediaLink)

    [Settings](https://wordpress.org/plugins/medialink/other_notes/)

7. Navigate to the appearance section and select widgets, select wordpress MediaLinkRssFeed and configure from here.

== Frequently Asked Questions ==

none

== Screenshots ==

1. Settings 1
2. Settings 2

== Changelog ==

= 7.46 =
Fixed problem of uninstall.

= 7.45 =
Closed plugin

= 7.44 =
Deleted slideshow mode.

= 7.43 =
Fixed problem of Javascript.

= 7.42 =
Fixed problem of masonry.

= 7.41 =
Fixed problem of database read.
Fixed problem of character code.
Fixed problem of settings screen.
Fixed problem of css.

= 7.40 =
Abolition of suffix_2.

= 7.39 =
Fixed problem of database read.
Fixed problem of exclude file.

= 7.38 =
Fixed problem of settings screen.
Fixed problem of enter key.
Add progress display.

= 7.37 =
Fixed problem of settings screen.

= 7.36 =
Supported Infinite Scroll.
Supported Masonry.
Change the position of the navigation.
Fixed problem of uninstall.

= 7.35 =
Supported GlotPress.
/languages directory is deleted.

= 7.34 =
Run even without Multibyte String Functions.

= 7.33 =
Fixed problem of search for mime type.

= 7.32 =
Fixed problem of simplexml_load_file parser error.

= 7.31 =
Javascript and CSS will be loaded only to the required page.

= 7.3 =
Change feed icon.

== Upgrade Notice ==

= 7.46 =
= 7.45 =
= 7.44 =
= 7.43 =
= 7.42 =
= 7.41 =
= 7.40 =
= 7.39 =
= 7.38 =
= 7.37 =
= 7.36 =
= 7.35 =
= 7.34 =
= 7.33 =
= 7.32 =
= 7.31 =
= 7.3 =

== Settings ==

(In the case of image) Easy use

Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.

[medialink set='album']

When you view this Page, it is displayed in album mode. It is the result of a search for Media Library. The Settings> Media, determine the size of the thumbnail. Please set its value. In the Media> Add New, please drag and drop the image. You view the Page again. Should see the image to the Page.

MediaLink is also handles video and music and document. If you are dealing with music and video and document, please add the following attributes to the short code.

Video set='movie'

Music set='music'

Document set='document'

If you want to display in a mix of data, please specify the following attributes to the short code.

Mix of data set = 'all'

* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.

* When you move to (WordPress > Appearance> Widgets), there is a widget MediaLinkRssFeed. If you place you can set this to display the sidebar link the RSS feed.

