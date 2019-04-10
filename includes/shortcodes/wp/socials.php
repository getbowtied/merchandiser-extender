<?php

// [socials]

function getbowtied_shortcode_socials($atts, $content = null) {	

    wp_enqueue_style(  'merchandiser-socials-shortcode-styles' );
	
    global  $custom_facebook_link,
            $custom_twitter_link,
            $custom_pinterest_link,
            $custom_linkedin_link,
            $custom_googleplus_link,
            $custom_rss_link,
            $custom_tumblr_link,
            $custom_instagram_link,
            $custom_youtube_link,
            $custom_vimeo_link,
            $custom_behance_link,
            $custom_dribbble_link,
            $custom_flickr_link,
            $custom_git_link,
            $custom_skype_link,
            $custom_weibo_link,
            $custom_foursquare_link,
            $custom_soundcloud_link;

	extract(shortcode_atts(array(
		"align"       => 'left',
        "font_size"   => '',
        "color"       => '',
	), $atts));

    $link_font_size = "";
    $link_color     = "";
    
    if ($font_size != '')   $link_font_size .= 'font-size:' . $font_size    . 'px;';
    if ($color != '')       $link_color     .= 'color:'     . $color        . ';';

    ob_start();
    ?>

    <div class="shortcode_socials">
        <ul class="<?php echo esc_html($align); ?>" style="<?php echo esc_html($link_font_size); ?>">
            <?php if ( trim($custom_facebook_link) != "" ) { ?><li class="site-social-icons-facebook"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_facebook_link); ?>"><i class="fa fa-facebook"></i><span>Facebook</span></a></li><?php } ?>
            <?php if ( trim($custom_twitter_link) != "" ) { ?><li class="site-social-icons-twitter"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_twitter_link); ?>"><i class="fa fa-twitter"></i><span>Twitter</span></a></li><?php } ?>
            <?php if ( trim($custom_pinterest_link) != "" ) { ?><li class="site-social-icons-pinterest"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_pinterest_link); ?>"><i class="fa fa-pinterest"></i><span>Pinterest</span></a></li><?php } ?>
            <?php if ( trim($custom_linkedin_link) != "" ) { ?><li class="site-social-icons-linkedin"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_linkedin_link); ?>"><i class="fa fa-linkedin"></i><span>LinkedIn</span></a></li><?php } ?>
            <?php if ( trim($custom_googleplus_link) != "" ) { ?><li class="site-social-icons-googleplus"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_googleplus_link); ?>"><i class="fa fa-google-plus"></i><span>Google+</span></a></li><?php } ?>
            <?php if ( trim($custom_rss_link) != "" ) { ?><li class="site-social-icons-rss"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_rss_link); ?>"><i class="fa fa-rss"></i><span>RSS</span></a></li><?php } ?>
            <?php if ( trim($custom_tumblr_link) != "" ) { ?><li class="site-social-icons-tumblr"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_tumblr_link); ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li><?php } ?>
            <?php if ( trim($custom_instagram_link) != "" ) { ?><li class="site-social-icons-instagram"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_instagram_link); ?>"><i class="fa fa-instagram"></i><span>Instagram</span></a></li><?php } ?>
            <?php if ( trim($custom_youtube_link) != "" ) { ?><li class="site-social-icons-youtube"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_youtube_link); ?>"><i class="fa fa-youtube-play"></i><span>Youtube</span></a></li><?php } ?>
            <?php if ( trim($custom_vimeo_link) != "" ) { ?><li class="site-social-icons-vimeo"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_vimeo_link); ?>"><i class="fa fa-vimeo-square"></i><span>Vimeo</span></a></li><?php } ?>            
            <?php if ( trim($custom_behance_link) != "" ) { ?><li class="site-social-icons-behance"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_behance_link); ?>"><i class="fa fa-behance"></i><span>Behance</span></a></li><?php } ?>
            <?php if ( trim($custom_dribbble_link) != "" ) { ?><li class="site-social-icons-dribbble"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_dribbble_link); ?>"><i class="fa fa-dribbble"></i><span>Dribbble</span></a></li><?php } ?>
            <?php if ( trim($custom_flickr_link) != "" ) { ?><li class="site-social-icons-flickr"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_flickr_link); ?>"><i class="fa fa-flickr"></i><span>Flickr</span></a></li><?php } ?>
            <?php if ( trim($custom_git_link) != "" ) { ?><li class="site-social-icons-git"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_git_link); ?>"><i class="fa fa-git"></i><span>Git</span></a></li><?php } ?>
            <?php if ( trim($custom_skype_link) != "" ) { ?><li class="site-social-icons-skype"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_skype_link); ?>"><i class="fa fa-skype"></i><span>Skype</span></a></li><?php } ?>
            <?php if ( trim($custom_weibo_link) != "" ) { ?><li class="site-social-icons-weibo"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_weibo_link); ?>"><i class="fa fa-weibo"></i><span>Weibo</span></a></li><?php } ?>
            <?php if ( trim($custom_foursquare_link) != "" ) { ?><li class="site-social-icons-foursquare"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_foursquare_link); ?>"><i class="fa fa-foursquare"></i><span>Foursquare</span></a></li><?php } ?>
            <?php if ( trim($custom_soundcloud_link) != "" ) { ?><li class="site-social-icons-soundcloud"><a style="<?php echo esc_html($link_color); ?>" target="_blank" href="<?php echo esc_url($custom_soundcloud_link); ?>"><i class="fa fa-soundcloud"></i><span>Soundcloud</span></a></li><?php } ?>
        </ul>
    </div>
    
    <?php
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("socials", "getbowtied_shortcode_socials");