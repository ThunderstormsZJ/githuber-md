(function($) {
    window.Prism = window.Prism || {};
    window.Prism.manual = true;

    const clickExpand = function (){
        let $expand = $(".highlight-tools .code-notice .expand");

        $expand.on("click", function (e){
            let $codeContent = $(this).parent().parent().siblings("pre");
            let isClosed = $(this).hasClass("closed");
            if (isClosed){
                $(this).removeClass('closed');
                $codeContent.css('display', 'block');
            }else{
                $(this).addClass('closed');
                $codeContent.css('display', 'none');
            }
        });
    }

    const highlight = function (){
        window.Prism.highlightAll();
    }

    $(function() {
        // handle for ready call
        clickExpand();
        highlight();
    })

    $(document).on('pjax:complete', function () {
        clickExpand();
        highlight();
    })

})(jQuery);