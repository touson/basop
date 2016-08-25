<div id="meta_inner">
    <?php

    // Create a select box full of cast member info
    $blankSelect = $this->create_cast_dropdown();

    // Use nonce for verification
    wp_nonce_field('save_character', 'dynamicMeta_noncename');

    //get the saved meta as an arry
    $characters = get_post_meta($post->ID, 'characters', true);

    $c = 0;

    if ($characters) {
        $characters = unserialize($characters);
        foreach($characters as $character) {
            $castSelect = $this->create_cast_dropdown('characters[' . $c . '][cast_member]', $character['cast_member']);
            printf( '<div class="character-selector"><span>Character <input type="text" name="characters[%1$s][title]" value="%2$s" /></span><span>Cast Member : %3$s</span><span class="remove button">%4$s</span></div>', $c, $character['title'], $castSelect, 'Remove Character');
            $c++;
        }
    }

    ?>
    <span id="here"></span>
    <span class="add button"><?php echo 'Add Character'; ?></span>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {

            var $dropdown = $('<?php echo $blankSelect;?>');
            var count = <?php echo $c; ?>;
            $(".add").click(function() {
                $newSelect = $dropdown.clone();
                $selectSpan = $('<span>Cast Member : </span>');
                $selectSpan.append($newSelect);
                $newSelect.attr('name', 'characters['+count+'][cast_member]');
                $characterSelector = $('<div class="character-selector"></div>');
                $characterSelector.append('<span>Character <input type="text" name="characters['+count+'][title]" value="" /></span>');
                $characterSelector.append($selectSpan);
                $characterSelector.append('<span class="remove button">Remove Character</span>');

                $('#here').append($characterSelector);
                count++;
                return false;
            });
            $(".remove").live('click', function() {
                $(this).parent().remove();
            });
        });
    </script>
</div>
