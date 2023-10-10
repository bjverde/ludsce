$(function() {
    // close side menu on small devices
    $('#side-menu a[generator="adianti"]').click(function(el) {
        $('body').removeClass('sidebar-open');
        $('body').scrollTop(0);
    });
    
    $('#side-menu>li>ul>li>a[generator="adianti"]').click(function(el) {
        $('#side-menu>li>ul>li').removeClass('active');
        $(el.target).closest('li').addClass('active');
    });
    
    setTimeout( function() {
        $('#envelope_messages a').click(function() { $(this).closest('.dropdown.open').removeClass('open'); });
        $('#envelope_notifications a').click(function() { $(this).closest('.dropdown.open').removeClass('open'); });
    }, 500);
});

$( document ).on( 'click', 'ul.dropdown-menu a[generator="adianti"]', function() {
    $(this).parents(".dropdown.show").removeClass("show");
    $(this).parents(".dropdown-menu.show").removeClass("show");
});