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
            <label for="director">Director</label>
        </th>
        <td>
            <input type="text" id="director" name="director" value="<?php echo @get_post_meta($post->ID, 'director', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="ticket_url">Ticket sales URL</label>
        </th>
        <td>
            <input type="text" id="ticket_url" name="ticket_url" value="<?php echo @get_post_meta($post->ID, 'ticket_url', true); ?>" />
        </td>
    </tr>
</table>
