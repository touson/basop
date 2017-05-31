<div id="meta_inner" class="member">
    <?php

    // Create a select box full of cast member info
    $blankSelect = $this->create_cast_dropdown();

    // Use nonce for verification
    wp_nonce_field('save_person', 'dynamicMeta_noncename');

    //get the saved meta as an arry
    $members = get_post_meta($post->ID, 'members', true);

    $c = 0;

    if ($members) {
        $members = unserialize($members);
        foreach($members as $member) {
            $memberSelect = $this->create_cast_dropdown('members[' . $c . '][member]', $member['member']);
            printf( '<div class="member-selector"><span>Position <input type="text" name="members[%1$s][title]" value="%2$s" /></span><span>Member : %3$s</span><span class="remove button">%4$s</span></div>', $c, $member['title'], $memberSelect, 'Remove');
            $c++;
        }
    }

    ?>
    <span id="member-here"></span>
    <span class="add button">Add Member</span>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {

            var $memberDropdown = $('<?php echo $blankSelect;?>');
            var mCount = <?php echo $c; ?>;
            $(".member .add").click(function() {
                $newSelect = $memberDropdown.clone();
                $selectSpan = $('<span>Member : </span>');
                $selectSpan.append($newSelect);
                $newSelect.attr('name', 'members['+mCount+'][member]');
                $memberSelector = $('<div class="member-selector"></div>');
                $memberSelector.append('<span>Position <input type="text" name="members['+mCount+'][title]" value="" /></span>');
                $memberSelector.append($selectSpan);
                $memberSelector.append('<span class="remove button">Remove</span>');

                $('#member-here').append($memberSelector);
                mCount++;
                return false;
            });
            $(".remove").live('click', function() {
                $(this).parent().remove();
            });
        });
    </script>
</div>
