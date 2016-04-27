<table>
    <tr valign="top">
        <td>
            <ul id="cast-members-selector">
                <?php
                while($castMembers->have_posts())
                {
                    $castMembers->the_post();
                    ?>
                    <li>
                        <?php echo get_the_post_thumbnail($post, array(50, 50));?>
                        <span><?php echo the_title();?></span>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </td>
    </tr>
</table>
