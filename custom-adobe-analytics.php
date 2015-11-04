<?php
/*
Plugin Name:    Custom Adobe Analytics
Plugin URI:     
Description:    Adobe Analytics Integration with a hook for page level override
Version:        0.1
Author:         Rickey Messick
Author URI:     

good article i based this off of.
http://analyticsdemystified.com/general/page-section-site-naming-best-practices/

pagename - Page Name
channel - Site section
*/ 

/*
 * main tag to put after body tag.
 * includes js and sets pagename and channel
 * also any acf sets on page
 */
function adobe_analtyics_tag() {
    echo '<script type="text/javascript" src="' . plugins_url( 'js/adobe_s_code.js', __FILE__ ) . '"></script>'; 
    ?>
    <script type="text/javascript"><!--
    <?php

    // change this to prepend to all page names to differentiate website
    // this is for if we track mutliple domains to label different
    $domainprepend = 'bkd';
    $domainprepend .= ':';
    /*
     * This is a way to strip down the url and create page name
     * I did not use this way but it is another way to go about it.
     *
    $pageName = "";
    $parse_path = "";
    $pageName = bloginfo('name');
    if ( !is_home() ) {
        
        $parse_path = $_SERVER["REQUEST_URI"];
        $parse_path = substr($parse_path, 1); //remove first /
        $parse_path = strstr($parse_path, "/"); //remove everything prior to next /
        $parse_path = str_replace("/", ":", $parse_path); //substitute : for / in the remainder of the path
        $pageName .= $parse_path;
    }
    */
   
    global $post;
   
    if(is_front_page()) {    //Wordpress functionality to check if page is home page

            $pageName = $channel = 'Home Page';

    } elseif (is_home()) {

            $pageName = 'Blogs';
            $channel = 'Blogs';
            
    } elseif (is_page()) {

            $pageName = the_title('', '', false);
            $channel = 'Page';
            
    } elseif (is_single()) { //Wordpress functionality to check if page is article

            $pageName = the_title('', '', false);
            $channel = get_post_type( $post->ID );

            /*
             * communities cpt specific vars to fire
             */
            if (get_post_type( $post->ID ) == "xxxxxxx") {
                // removed business specific code
                // left for example
            } 


    } elseif (is_category()) {    //Wordpress functionality to check if page is category page

            $pageName = $channel = single_cat_title('', false);
            $pageName = 'Category: ' . $pageName;


    } elseif (is_tag()) {     //Wordpress functionality to check if page is tag page

            $pageName = single_tag_title('', false);
            $pageName = 'Tag: ' . $pageName;
            $channel = get_post_type( $post->ID );

    }  elseif (is_tax()) {     //Wordpress functionality to check if page is tax

            $pageName = single_term_title('', false);
            $pageName = 'Tax: ' . $pageName;
            $channel = get_post_type( $post->ID );
   

    } elseif (is_month()) {     //Wordpress functionality to check if page is month page

            list($month, $year) = split(' ', the_date('F Y', '', '', false));
            $pageName = 'Month Archive: ' . $month . ' ' . $year;
            $channel = 'Month Archive';

    }

    // add prefix for sitewide.  this is for if we track mutliple domains to label different
    $pageName = $domainprepend . $pageName;
    // make all lowercase
    $pageName = strtolower($pageName);

    /*
     * pagename with override logic
     */
    if(get_field('pagenameoverride'))
    {
        echo "s.pageName = '" . $domainprepend . strtolower(get_field('pagenameoverride')) . "' //page name overridden\n";
    } else {
        echo "s.pageName = '$pageName' //page name\n";
    }

    /*
     * channel with override logic
     */
    if(get_field('channel_override'))
    {

        echo "s.channel = '" . get_field('channel_override') . "' //channel overridden\n";

    } else {

        echo "s.channel = '$channel' //channel\n";

    }
    
    /*
     * page level added fields with acf
     */
    if( have_rows('adobe_analytics_page_level_vars') ) {
        // loop rows
        while( have_rows('adobe_analytics_page_level_vars') ): the_row(); 

        // do not output if empty
        if(get_sub_field('page_var_name') & get_sub_field('page_var_value'))
        {

           echo "" . get_sub_field('page_var_name') . " = " . get_sub_field('page_var_value') . " // page level added field \n";

        }

        endwhile;
    }

    ?>
    
    -->
    </script>
    <?php 

}
// after opening body tag
// I used genesis theme so that is where I hooked it
add_action('genesis_before', 'adobe_analtyics_tag', 8);


/*
 * put s code as the very last to fire
 */
function adobe_analtyics_tag_scode() {
    ?>
    <script type="text/javascript"><!--
    var s_code=s.t();if(s_code)document.write(s_code)
    -->
    </script>
    <?php 

}
// in footer very last
add_action('wp_footer', 'adobe_analtyics_tag_scode',100);
