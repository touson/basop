<?php
/**
 * Template Name: Home page
 *
 * @package WordPress
 * @subpackage UFHS
 * @since UFHS 1.0
 */
?>
<?php get_header();?>

    <div class="page-header">
        <img src="<?php echo get_template_directory_uri();?>/img/banners/sweet-charity.jpg" alt="Sweet Charity" class="header-image">
        <div class="container">
            <div class="intro-block">
                <h1>Entertaining Crowds For Over 100 Years</h1>
                <p>enean venenatis lacus a nisi fringilla mattis vel quis orci. Proin blandit ex vel ex pretium, congue efficitur augue finibus. Quisque at quam vitae leo fermentum finibus vitae pretium enim. Morbi dui nibh, malesuada a euismod eget, ullamcorper sed tellus. Phasellus vel quam dictum, mattis magna</p>
            </div>
        </div>
    </div>

    <div class="container">
        <ul id="hp-panels">
            <li>
                <div class="image-crop">
                    <img src="<?php echo get_template_directory_uri();?>/img/configurable/latest-event.jpg" alt="">
                </div>
                <div class="colour-panel red">
                    <h2>Latest show</h2>
                    <p>blandit in tempus non, elementum ut neque. Proin non molestie nulla. Sed porta placerat odio, sed facilisis quam molestie et. Maecenas</p>
                    <a href="#" class="cta">more info</a>
                </div>
            </li>
            <li>
                <div class="image-crop">
                    <img src="<?php echo get_template_directory_uri();?>/img/configurable/join-us.jpg" alt="">
                </div>
                <div class="colour-panel blue">
                    <h2>Join us</h2>
                    <p>blandit in tempus non, elementum ut neque. Proin non molestie nulla. Sed porta placerat odio, sed facilisis quam molestie et. Maecenas</p>
                    <a href="#" class="cta">more info</a>
                </div>
            </li>
            <li>
                <div class="image-crop">
                    <img src="<?php echo get_template_directory_uri();?>/img/configurable/rehearsals.jpg" alt="">
                </div>
                <div class="colour-panel orange">
                    <h2>Rehearsals</h2>
                    <p>blandit in tempus non, elementum ut neque. Proin non molestie nulla. Sed porta placerat odio, sed facilisis quam molestie et. Maecenas</p>
                    <a href="#" class="cta">more info</a>
                </div>
            </li>
            <li>
                <div class="image-crop">
                    <img src="<?php echo get_template_directory_uri();?>/img/configurable/events.jpg" alt="">
                </div>
                <div class="colour-panel green">
                    <h2>Social events</h2>
                    <p>blandit in tempus non, elementum ut neque. Proin non molestie nulla. Sed porta placerat odio, sed facilisis quam molestie et. Maecenas</p>
                    <a href="#" class="cta">more info</a>
                </div>
            </li>
        </ul>
    </div>

<?php get_footer();?>
