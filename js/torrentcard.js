var x = 0;
var slidedUp = 0;
var needToSlideDown = 0;

var win = $(this);

if(win.width() <= 585) {
    if(x == 0) {
            if(slidedUp == 0) {
                $('.Name').nextUntil('tr').slideUp();
                slidedUp = 1;
            }
            $(".Name").unbind('click');
            $('.Name').click(function(){
                $(this).nextUntil('tr').slideToggle();
            });
            x = 1;
            needToSlideDown = 1;
    }
}

$(window).on('resize', function(){
    if (win.width() <= 585) {
        if(x == 0) {
            if(slidedUp == 0) {
                $('.Name').nextUntil('tr').slideUp();
                slidedUp = 1;
            }
            $(".Name").unbind('click');
            $('.Name').click(function(){
                $(this).nextUntil('tr').slideToggle();
            });
            x = 1;
            needToSlideDown = 1;
        }
    } else {
        if(needToSlideDown == 1) {
            $('.Name').nextUntil('tr').slideDown();
            $('td').removeAttr('style');
        }
        $(".Name").unbind('click');
        needToSlideDown = 0;
        x = 0;
        slidedUp = 0;
    }
});