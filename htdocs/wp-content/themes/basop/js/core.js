// Breakpoint variables used throughout to determine what viewport we're on.
var bp = 'lg';

// Add js class to html if JS is enabled
(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);

$(document).ready(function(){
    $('#nav-trigger').click(function(){
        $('#main-nav').toggleClass('active');
    });
});

/**
 * Extend Number object to provide between functionality
 *
 * @param INT a
 * @param INT b
 * @returns BOOLEAN
 */
 Number.prototype.between = function(a, b) {
    var min = Math.min.apply(Math, [a, b]);
    var max = Math.max.apply(Math, [a, b]);
    return this > min && this < max;
};

/**
 * Set the global bp variable to the represent the current media query breakpoint.
 */
 var set_breakpoint = function() {

    var xsmall = 479;
    var small = 599;
    var medium = 770;
    var large = 959;
    var xlarge = 1199;

    var winWidth = $(window).width();

    if (winWidth < xsmall) {
        bp = 'mb';
    }
    else if (winWidth.between(xsmall, small + 1)) {
        bp = 'xs';
    }
    else if (winWidth.between(small, medium + 1)) {
        bp = 'sm';
    }
    else if (winWidth.between(medium, large + 1)) {
        bp = 'md';
    }
    else if (winWidth.between(large, xlarge + 1)) {
        bp = 'lg';
    }
    else {
        bp = 'xl';
    }
};

/**
 * Calculates the height of the biggest element in the group, then sets the
 * min-height property on the rest of the elements in the group so they are
 * always at the same height.
 *
 * @param jQuery Object $group
 */
 var set_max_height = function($group) {

    $group.each(function(index, elem) {

        var selectors = $(elem).data('height-determined-by').split(',');

        $.each(selectors, function(index, selector) {

            // If we're in the mobile view, honour the skip indicator "|" and
            // skip over the element
            if (bp == 'xs' || bp == 'mb') {
                if (selector.charAt(0) == '|') {
                    selector = selector.slice(1);
                    $(selector).css('min-height', 0);
                    return true;
                }
            }

            // Clean up the selector string ready for use
            selector = selector.charAt(0) == '|' ? selector.slice(1) : selector;

            // Get the height of the biggest element in the group
            var maxHeight = Math.max.apply(null, $(elem).find(selector).map(function() {

                // We have to wrap text node in span to allow height calculation
                if ($(this).children().length == 0) {
                    $(this).wrapInner('<span></span>');
                }

                totalHeight = 0;
                $(this).children().each(function() {
                    totalHeight += $(this).outerHeight(true);
                });
                return totalHeight;

            }).get());

            maxHeight = selector == '.image-container' ? maxHeight + 20 : maxHeight;

            // Set the min-height value on all elements in the group
            $(elem).find(selector).css('height', maxHeight);

        });
    });
}

$(window).load(function() {
    set_breakpoint();

    // Manage the height of any height managed panels
    if ($('[data-height-determined-by]').length > 0) {
        set_max_height($('[data-height-determined-by]'));
    }

});

$(window).resize(function() {

    set_breakpoint();

    // Manage the height of any height managed panels
    if ($('[data-height-determined-by]').length > 0) {
        set_max_height($('[data-height-determined-by]'));
    }

});
