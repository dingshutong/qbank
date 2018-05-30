$(window).on('hashchange', loadHash);
$(document).ready(loadHash);

function loadHash() {
    if (false == window.isClicked) {
        var hash = window.location.hash.substr(1);

        var regex = new RegExp("^[A-Za-z-]*?\/[0-9]+$", "i");
        var regexWithParam = new RegExp("^[A-Za-z-]*?\/[0-9]+\/[0-9]+$", "i");
        if (hash.length && (regex.test(hash) || regexWithParam.test(hash))) {
            var ajaxLoader = $('.content-show-wrap .ajax-loader');

            var parameters = hash.split("/");

            var nodeName = parameters[0];
            var nodeId = parameters[1];
            var additionalParam = null;
            if (undefined != parameters[2]) {
                additionalParam = parameters[2];
            }

            var loadUrl = Routing.generate(nodeName.replace("-", "_") + '_data', {id: nodeId});
            if(additionalParam) {
                loadUrl += '/' + additionalParam;
            }

            ajaxLoader.show();
            $('.content-show').load(loadUrl, function () {
                ajaxLoader.hide();
            });
        }
    }
}
