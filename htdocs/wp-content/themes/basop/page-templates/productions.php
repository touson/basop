<?php
/**
 * Template Name: Productions
 */
get_header();


if (have_posts()) {
    while (have_posts()) {
        the_post();

        // Output page header
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
        ?>
        <div class="page-header" style="background-image:url(<?php echo $image[0];?>"></div>

            <div class="container">

                <h1><?php echo the_title();?></h1>
                <?php the_content();?>

                <?php
                $productions = new Productions();

                if($productions) {
                    ?>
                    <ul class="production-archive">
                        <?php
                        foreach($productions->get_production_archive() as $prod) {
                            ?>
                            <li>
                                <div class="image-container">
                                    <a href="/productions/<?php echo $prod['slug'];?>" class="full-details">
                                        <img src="<?php echo $prod['imgSrc'];?>" />
                                    </a>
                                </div>
                                <div class="copy-container">
                                    <h3><?php echo $prod['title'];?></h3>
                                    <p><?php echo $prod['short_description'];?></p>
                                    <div class="production-details">
                                        <p><strong>Venue:</strong><?php echo $prod['venue'];?></p>
                                        <p><strong>Date:</strong><?php echo $prod['date'];?></p>
                                        <a href="/productions/<?php echo $prod['slug'];?>" class="full-details">full details</a>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                }
            }
        }
        ?>

    </div>

    <?php
    get_footer();?>
