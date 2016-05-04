<?php
/**
 * Template Name: Home page
 *
 * @package WordPress
 * @subpackage UFHS
 * @since UFHS 1.0
 */
get_header();

// Create WP_Query object for each block
$blocks = array(
    'latest event'=>'red',
    'join us'=>'blue',
    'rehearsals'=>'orange',
    'events'=>'green'
    );

foreach($blocks as $blockName=>$colour)
{
    $varNameArray = explode(' ', $blockName);
    $varNameArray[1] = isset($varNameArray[1]) ? ucwords($varNameArray[1]) : '' ;
    $varName = implode('', $varNameArray);

    $$varName = new WP_Query(['post_type'=>'homepage_block', 'name'=>$blockName]);
    $$varName = $$varName ? reset($$varName->posts) : FALSE;
}

while(have_posts())
{
    the_post();
    ?>

    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full'); ?>
    <div class="page-header" style="background-image:url(<?php echo $image[0];?>)">
        <div class="container">
            <div class="intro-block">
                <h1><?php echo get_post_meta($post->ID, 'Title', true)?></h1>
                <?php the_content();?>
            </div>
        </div>
    </div>

    <div class="container">
        <ul id="hp-panels">

            <?php
            foreach($blocks as $blockName=>$colour)
            {
                $varNameArray = explode(' ', $blockName);
                $varNameArray[1] = isset($varNameArray[1]) ? ucwords($varNameArray[1]) : '' ;
                $varName = implode('', $varNameArray);

                if($$varName)
                {
                    ?>
                    <li>
                        <div class="image-crop">
                            <?php echo get_the_post_thumbnail($$varName->ID, array(400, 400));?>
                            <!-- <img src="<?php echo get_template_directory_uri();?>/img/configurable/latest-event.jpg" alt=""> -->
                        </div>
                        <div class="colour-panel <?php echo $colour;?>">
                            <h2><?php echo $$varName->post_title;?></h2>
                            <p><?php echo $$varName->post_content;?></p>
                            <a href="<?php echo get_site_url() . '/' . get_post_meta($$varName->ID, 'page', true);?>" class="cta">more info</a>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php
}
get_footer();?>
