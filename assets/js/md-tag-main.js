(function($) {
    // handle for ready call
    $(function() {
        const clickFnOfTagHide = function (){
            const $hideInline = $(".entry-content .hide-button");
            if ($hideInline.length){
                for (let i = 0; i < $hideInline.length; i++) {
                    let $item = $($hideInline[i]);
                    $item.on("click", function (e){
                        $item.toggleClass("open");
                    });
                }
            }
        }

        clickFnOfTagHide();
    });
})(jQuery);