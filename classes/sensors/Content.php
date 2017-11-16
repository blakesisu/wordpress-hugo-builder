<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Wordpress Content.
 *
 * 2000 User created a new blog post and saved it as draft
 * 2001 User published a blog post
 * 2002 User modified a published blog post
 * 2003 User modified a draft blog post
 * 2008 User permanently deleted a blog post from the trash
 * 2012 User moved a blog post to the trash
 * 2014 User restored a blog post from trash
 * 2016 User changed blog post category
 * 2017 User changed blog post URL
 * 2019 User changed blog post author
 * 2021 User changed blog post status
 * 2023 User created new category
 * 2024 User deleted category
 * 2025 User changed the visibility of a blog post
 * 2027 User changed the date of a blog post
 * 2049 User set a post as sticky
 * 2050 User removed post from sticky
 * 2052 User changed generic tables
 * 2065 User modified content for a published post
 * 2068 User modified content for a draft post
 * 2072 User modified content of a post
 * 2073 User submitted a post for review
 * 2074 User scheduled a post
 * 2086 User changed title of a post
 * 2100 User opened a post in the editor
 * 2101 User viewed a post
 * 2111 User disabled Comments/Trackbacks and Pingbacks on a published post
 * 2112 User enabled Comments/Trackbacks and Pingbacks on a published post
 * 2113 User disabled Comments/Trackbacks and Pingbacks on a draft post
 * 2114 User enabled Comments/Trackbacks and Pingbacks on a draft post
 * 2004 User created a new WordPress page and saved it as draft
 * 2005 User published a WordPress page
 * 2006 User modified a published WordPress page
 * 2007 User modified a draft WordPress page
 * 2009 User permanently deleted a page from the trash
 * 2013 User moved WordPress page to the trash
 * 2015 User restored a WordPress page from trash
 * 2018 User changed page URL
 * 2020 User changed page author
 * 2022 User changed page status
 * 2026 User changed the visibility of a page post
 * 2028 User changed the date of a page post
 * 2047 User changed the parent of a page
 * 2048 User changed the template of a page
 * 2066 User modified content for a published page
 * 2069 User modified content for a draft page
 * 2075 User scheduled a page
 * 2087 User changed title of a page
 * 2102 User opened a page in the editor
 * 2103 User viewed a page
 * 2115 User disabled Comments/Trackbacks and Pingbacks on a published page
 * 2116 User enabled Comments/Trackbacks and Pingbacks on a published page
 * 2117 User disabled Comments/Trackbacks and Pingbacks on a draft page
 * 2118 User enabled Comments/Trackbacks and Pingbacks on a draft page
 * 2029 User created a new post with custom post type and saved it as draft
 * 2030 User published a post with custom post type
 * 2031 User modified a post with custom post type
 * 2032 User modified a draft post with custom post type
 * 2033 User permanently deleted post with custom post type
 * 2034 User moved post with custom post type to trash
 * 2035 User restored post with custom post type from trash
 * 2036 User changed the category of a post with custom post type
 * 2037 User changed the URL of a post with custom post type
 * 2038 User changed the author or post with custom post type
 * 2039 User changed the status of post with custom post type
 * 2040 User changed the visibility of a post with custom post type
 * 2041 User changed the date of post with custom post type
 * 2067 User modified content for a published custom post type
 * 2070 User modified content for a draft custom post type
 * 2076 User scheduled a custom post type
 * 2088 User changed title of a custom post type
 * 2104 User opened a custom post type in the editor
 * 2105 User viewed a custom post type
 * 2119 User added blog post tag
 * 2120 User removed blog post tag
 * 2121 User created new tag
 * 2122 User deleted tag
 * 2123 User renamed tag
 * 2124 User changed tag slug
 * 2125 User changed tag description
 */
class WPHB_Sensors_Content extends WPHB_AbstractSensor {
  /**
   * @var WordPress_Hugo_Builder
   */
  public $app;
  // protected $app;

  public function __construct(WordPress_Hugo_Builder $app) {
    $this->app = $app;
  }

  /**
   * Listening to events using WP hooks.
   */
  public function HookEvents() {
    $this->addHooks(
      array (
        'edit_category',
        'create_category',
        'create_post_tag',
        'wp_head',

        /* page actions */
        'publish_page', // when page is published

        /* post actions */
        // 'transition_post_status', // occurs in page and post
        // 'save_post', // occurs in page and post
        'publish_future_post',
        // 'post_updated_messages', // occurs in page and post
        'delete_post',
        'wp_trash_post',
        'wp_insert_post',
        'untrash_post'
      )
    );
  }

}
