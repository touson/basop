<div id="meta_inner">
    <?php

    // Create a select box full of cast member info
    $blankSelect = $this->create_cast_dropdown();

    // Use nonce for verification
    wp_nonce_field('save_person', 'dynamicMeta_noncename');

    //get the saved meta as an arry
    $characters = get_post_meta($post->ID, 'secondary_characters', true);

    $c = 0;

    if ($characters) {
        $characters = unserialize($characters);
        foreach($characters as $character) {
            $castSelect = $this->create_cast_dropdown('secondary_characters[' . $c . '][cast_member]', $character['cast_member']);
            printf( '<div class="character-selector"><span>Character <input type="text" name="secondary_characters[%1$s][title]" value="%2$s" /></span><span>Cast Member : %3$s</span><span class="remove button">%4$s</span></div>', $c, $character['title'], $castSelect, 'Remove');
            $c++;
        }
    }

    ?>
    <span id="secondary-here"></span>
    <span class="s-add button">Add Character</span>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {

            var $dropdown = $('<?php echo $blankSelect;?>');
            var secondary_count = <?php echo $c; ?>;
            $(".s-add").click(function() {
                $newSelect = $dropdown.clone();
                $selectSpan = $('<span>Cast Member : </span>');
                $selectSpan.append($newSelect);
                $newSelect.attr('name', 'secondary_characters[' + secondary_count + '][cast_member]');
                $characterSelector = $('<div class="character-selector"></div>');
                $characterSelector.append('<span>Character <input type="text" name="secondary_characters[' + secondary_count + '][title]" value="" /></span>');
                $characterSelector.append($selectSpan);
                $characterSelector.append('<span class="remove button">Remove</span>');

                $('#secondary-here').append($characterSelector);
                secondary_count++;
                return false;
            });
            $(".remove").live('click', function() {
                $(this).parent().remove();
            });
        });
    </script>
</div>
