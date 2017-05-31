<table>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="date">Date</label>
        </th>
        <td>
            <input type="text" id="date" name="date" value="<?php echo @get_post_meta($post->ID, 'date', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="venue">Venue</label>
        </th>
        <td>
            <input type="text" id="venue" name="venue" value="<?php echo @get_post_meta($post->ID, 'venue', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="ticket_url">Ticket cost</label>
        </th>
        <td>
            <input type="text" id="ticket_cost" name="ticket_cost" value="<?php echo @get_post_meta($post->ID, 'ticket_cost', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="ticket_url">Box office URL</label>
        </th>
        <td>
            <input type="text" id="box_office" name="box_office" value="<?php echo @get_post_meta($post->ID, 'box_office', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="ticket_url">Gallery</label>
        </th>
        <td>
            <input type="text" id="gallery" name="gallery" value="<?php echo @get_post_meta($post->ID, 'gallery', true); ?>" />
        </td>
    </tr>
</table>
