$(window).on('hashchange', loadHash);
$(document).ready(loadHash);

function loadHash() {
    if (false == window.isClicked) {

        var hash = window.location.hash.substr(1);

        var regex = new RegExp("^[A-Za-z-]*?\/[0-9]+$", "i");
        if (hash.length && regex.test(hash)) {
            var ajaxLoader = $('.content-show-wrap .ajax-loader');

            var parameters = hash.split("/");

            var nodeName = parameters[0];
            var nodeId = parameters[1];

            ajaxLoader.show();
            $('.forms-content').load(Routing.generate('edit_' + nodeName.replace("-", "_"), {id: nodeId}), function () {
                ajaxLoader.hide();
                selectTreeNodeByID(nodeId);
                autosize($('.edit-node > div > textarea'));
            });
        }
    }


}


/**
 * refresh tree and select node by id
 */
function selectTreeNodeByID(nodeId) {
    setTimeout(function () {
        var tree = $("#node-groups-tree").jstree(true);
        var tree_data = tree.get_json("#", {"flat":true});
        tree.deselect_all();
        // tree.close_all();

        if ($.isNumeric(nodeId)) {
            if (location.hash.indexOf('-group') > 0 || location.hash.indexOf('-collection') > 0) {
               
                for (var i=0; i<tree_data.length; i++) {

                    // if (tree_data[i].data.node == nodeId) {
                    if (tree_data[i].li_attr['data-grp'] == nodeId) {
                        //select node by node id
                        tree.select_node(tree_data[i].id);
                        break;
                    }
                }
            }
            else {
                for (var i=0; i<tree_data.length; i++) {
                    if (tree_data[i].li_attr['data-node'] == nodeId) {
                        //select node by node id
                        tree.select_node(tree_data[i].id);
                        break;
                    }
                }
            }
        }
    }, 1000);
}
