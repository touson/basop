<div id="meta_inner">
    <?php

    // Create select box of cast members
    $select = '<select class="cast-member-selector"><option>Select...</option>' . "\n";
    while ($castMembers->have_posts())
    {
        $castMembers->the_post();
        $cast = $castMembers->post;
        $select .= '<option value="' . $cast->ID . '">' . $cast->title . '</option>' . "\n";
    }
    $select .= '</select>';

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'dynamicMeta_noncename');


    //get the saved meta as an arry
    $characters = get_post_meta($post->ID, 'characters', true);

$c = 0;
/*

    if ($characters) {
        foreach($characters as $character) {
            if (isset($character['title']) || isset($character['cast_member'])) {
                printf( '<p>Character <input type="text" name="character[%1$s][title]" value="%2$s" /> -- Cast Member : <input type="text" name="character[%1$s][cast_member]" value="%3$s" /><span class="remove">%4$s</span></p>', $c, $character['title'], $character['cast_member'], 'Remove Character');
                $c++;
            }
        }
    }

    The input field for the cast nmember in the above output needs changing to be a select box containing all cast members i the system.  The same dropdown box needs to be made available and duplicated by the JS function below.
    */

    ?>
    <span id="here"></span>
    <span class="add"><?php echo 'Add Character'; ?></span>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
            var count = <?php echo $c; ?>;
            $(".add").click(function() {
                count++;

                $('#here').append('<p>Character <input type="text" name="character['+count+'][title]" value="" /> -- Cast Member : <input type="text" name="character['+count+'][cast_member]" value="" /><span class="remove">Remove Character</span></p>' );
                return false;
            });
            $(".remove").live('click', function() {
                $(this).parent().remove();
            });
        });
    </script>
</div>
