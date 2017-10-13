$(function() {
    //fade out saved notification
    $('.notif-alert').delay(4000).fadeOut();

    $('.btn-group.component-panel-btn button').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        var showContent = ".component-content.component-" + $(this).data("ref");
        $(this).parent().parent().siblings('.component-content').addClass('hidden');
        $(this).parent().parent().siblings(showContent).removeClass('hidden');
    });
    
    $('.nav-pills li').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        var showContent = "." + $(this).data("ref");
        $(this).parent().siblings('.pre-scrollable').addClass('hidden');
        $(this).parent().siblings(showContent).removeClass('hidden');
    });
});


/*lock body scroll on scrollable divs*/
$('.pre-scrollable').on('DOMMouseScroll mousewheel', function(ev) {
    var $this = $(this),
        scrollTop = this.scrollTop,
        scrollHeight = this.scrollHeight,
        height = $this.height(),
        delta = (ev.type == 'DOMMouseScroll' ?
            ev.originalEvent.detail * -40 :
            ev.originalEvent.wheelDelta),
        up = delta > 0;

    var prevent = function() {
        ev.stopPropagation();
        ev.preventDefault();
        ev.returnValue = false;
        return false;
    }

    if (!up && -delta > scrollHeight - height - scrollTop) {
        // Scrolling down, but this will take us past the bottom.
        $this.scrollTop(scrollHeight);
        return prevent();
    } else if (up && delta > scrollTop) {
        // Scrolling up, but this will take us past the top.
        $this.scrollTop(0);
        return prevent();
    }
});