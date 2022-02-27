(function($) {
    const clickFnOfTagHide = function (){
        const $hideInline = $(".hide-toggle .hide-button");
        if ($hideInline.length){
            for (let i = 0; i < $hideInline.length; i++) {
                let $item = $($hideInline[i]);
                $item.on("click", function (e){
                    $item.toggleClass("open");
                });
            }
        }
    }

    const clickFnOfTabs = function (){
        const $tabButton = $('.tabs .nav-tabs .tab > button');
        for (let i = 0; i < $tabButton.length; i++){
            let $item = $($tabButton[i]);
            $item.on("click", function (e){
                let $liItem = $item.parent();
                let isActive = $liItem.hasClass('active');
                if (!isActive){
                    $liItem.siblings().each(function (){
                        $(this).removeClass('active');
                    });

                    $liItem.addClass('active');

                    // active content
                    let contentId = $item.attr('data-href');
                    let $contentItem = $(`.tabs ${contentId}`);
                    $contentItem.siblings().each(function (){
                        $(this).removeClass('active');
                    });
                    $contentItem.addClass('active');
                }
            });
        }
    }

    // handle for ready call
    $(function() {
        clickFnOfTagHide();
        clickFnOfTabs();
    });

    $(document).on('pjax:complete', function () {
        clickFnOfTagHide();
        clickFnOfTabs();
    })
})(jQuery);