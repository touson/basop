// Add js class to html if JS is enabled
(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);

$(document).ready(function(){
    $('#nav-trigger').click(function(){
        $('#main-nav').toggleClass('active');
    });
});
