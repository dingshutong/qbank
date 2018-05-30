// repeating fields
var $collectionHolder;
window.isClicked = false;

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link btn btn-info">Add element</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    var labelText = $('ul.repeating').data('label');
    $newLinkLi.find('a').text('Add ' + labelText);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var elementLabel = $('ul.repeating').data('label');
    var $removeFormA = $('<a class="delete_tag_link btn btn-danger" href="#">Remove</a>');
    $tagFormLi.find('.delete_tag_link').remove();
    $tagFormLi.append($removeFormA);
    $('ul.repeating').children('li:last').children('.delete_tag_link').remove();

    $removeFormA.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
        $('form .saved').hide();
        $('form .unsaved').show();
    });
}

function initializeAddRepeating() {
    // repeating fields
    $collectionHolder = $('ul.repeating');
    var labelText = $('ul.repeating').data('label');
    $newLinkLi.find('a').text('Add ' + labelText);
    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.off('click').on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        var labelText = $('ul.repeating').data('label');
        $newLinkLi.find('a').text('Add ' + labelText);

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
}

function initializeRemoveRepeating() {
    // repeating fields
    $collectionHolder = $('ul.repeating');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function () {
        addTagFormDeleteLink($(this));
    });
}


// node type, eg. indicator, classification, ...
if (document.getElementById('node-type')) {
    var nodeType = document.getElementById('node-type').innerHTML;
}

// tree copy global variable
var treeCopy;

var checkedRelatedQuestionnaires = [];

// language global variable
var locale = $('input#locale').val()

jQuery(document).ready(function ($) {
        
    //edit resource form - remove file
    $('.edit-resource-form .btn-remove').on('click', function (e) {
            $(this).closest(".remove-file").remove();
    });
    
    
    //move row up or down
    /*
    $('body').off('mouseenter', '.move-related-item').on('mouseenter', '.move-related-item', function (e) {
        return;var parentRow = $(this).parents('tr');
        parentRow.find('td').addClass('highlight');
        parentRow.find('input').addClass('highlight');
        parentRow.find('textarea').addClass('highlight');
    });
    $('body').off('mouseout', '.move-related-item').on('mouseout', '.move-related-item', function (e) {
        return;var parentRow = $(this).parents('tr');
        parentRow.find('td').removeClass('highlight');
        parentRow.find('input').removeClass('highlight');
        parentRow.find('textarea').removeClass('highlight');
    });
    */

    //move rows up or down using the up/down buttons
    $('body').off('click', '.move-related-item').on('click', '.move-related-item', function (e) {
        e.preventDefault();
        var direction = $(this).attr("data-direction");
        window.selected=$(this);
        $(this).closest("tr").css("background-color","#2aabd2");
        if (direction == "down") {
            $(this).closest("tr").next().after($(this).closest("tr"));            
        }
        else {
            $(this).closest("tr").prev().before($(this).closest("tr"));
        }        
        $(this).closest("tr").animate({backgroundColor: "transparent" },3000, null, 
            function() { $(this).css("background-color","");});

        $('form .saved').hide();
        $('form .unsaved').show();
    });

    
    
    
    if (!$('.front-container').length > 0) {

        if ($('.node-groups').length > 0) {
            loadNodeGroups('node-groups', false);
        }
        if ($('.nodes-repository').length > 0) {
            loadNodesRepository('nodes-repository', false);
        }
        var contentAjaxLoader = $('.forms-container').find('.ajax-loader');

        $('.switch-to-Collection').on('click', function (e) {
            e.preventDefault();
            $('.controls-tabs li').removeClass('active');
            $(this).parent('li').addClass('active');

            $('h3.assigned-to').html('Assigned to Collections?');
            $('.filter-box input[value="all"]').prop('checked', true);

            loadCollectionsGroups('node-groups', false);
            loadNodesCollectionRepository('nodes-repository');
        });
        $('.switch-to-Group').on('click', function (e) {
            e.preventDefault();
            $('.controls-tabs li').removeClass('active');
            $(this).parent('li').addClass('active');

            $('h3.assigned-to').html('Assigned to Groups?');
            $('.filter-box input[value="all"]').prop('checked', true);

            loadNodeGroups('node-groups', false);
            loadNodesRepository('nodes-repository', false);
        });

        $('.menu-filter').on('click', function (e) {
            e.preventDefault();
            var filters = $('.node-filters');
            if (filters.is(':visible')) {
                filters.hide();
            }
            else {
                filters.show();
            }
        });


        // click on root node (Groups/Collections)
        $(document).on('click', '.node-groups li#groups-root > a', function (e) {
            e.preventDefault();
            $('.forms-content').html('');
        });

        // edit group/collection form (Groups/Collections)
        // tree

        $(document).on('click', '.node-groups li.folder > a', function (e) {
            e.preventDefault();

            if (leaveUnsaved() == false) return false;

            if ($(".groups").is(":visible")) {

                editGroupForm($(this).parent('li'));
            } else if ($(".collections").is(":visible")) {

                editCollectionForm($(this).parent('li'));
            }
        });
        // click on folder icon
        $(document).on('click', '.node-groups li.folder > a > .jstree-icon', function (e) {
            e.preventDefault();
            $(this).parent().prev('.jstree-icon').click();
        });

        // breadcrumb
        $(document).on('click', '.breadcrumb-header .bc-item a', function (e) {
            e.preventDefault();
            if (leaveUnsaved() == false) return false;
            if ($("form.edit-group-group").is(":visible")) {
                editGroupForm($(this).parent('li'));
            } else if ($("form.edit-group-collection").is(":visible")) {
                editCollectionForm($(this).parent('li'));
            }
        });
        // modal breadcrumb
        $(document).on('click', '#breadcrumb-modal .bc-item > a', function (e) {
            e.preventDefault();
            var parentUl = $(this).parent().parent('ul');

            if (parentUl.hasClass('bc-groups')) {
                editGroupForm($(this).parent('li'));
            } else if (parentUl.hasClass('bc-collections')) {
                editCollectionForm($(this).parent('li'));
            }

            $('.node-groups li a').removeClass('highlight');
            $('.modal').modal('hide');
        });

        // edit node form
        $(document).on('click', '.node-groups li.file > a', function (e) {
            e.preventDefault();

            if (leaveUnsaved() == false) return false;

            editNodeForm($(this).parent('li'), 0);
        });

        // highlight groups for selected node in repository
        $(document).on('click', '.nodes-repository li.file > a', function (e) {

            if (leaveUnsaved() == false) return false;

            if ($(this).parent('li').attr('data-refgrp')) {
                var relatedGroups = $(this)
                    .parent('li')
                    .attr('data-refgrp')
                    .substring(1)
                    .split(',');
            }
            else {
                var relatedGroups = [];
            }

            editNodeForm($(this).parent('li'), relatedGroups);
        });

        // add node to groups/collections tree --------------------------
        $('.add-node-to-grp').click(function (e) {
            e.preventDefault();

            if ($('.node-groups li.folder > a.jstree-clicked').length > 0) {
                createTreeItem('file');
            }
            else {
                messageModal('Please select a Group');
            }
        });

        // add node to repository -----------------------
        $('.add-node').click(function (e) {
            e.preventDefault();
            createRepositoryItem();
        });

        // delete node from repository - trigger modal
        $('.del-node').click(function (e) {
            e.preventDefault();

            var selectedItem = $('.nodes-repository li.file > a.jstree-clicked');

            if (selectedItem.length > 0) {
                var itemLabel = selectedItem
                    .text();
                $('#del-node-modal .modal-body')
                    .html('Delete "' + itemLabel + '"?');
                $('#del-node-modal').modal();
            }
            else {
                messageModal('Please select an item to delete');
            }

        });

        // delete node from repository
        $('#del-node-modal .save-changes').click(function (e) {
            e.preventDefault();

            var selectedItem = $('.nodes-repository li.file > a.jstree-clicked');
            var nodeId = selectedItem
                .parent('li')
                .attr('data-node');

            $.ajax(Routing.generate('delete_' + nodeType, {_locale: locale, id: nodeId}))
                .done(function (data) {
                    if (data == 'ok') {
                        $('#del-node-modal').modal('hide');

                        // reload nodes repository
                        if ($(".groups").is(":visible")) {
                            loadNodesRepository('nodes-repository', false);
                        } else if ($(".collections").is(":visible")) {
                            loadNodesCollectionRepository('nodes-repository');
                        }

                        // remove deleted items from tree
                        $('#node-groups-tree li[data-node="' + nodeId + '"]').each(function () {
                            var treeItemId = $(this)
                                .attr('id');
                            $('#node-groups-tree')
                                .jstree(true)
                                .delete_node(treeItemId);
                        });

                        $('.forms-content').html('');
                    }
                });
        });

        // Clone a Classification or Questionnaire
        $('.copy-node').click(function (e) {
            e.preventDefault();

            var itemId, nodeName, route;
            if ($('[name=nodeId]').length > 0) {
                itemId = $('[name=nodeId]').val();
                nodeName = $('.node-name-field').val();
                route = 'add_' + nodeType;
            }
            else {
                itemId = $('[name=grpId]').val();
                nodeName = $('.group-name-field').val();
                route = 'add_' + nodeType + '_group';
            }

            var posting = $.get(Routing.generate(route, {_locale: locale, idForCloning:itemId}));

            posting.done(function (response) {
                messageModal('Added "' + nodeName + ' - copy"');
                loadNodesRepository('nodes-repository', false);
                loadNodeGroups('node-groups', false);
            });
        });


        // add group/collection to tree -------------------------------------
        $('.add-node-grp').click(function (e) {
            e.preventDefault();

            if ($('.node-groups li.folder > a.jstree-clicked').length > 0) {
                createTreeItem('default');
            }
            else
            {
                createTreeRootItem();
            }
            /*
            else if ($('.node-groups li#groups-root > a.jstree-clicked').length > 0) {
                createTreeRootItem();
            }
            else {
                if ($(".groups").is(":visible")) {
                    createTreeRootItem();
                    //messageModal('Please select a Group');
                } else if ($(".collections").is(":visible")) {
                    messageModal('Please select a Collection');
                }
            }*/
        });

        // delete group/collection or remove node from group/collection ----------

        function deleteNodeFromTree() {
            var ref = $('#node-groups-tree').jstree(true);
            var sel = ref.get_selected();

            if (!sel.length) {
                return false;
            }
            if ($('#' + sel).hasClass('jstree-leaf')) {
                ref.delete_node(sel);
            }
            else {
                if ($(".groups").is(":visible")) {
                    messageModal('Group contains subgroups');
                } else if ($(".collections").is(":visible")) {
                    messageModal('Collection contains subcollections');
                }
            }

        };

        $('.del-node-grp').click(function (e) {
            e.preventDefault();

            var selectedFolder = $('.node-groups li.folder > a.jstree-clicked');
            var selectedFile = $('.node-groups li.file > a.jstree-clicked');
            var itemLabel;

            var modalHeader = $('#del-group-modal .modal-header h4');
            var modalBody = $('#del-group-modal .modal-body');

            if (selectedFolder.length > 0) {
                itemLabel = selectedFolder
                    .text();
                if ($(".groups").is(":visible")) {
                    modalHeader.html('Delete a Group');
                } else if ($(".collections").is(":visible")) {
                    modalHeader.html('Delete a Collection');
                }
                modalBody.html('Delete "' + itemLabel + '"?');
                $('#del-group-modal').modal();
            }
            else if (selectedFile.length > 0) {
                itemLabel = selectedFile
                    .text();
                if ($(".groups").is(":visible")) {
                    modalHeader.html('Remove an item from Groups');
                } else if ($(".collections").is(":visible")) {
                    modalHeader.html('Remove an item from Collections');
                }
                modalBody.html('Remove "' + itemLabel + '"?');
                $('#del-group-modal').modal();
            }
            else {
                $('#messages-modal .modal-body')
                    .html('Please select an item to delete');
                $('#messages-modal').modal();
            }
        });
        $('#del-group-modal .save-changes').click(function (e) {
            e.preventDefault();
            deleteNodeFromTree();
            $('#del-group-modal').modal('hide');
        });


        // edit node ---------------------------------------
        $(document).on('submit', '.edit-node', function (e) {
            e.preventDefault();

            if (validation($(this))) {
                var nodeId = $(this).find('input[name="nodeId"]').val();

                var postVariables = $(this).serializeArray();//new FormData(this);
                
                /*
                Note: FormData is not supported before IE 10.
                
                    enable lines processData and contentType to use FormData    
                */
                
                contentAjaxLoader.show();
                var posting = $.ajax({
                    url: Routing.generate('edit_' + nodeType, {_locale: locale, id: nodeId}),
                    data: postVariables,
                    //processData: false,
                    //contentType: false,
                    type: "POST"
                });

                posting.done(function (data) {
                    if (data == 'ok') {
                        contentAjaxLoader.hide();
                        $('form .unsaved').hide();
                        $('form .saved').show();

                        // refresh name in groups tree
                        var nodeName = $('.node-name-field').val();
                        var ref = $('#node-groups-tree').jstree(true);
                        var sel = ref.get_selected();

                        ref.set_text(sel, nodeName);
                        //ref.rename_node(sel, nodeName);

                        $('.breadcrumb-header .bc-node')
                            .html(nodeName);
                        if ($(".node-published").val() == '1') {
                            $('#' + sel[0]).removeClass('unpublished');
                        }
                        else {
                            $('#' + sel[0]).addClass('unpublished');
                        }

                        // refresh nodes tree
                        if ($(".groups").is(":visible")) {
                            loadNodesRepository('nodes-repository', false);
                        } else if ($(".collections").is(":visible")) {
                            loadNodesCollectionRepository('nodes-repository');
                        }
                    }
                });
            }
        });

        // edit group or collection ----------------------------------------
        $(document).on('submit', '.edit-group', function (e) {
            e.preventDefault();

            if (validation($(this))) {
                var postVariables = $(this).serializeArray();

                contentAjaxLoader.show();
                if ($(".groups").is(":visible")) {
                    var grpId = $(this).find('input[name="grpId"]').val();
                    var posting = $.post(Routing.generate('edit_' + nodeType + '_group', {_locale: locale, id: grpId}), postVariables);

                    posting.done(function (data) {
                        if (data == 'ok') {
                            contentAjaxLoader.hide();
                            $('form .unsaved').hide();
                            $('form .saved').show();

                            var groupName = $('.group-name-field').val();
                            var ref = $('#node-groups-tree').jstree(true);
                            var sel = ref.get_selected();
                            
                            //ref.rename_node(sel, groupName);
                            ref.set_text(sel, groupName);

                            $('.groups-breadcrumb .bc-item-last')
                                .html('&raquo; ' + groupName);
                            if ($(".group-published").val() == '1') {
                                $('#' + sel[0]).removeClass('unpublished');
                            }
                            else {
                                $('#' + sel[0]).addClass('unpublished');
                            }
                        }
                    });
                } else if ($(".collections").is(":visible")) {
                    var collId = $(this).find('input[name="collId"]').val();
                    var posting = $.post(Routing.generate('edit_' + nodeType + '_collection', {_locale: locale, id: collId}), postVariables);

                    posting.done(function (data) {
                        if (data == 'ok') {
                            contentAjaxLoader.hide();
                            $('form .unsaved').hide();
                            $('form .saved').show();
                            var collectionName = $('form.edit-group input[name="indicatorsCollection[name]"]').val();
                            var ref = $('#node-groups-tree').jstree(true);
                            var sel = ref.get_selected();

                            //ref.rename_node(sel, collectionName);
                            ref.set_text(sel,collectionName);

                            $('.groups-breadcrumb .bc-item-last')
                                .html('&raquo; ' + collectionName);
                            if ($('input[name="indicatorsCollection[published]"]').val() == '1') {
                                $('#' + sel[0]).removeClass('unpublished');
                            }
                            else {
                                $('#' + sel[0]).addClass('unpublished');
                            }
                        }
                    });
                }

            }
        });


        // publish/unpublish ------------------------------------------------
        $(document).on('click', '.publish-button .btn-success', function (e) {
            e.preventDefault();

            var parentForm = $(this).parents('form');
            var id;
            var groupOrCollection = '';
            if (parentForm.hasClass('edit-node')) {
                id = parentForm.find('input[name="nodeId"]').val();
            }
            else if (parentForm.hasClass('edit-group-group')) {
                id = parentForm.find('input[name="grpId"]').val();
                groupOrCollection = '_group';
            }
            else if (parentForm.hasClass('edit-group-collection')) {
                id = parentForm.find('input[name="collId"]').val();
                groupOrCollection = '_collection';
            }
            else if (parentForm.hasClass('edit-node-form')) {
                id = parentForm.find('input[name="nodeId"]').val();
            }

            var publish = publishUnpublishNodeOrGroup(groupOrCollection, id, 0);
            publish.done(function (data) {
                $(".forms-container .ajax-loader").css("display","none");

                $(".publish-button .btn-success").toggleClass('hidden');
                $('.publish-button .btn-default').toggleClass('hidden');
            });
        });

        $(document).on('click', '.publish-button .btn-default', function (e) {
            e.preventDefault();

            var parentForm = $(this).parents('form');
            var id;
            var groupOrCollection = '';
            if (parentForm.hasClass('edit-node')) {
                id = parentForm.find('input[name="nodeId"]').val();
            }
            else if (parentForm.hasClass('edit-group-group')) {
                id = parentForm.find('input[name="grpId"]').val();
                groupOrCollection = '_group';
            }
            else if (parentForm.hasClass('edit-group-collection')) {
                id = parentForm.find('input[name="collId"]').val();
                groupOrCollection = '_collection';
            }
            else if (parentForm.hasClass('edit-node-form')) {
                id = parentForm.find('input[name="nodeId"]').val();
            }

            var publish = publishUnpublishNodeOrGroup(groupOrCollection, id, 1);
            publish.done(function (data) {
                $(".forms-container .ajax-loader").css("display","none");

                $(".publish-button .btn-success").toggleClass('hidden');
                $('.publish-button .btn-default').toggleClass('hidden');
            });
        });

        // cancel editing
        $(document).on('click', '.save-actions .cancel-editing', function (e) {
            e.preventDefault();
            var parentForm = $(this).parents('form');
            var entityId;
            if (parentForm.hasClass('edit-group-group')) {
                entityId = parentForm.find('input[name="grpId"]').val();
                $('#node-groups-tree li[data-grp="' + entityId + '"] > a').click();
            }
            else if (parentForm.hasClass('edit-group-collection')) {
                entityId = parentForm.find('input[name="collId"]').val();
                $('#node-groups-tree li[data-grp="' + entityId + '"] > a').click();
            }
            else if (parentForm.hasClass('edit-node')) {
                entityId = parentForm.find('input[name="nodeId"]').val();
                if ($('#node-groups-tree li[data-node="' + entityId + '"] a.jstree-clicked').length > 0) {
                    $('#node-groups-tree li[data-node="' + entityId + '"] > a').click();
                }
                else {
                    $('#node-repository-tree li[data-node="' + entityId + '"] > a').click();
                }
            }
        });

        // show "unsaved" message -------------------------
        $(document).on('input', '.forms-content form input, .forms-content form textarea, .forms-content form select', function () {
            $('form .saved').hide();
            $('form .unsaved').show();
        });

        $(document).on('change', '.forms-content form input', function () {
            $('form .saved').hide();
            $('form .unsaved').show();
        });


        // filter nodes -----------------------
        $('input[name="assigned"], input[name="published"]').change(function () {
            if ($(".groups").is(":visible")) {
                loadNodesRepository('nodes-repository', false);
            } else if ($(".collections").is(":visible")) {
                loadNodesCollectionRepository('nodes-repository');
            }
            $('.node-filters').fadeOut();
        });

        // expand the tree -------------------
        $('.expand-tree').click(function (e) {
            e.preventDefault();
            $('#node-groups-tree').jstree('open_all');
        });

        // collapse the tree -------------------
        $('.collapse-tree').click(function (e) {
            e.preventDefault();
            $('#node-groups-tree').jstree('close_all');
        });

        // ui layout
        if ($('.ui-layout-west').length > 0) {
            myLayout = $('body').layout({

                // reference only - these options are NOT required because 'true' is the default
                closable: true,     // pane can open & close
                resizable: true,    // when open, pane can be resized
                slidable: true,     // when closed, pane can 'slide' open over other panes - closes on mouse-out
                livePaneResizing: true,

                // resizer
                spacing_open: 10,  // ALL panes
                spacing_closed: 10,  // ALL panes

                // some pane-size settings
                west__size: 400,
                center__minWidth: 300,

                north: {
                    size: 50,
                    resizable: false
                },

                west: {
                    minSize: 360,
                    closable: false
                },

                // West Sidebar options
                west__childOptions: {
                    minSize: 50,
                    south__size: 300,
                    closable: false,
                    spacing_open: 10,
                    spacing_closed: 10,
                    center__contentSelector: 'div.data',
                    south__contentSelector: 'div.data'
                },

                // enable showOverflow on west-pane so CSS popups will overlap north pane
                west__showOverflowOnHover: true,

                // enable state management
                stateManagement__enabled: true // automatic cookie load & save enabled by default
            });
        }
        else if ($('.ui-layout-north').length > 0) {
            myLayout = $('body').layout({

                closable: true,
                spacing_open: 10,
                spacing_closed: 10,
                north: {
                    size: 50,
                    resizable: false
                },

                // enable state management
                stateManagement__enabled: true // automatic cookie load & save enabled by default
            });
        }

        // try leave without saving form
        $('ul.nav a, .qbank-link').click(function (e) {
            if (leaveUnsaved() == false) return false;
        });

        // breadcrumbs modal -------------------------
        $(document).on('click', '.breadcrumb-header .bc-categories a', function (e) {
            e.preventDefault();
            resetModalBreadcrumbs();
            var title = $('.breadcrumb-header .bc-node').html();
            var content = $('#breadcrumbs-modal-content').html();
            $('#breadcrumb-modal .modal-title').html(title);
            $('#breadcrumb-modal .modal-body').html(content);
            $('#breadcrumb-modal').modal('show');
            // confirmation popover
            $('.modal .bc-single .delete-button').popover();
        });

        // remove node from group/collection - popover action
        $(document).on('click', '.modal .bc-single .delete-button', function (e) {
            e.preventDefault();
            $('.delete-button').removeClass('active');
            $(this).addClass('active');
        });
        // confirm removing
        $(document).on('click', '.popover .yes', function (e) {
            e.preventDefault();

            var delButton = $('.bc-single .delete-button.active');
            var nodeId = delButton
                .parent('li')
                .attr('data-node');
            var grpId = delButton
                .parent('li')
                .prev('li')
                .attr('data-grp');
            var parentUl = delButton
                .parent('li')
                .parent('ul');
            var ajaxLoader = $('.modal .ajax-loader');

            ajaxLoader.show();

            if (parentUl.hasClass('bc-groups')) {
                $.ajax(Routing.generate('delete_' + nodeType + '_from_groups', {_locale: locale, grpId: grpId, nodeId: nodeId}))
                    .done(function (data) {
                        if (data == 'ok') {
                            $('#breadcrumbs-modal-wrapper').load(Routing.generate('edit_' + nodeType, {_locale: locale, id: nodeId}) + ' #breadcrumbs-modal-content', function () {
                                var newModalContent = $('#breadcrumbs-modal-content').html();
                                var catCount = $('.breadcrumb-header #categories-counter').text();
                                $('#breadcrumb-modal .modal-body').html(newModalContent);
                                $('.breadcrumb-header #categories-counter').html(parseInt(catCount) - 1);
                                $('.modal .bc-single .delete-button').popover();

                                if ($('.switch-to-Group').length > 0) {
                                    $('.switch-to-Group').click();
                                }
                                else {
                                    loadNodeGroups('node-groups', false);
                                    loadNodesRepository('nodes-repository', false);
                                }
                                ajaxLoader.hide();
                            });
                        }
                    });
            }
            else if (parentUl.hasClass('bc-collections')) {
                $.ajax(Routing.generate('delete_' + nodeType + '_from_collections', {_locale: locale, collId: grpId, nodeId: nodeId}))
                    .done(function (data) {
                        if (data == 'ok') {
                            $('#breadcrumbs-modal-wrapper').load(Routing.generate('edit_' + nodeType, {_locale: locale, id: nodeId}) + ' #breadcrumbs-modal-content', function () {
                                var newModalContent = $('#breadcrumbs-modal-content').html();
                                var catCount = $('.breadcrumb-header #categories-counter').text();
                                $('#breadcrumb-modal .modal-body').html(newModalContent);
                                $('.breadcrumb-header #categories-counter').html(parseInt(catCount) - 1);
                                $('.modal .bc-single .delete-button').popover();

                                $('.switch-to-Collection').click();
                                ajaxLoader.hide();
                            });
                        }
                    });
            }
        });
        // cancel removing
        $(document).on('click', '.popover .cancel', function (e) {
            e.preventDefault();
            $('.delete-button').popover('hide');
        });

        // edit breadcrumb ----------------------------
        $(document).on('click', '.edit-button', function (e) {
            e.preventDefault();
            var parentUl = $(this).parents('ul.bc-single');
            $(this).hide();
            parentUl.find('.delete-button').hide();
            parentUl.find('.save-changes-button').show();

            var groupsOrCollections = parentUl.hasClass('bc-groups')
                ? 'groups'
                : 'collections';

            parentUl.find('.bc-item').each(function () {
                var groupId = $(this).attr('data-grp');
                $(this).children('a').hide();

                var parentId = $(this).prev('li').hasClass('bc-item')
                    ? $(this).prev('li').attr('data-grp')
                    : 0;

                $.ajax(Routing.generate(nodeType + '_' + groupsOrCollections + '_list', {_locale: locale, pid: parentId}))
                    .done(function (data) {
                        var parentLi = parentUl.find('li[data-grp="' + groupId + '"]');
                        parentLi.append(data)
                            .find('option[value=' + groupId + ']')
                            .attr('selected', true);
                        if (parentId == 0) {
                            parentLi.find('option[value=""]').remove();
                        }
                    });
            });
        });

        $(document).on('change', '.bc-item select', function (e) {
            e.preventDefault();
            var parentUl = $(this).parents('ul.bc-single');
            var parentId = $(this).val();
            var nextLi = $(this).parent('.bc-item').next('.bc-item');

            var groupsOrCollections = parentUl.hasClass('bc-groups')
                ? 'groups'
                : 'collections';

            if (parentId != '') {
                $(this)
                    .parent('.bc-item')
                    .removeClass('empty');

                if (nextLi.hasClass('bc-item')) {
                    $.ajax(Routing.generate(nodeType + '_' + groupsOrCollections + '_list', {_locale: locale, pid: parentId}))
                        .done(function (data) {
                            nextLi.find('select').remove();
                            nextLi.append(data);
                        });
                }
            }
            else {
                $(this).parent('.bc-item').addClass('empty');
                nextLi.find('select').remove();
                nextLi.append('<select><option value="">---</option></select>');
            }
        });

        $(document).on('click', '.bc-item-last .save-changes-button', function (e) {
            e.preventDefault();
            var parentUl = $(this)
                .parent('li')
                .parent('ul.bc-single');

            $(this).hide();
            parentUl.find('.edit-button').show();
            parentUl.find('.delete-button').show();

            var nodeId = $(this)
                .parent('li')
                .attr('data-node');
            var parentGrpId = (parentUl.find('li.empty').length > 0)
                ? parentUl.find('li.empty:first')
                .prev('.bc-item')
                .children('select')
                .val()
                : parentUl.find('.bc-item-last')
                .prev('.bc-item')
                .children('select')
                .val();
            var oldParentGrpId = $(this)
                .parent('li')
                .prev('li')
                .attr('data-grp');

            if (parentGrpId && oldParentGrpId && nodeId) {

                if (parentUl.hasClass('bc-groups')) {
                    $.ajax(Routing.generate('move_' + nodeType + '_to_group', {_locale: locale, grpId: parentGrpId, grpOldId: oldParentGrpId, nodeId: nodeId}))
                        .done(function (data) {
                            if (data == 'ok') {
                                parentUl.find('select').each(function () {
                                    var nName = $(this).find(':selected').text();
                                    var nId = $(this).val();
                                    $(this).prev('a').text(nName);
                                    $(this).parent('li').attr('data-grp', nId)
                                });
                                resetModalBreadcrumbs();
                                parentUl.find('li.empty').remove();

                                if ($('.switch-to-Group').length > 0) {
                                    $('.switch-to-Group').click();
                                }
                                else {
                                    loadNodeGroups('node-groups', false);
                                    loadNodesRepository('nodes-repository', false);
                                }
                            }
                        });
                }
                else if (parentUl.hasClass('bc-collections')) {
                    $.ajax(Routing.generate('move_' + nodeType + '_to_collection', {_locale: locale, collId: parentGrpId, collOldId: oldParentGrpId, nodeId: nodeId}))
                        .done(function (data) {
                            if (data == 'ok') {
                                parentUl.find('select').each(function () {
                                    var nName = $(this).find(':selected').text();
                                    var nId = $(this).val();
                                    $(this).prev('a').text(nName);
                                    $(this).parent('li').attr('data-grp', nId)
                                });
                                resetModalBreadcrumbs();
                                parentUl.find('li.empty').remove();
                                $('.switch-to-Collection').click();
                            }
                        });

                }
            }
        });

        // create new taxonomy from modal ------------------------------
        var taxonomyCat = 'groups';
        $(document).on('change', '.bc-item-start select', function (e) {
            e.preventDefault();
            var nextLi = $(this).parent('li').next('li');
            taxonomyCat = $(this).val();

            if (taxonomyCat == 'groups') {
                $.ajax(Routing.generate(nodeType + '_groups_list', {_locale: locale, pid: 0}))
                    .done(function (data) {
                        if (data) {
                            nextLi.html(data + '<span>&rsaquo;</span>');
                            nextLi.nextAll('.bc-item-new').remove();
                        }
                    });
            }
            else if (taxonomyCat == 'collections') {
                $.ajax(Routing.generate(nodeType + '_collections_list', {_locale: locale, pid: 0}))
                    .done(function (data) {
                        if (data) {
                            nextLi.html(data + '<span>&rsaquo;</span>');
                            nextLi.nextAll('.bc-item-new').remove();
                        }
                    });
            }
            else {
                $('.bc-root-category').nextAll('.bc-item-new').remove();
            }
            $('.bc-item-new-last button').attr('disabled', true);
        });

        $(document).on('change', '.bc-item-new select', function (e) {
            e.preventDefault();
            var thisLi = $(this).parent('li');
            var groupId = $(this).val();

            if (groupId != '') {
                if (taxonomyCat == 'groups') {
                    $.ajax(Routing.generate(nodeType + '_groups_list', {_locale: locale, pid: groupId}))
                        .done(function (data) {
                            if (data) {
                                thisLi.nextAll('.bc-item-new').remove();
                                thisLi.after('<li class="bc-item-new">' + data + '<span>&rsaquo;</span></li>');
                            }
                            else {
                                thisLi.nextAll('.bc-item-new').remove();
                            }
                        });
                }
                else if (taxonomyCat == 'collections') {
                    $.ajax(Routing.generate(nodeType + '_collections_list', {_locale: locale, pid: groupId}))
                        .done(function (data) {
                            if (data) {
                                thisLi.nextAll('.bc-item-new').remove();
                                thisLi.after('<li class="bc-item-new">' + data + '<span>&rsaquo;</span></li>');
                            }
                            else {
                                thisLi.nextAll('.bc-item-new').remove();
                            }
                        });
                }
                $('.bc-item-new-last button').attr('disabled', false);
            }
            else {
                if (thisLi.hasClass('bc-root-category')) {
                    $('.bc-item-new-last button').attr('disabled', true);
                }
                thisLi.nextAll('.bc-item-new').remove();
            }
        });

        $(document).on('click', '.bc-item-new-last button', function (e) {
            e.preventDefault();
            var ajaxLoader = $('.modal .ajax-loader');
            var nodeId = $(this)
                .parent('li')
                .attr('data-node');
            var prevSelect = $(this)
                .parent('li')
                .prev('li')
                .children('select');
            var prevPrevSelect = $(this)
                .parent('li')
                .prev('li')
                .prev('li')
                .children('select');
            var catId = (prevSelect.val() != '')
                ? prevSelect.val()
                : prevPrevSelect.val();

            ajaxLoader.show();

            if (taxonomyCat == 'groups') {
                $.ajax(Routing.generate('attach_' + nodeType + '_to_group', {_locale: locale, grpId: catId, nodeId: nodeId}))
                    .done(function (data) {
                        if (data == 'ok') {
                            $('#breadcrumbs-modal-wrapper').load(Routing.generate('edit_' + nodeType, {_locale: locale, id: nodeId}) + ' #breadcrumbs-modal-content', function () {
                                var newModalContent = $('#breadcrumbs-modal-content').html();
                                var catCount = $('.breadcrumb-header #categories-counter').text();
                                $('#breadcrumb-modal .modal-body').html(newModalContent);
                                $('.breadcrumb-header #categories-counter').html(parseInt(catCount) + 1);
                                $('.modal .bc-single .delete-button').popover();

                                if ($('.switch-to-Group').length > 0) {
                                    $('.switch-to-Group').click();
                                }
                                else {
                                    loadNodeGroups('node-groups', false);
                                    loadNodesRepository('nodes-repository', false);
                                }
                                ajaxLoader.hide();
                            });
                        }
                    });
            }
            else if (taxonomyCat == 'collections') {
                $.ajax(Routing.generate('attach_' + nodeType + '_to_collection', {_locale: locale, collId: catId, nodeId: nodeId}))
                    .done(function (data) {
                        if (data == 'ok') {
                            $('#breadcrumbs-modal-wrapper').load(Routing.generate('edit_' + nodeType, {_locale: locale, id: nodeId}) + ' #breadcrumbs-modal-content', function () {
                                var newModalContent = $('#breadcrumbs-modal-content').html();
                                var catCount = $('.breadcrumb-header #categories-counter').text();
                                $('#breadcrumb-modal .modal-body').html(newModalContent);
                                $('.breadcrumb-header #categories-counter').html(parseInt(catCount) + 1);
                                $('.modal .bc-single .delete-button').popover();
                                $('.switch-to-Collection').click();
                                ajaxLoader.hide();
                            });
                        }
                    });
            }
        });


        // search
        $('.search-form button').click(function (e) {
            e.preventDefault();
            $('.search-form').submit();
        });
        $('.search-form a').click(function (e) {
            e.preventDefault();
            $('.search-form input').val('');
            $('.search-form').submit();
        });
        $(document).on('submit', '.search-form', function (e) {
            e.preventDefault();
            if ($('.groups').is(':visible')) {
                loadNodeGroups('node-groups', false);
                loadNodesRepository('nodes-repository', false);
            }
            else {
                loadCollectionsGroups('node-groups', false);
                loadNodesCollectionRepository('nodes-repository', false);
            }

        });

        // sort
        $('select[name="sort-by"]').change(function () {
            if ($('.groups').is(':visible')) {
                loadNodesRepository('nodes-repository', false);
            }
            else {
                loadNodesCollectionRepository('nodes-repository', false);
            }
        });

        // citations datatable
        $('#citation-table').dataTable({
            'bFilter': false,
            'bInfo': false,
            'bPaginate': false,
            'aoColumns': [
                {'bSortable': false},
                null,
                null,
                null,
                {'bSortable': false}
            ],
            "order": [
                [1, "asc"]
            ]
        });

        // organizations datatable
        $('#organization-table').dataTable({
            'bFilter': false,
            'bInfo': false,
            'bPaginate': false,
            'aoColumns': [
                {'bSortable': false},
                null,
                null,
                {'bSortable': false}
            ],
            "order": [
                [1, "asc"]
            ]
        });

        // remove related items
        $(document).on('change', '.form-related-items input[type="checkbox"]', function () {
            var deleteButton = $(this)
                .parents('.form-related-items')
                .prev('.related-items-header')
                .find('.remove-related-items');
            if ($('.form-related-items input[type="checkbox"]:checked').length > 0) {
                deleteButton.css('display', 'inline-block');
            }
            else {
                deleteButton.css('display', 'none');
            }
        });


        // new node in groups tree named "New node"
        $(document).on('focusout', '#node-groups-tree li.jstree-node input', function () {
            var nodeTitle = $(this).val();

            if (nodeTitle == 'New node') {

                var nodeId = '#' + $(this).parent().parent('li').attr('id');
                var icon = $(nodeId + ' .jstree-anchor i');

                $(nodeId + ' .jstree-anchor').remove();
                $(nodeId).append('<a class="jstree-anchor" href="#">' + nodeTitle + '</a>');
                $(nodeId + ' .jstree-anchor').append(icon);

                $('#node-groups-tree').jstree('rename_node', nodeId, nodeTitle);
            }
        });
        // new node in repository tree named "New node"
        $(document).on('focusout', '#node-repository-tree li.jstree-node input', function () {
            var nodeTitle = $(this).val();

            if (nodeTitle == 'New node') {

                var nodeId = '#' + $(this).parent().parent('li').attr('id');
                var icon = $(nodeId + ' .jstree-anchor i');

                $(nodeId + ' .jstree-anchor').remove();
                $(nodeId).append('<a class="jstree-anchor" href="#">' + nodeTitle + '</a>');
                $(nodeId + ' .jstree-anchor').append(icon);

                $('#node-repository-tree').jstree('rename_node', nodeId, nodeTitle);
            }
        });

        // text autosize
        if ($('.edit-node-form').length > 0) {
            autosize($('.edit-node-form > div > textarea'));
        }

        // focus fields in td on td click
        $(document).on('click', '#codes td.editable-field', function (e) {
            e.preventDefault();
            $(this).find('input').focus();
            $(this).find('textarea').focus();
        });
        $(document).on('keydown', '#codes td.editable-field input', function (e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

    }
    else {

        loadNodeGroups('groups-listing', true);

        // group view
        $('.show-groups').click(function (e) {
            e.preventDefault();
            $('ul.controls li').removeClass('active');
            $(this).parent().addClass('active');
            loadNodeGroups('groups-listing', true);
        });

        // collection view
        $('.show-collection').click(function (e) {
            e.preventDefault();
            $('ul.controls li').removeClass('active');
            $(this).parent().addClass('active');
            loadCollectionsGroups('groups-listing', true);
        });

        // list view
        $('.show-list').click(function (e) {
            e.preventDefault();
            $('ul.controls li').removeClass('active');
            $(this).parent().addClass('active');
            loadNodesRepository('groups-listing', true);
        });

        // show group/collection data
        // click on tree
        $(document).on('click', 'li.folder > a', function (e) {
            window.isClicked = true;
            e.preventDefault();
            var ajaxLoader = $('.content-show-wrap .ajax-loader');
            var grpId = $(this)
                .parent('li')
                .attr('data-grp');
            ajaxLoader.show();

            if ($(".groups").is(":visible")) {
                $('.content-show').load(Routing.generate(nodeType + '_group_data', {_locale: locale, id: grpId}), function () {
                    ajaxLoader.hide();
                    location.hash = nodeType + '-group/' + grpId;
                    setTimeout(function () {
                        window.isClicked = false
                    }, 1000);
                });
            } else if ($(".collections").is(":visible")) {
                $('.content-show').load(Routing.generate(nodeType + '_collection_data', {_locale: locale, id: grpId}), function () {
                    ajaxLoader.hide();
                    location.hash = nodeType + '-collection/' + grpId;
                    setTimeout(function () {
                        window.isClicked = false
                    }, 1000);
                });
            }
        });
        // add href attribute to a on right click
        $(document).on('mousedown', 'li.folder > a', function (e) {
            if (e.button == 2) {
                var grpId = $(this)
                    .parent('li')
                    .attr('data-grp');
                if ($(".groups").is(":visible")) {
                    $(this).attr('href', '#' + nodeType + '-group/' + grpId);
                } else if ($(".collections").is(":visible")) {
                    $(this).attr('href', '#' + nodeType + '-collection/' + grpId);
                }
            }
        });

        // show group/collection data
        // click on breadcrumb
        $(document).on('click', 'li.bc-item > a', function (e) {
            window.isClicked = true;
            e.preventDefault();
            var parentUl = $(this).parent('li').parent('ul');
            var ajaxLoader = $('.content-show-wrap .ajax-loader');
            var grpId = $(this)
                .parent('li')
                .attr('data-grp');
            ajaxLoader.show();

            if (parentUl.hasClass('bc-groups-public')) {
                $('.content-show').load(Routing.generate(nodeType + '_group_data', {_locale: locale, id: grpId}), function () {
                    ajaxLoader.hide();
                    location.hash = nodeType + '-group/' + grpId;

                    var tree = $("#node-groups-tree").jstree(true);
                    selectTreeItem(tree);
                    setTimeout(function () {
                        window.isClicked = false
                    }, 1000);
                });
            } else if (parentUl.hasClass('bc-collections-public')) {
                $('.content-show').load(Routing.generate(nodeType + '_collection_data', {_locale: locale, id: grpId}), function () {
                    ajaxLoader.hide();
                    location.hash = nodeType + '-collection/' + grpId;
                    setTimeout(function () {
                        window.isClicked = false
                    }, 1000);
                });
            }
        });

        // show node data
        $(document).on('click', 'li.file > a, ul.nodes-for-group li a', function (e) {
            window.isClicked = true;
            e.preventDefault();
            var indId = $(this)
                .parent('li')
                .attr('data-node');
            var ajaxLoader = $('.content-show-wrap .ajax-loader');

            ajaxLoader.show();
            $('.content-show').load(Routing.generate(nodeType + '_data', {_locale: locale, id: indId}), function () {
                ajaxLoader.hide();
                location.hash = nodeType + '/' + indId;
                var tree = $("#node-groups-tree").jstree(true);
                selectTreeItem(tree);
                search_highlight_keywords($(".search-form input").val(), '.content-show');
                setTimeout(function () {
                    window.isClicked = false
                }, 1000);
            });
        });
        // add href attribute to a on right click
        $(document).on('mousedown', 'li.file > a', function (e) {
            if (e.button == 2) {
                var indId = $(this)
                    .parent('li')
                    .attr('data-node');
                $(this).attr('href', '#' + nodeType + '/' + indId);
            }
        });


        // frontend tree/sidebar search
        $(document).on('submit', '.search-form', function (e) {            
            e.preventDefault();
            if ($('li.ctrl1').hasClass('active')) {
                loadNodeGroups('groups-listing', true);
            }
            else if ($('li.ctrl2').hasClass('active')) {
                loadCollectionsGroups('groups-listing', true);
            }
            else if ($('li.ctrl3').hasClass('active')) {
                loadNodesRepository('groups-listing', true);
            }

            if ($('.search-form input').val() != '') {
                $('.search-form a').show();
            }
            else {
                $('.search-form a').hide();                
            }
            
            //set the q param on navigation links
            $(".navigation .section").each(function() {                    
                var href=$(this).attr("href").split("?")[0];
                
                //remove q param
                $(this).attr("href",href);
                
                if ($('.search-form input').val() != '') {
                    $(this).attr("href",href + '?q='+$(".search-form input").val());
                }
            });
        });
        
        // reset search
        $(document).on('input', '.search-form input', function () {
            if ($(this).val() != '') {
                $('.search-form a').show();
            }
            else {
                $('.search-form a').hide();
            }
        });
        $('.search-form a').click(function (e) {
            e.preventDefault();
            $('.search-form input').val('');
            $('.search-form').submit();
        });

    }

});

//hightlight search keywords
function search_highlight_keywords(search, containerClass)
{
    regex="";
    
    if (search) {
        //code
        regex= new RegExp(search, 'ig');
    }
    
    $(containerClass).highlightRegex(regex);
}

// url prefix for dev/prod
var urlPrefix = '';
if (location.pathname.indexOf('app_dev') > 0) {
    urlPrefix = '/app_dev.php';
}


/**
 * form validation
 */
function validation(form) {
    var errors = 0;
    form.find('input[required="required"]').each(function () {
        if ($(this).val() == '') {
            $(this).addClass('error');
            errors++;
        } else {
            $(this).removeClass('error');
        }
    });
    form.find('select[required="required"]').each(function () {
        if ($(this).val() == 'none') {
            $(this).addClass('error');
            errors++;
        } else {
            $(this).removeClass('error');
        }
    });
    form.find('input.email').each(function () {
        var email_value = $(this).val();
        if (email_value.indexOf('@') < 0 || email_value.indexOf('.') < 0) {
            $(this).addClass('error');
            errors++;
        } else {
            $(this).removeClass('error');
        }
    });
    form.find('textarea[required="required"]').each(function () {
        if ($(this).val() == '') {
            $(this).addClass('error');
            errors++;
        } else {
            $(this).removeClass('error');
        }
    });

    //return errors;
    if (errors > 0) {
        return false;
    } else {
        return true;
    }
}


/**
 * Load groups section
 */
function loadNodeGroups(containerClass, publishedOnly) {
    var searchField = $('.search-form input');
    var search = (searchField.val() == '')
        ? ''
        : searchField.val();
    var publishedOnlyVal = (publishedOnly == true)
        ? 'true'
        : 'false';

    var is_front_controller=true;
    
    if (!$('.front-container').length > 0) {
           is_front_controller=false;
    }
    
    var ajaxLoader = $('.' + containerClass).prev('.ajax-loader');
    
    if (is_front_controller) {
        var url =Routing.generate(nodeType + '_groups', {_locale: locale, publishedOnly: publishedOnlyVal, search: search});
    }else{
        var url =Routing.generate(nodeType + '_groups', {_locale: locale, publishedOnly: publishedOnlyVal, search: search,show_empty_groups:1});
    }
    ajaxLoader.show();
    $('.' + containerClass).load(url, function () {
        ajaxLoader.hide();
        treeCopy = $('#node-groups-tree').children();

        if (!is_front_controller) {
            initializeTree();
        }
        else {
            initializeTreePublic();
            search_highlight_keywords(search, '.'+containerClass);
        }
        var countGroups = $('#count-groups').text();
        $('.groups-controls-footer .count-groups')
            .html('<span class="count">' + countGroups + '</span> Groups');
    });
}

/**
 * Load nodes repository
 */
function loadNodesRepository(containerClass, publishedOnly) {
    var filterAssigned;
    var filterPublished;

    var sortFilter = $('select[name="sort-by"]');
    var sort = (sortFilter.length > 0)
        ? sortFilter.val()
        : 'ASC';

    var searchField = $('.search-form input');
    var search = (searchField.val() == '')
        ? ''
        : searchField.val();

    if (publishedOnly == true) {
        filterAssigned = 'all';
        filterPublished = 'yes';
    }
    else {
        filterAssigned = $('input[name="assigned"]:checked').val();
        filterPublished = $('input[name="published"]:checked').val();
    }

    var ajaxLoader = $('.' + containerClass).prev('.ajax-loader');
    ajaxLoader.show();
    $('.' + containerClass).load(Routing.generate(nodeType + '_repository', {_locale: locale, filterAssigned: filterAssigned, filterPublished: filterPublished, sort: sort, search: search}), function () {
        ajaxLoader.hide();

        if (!$('.front-container').length > 0) {
            initializeRepositoryTree();
        }
        else {
            initializeRepositoryTreePublic();
            search_highlight_keywords(search, '.'+containerClass);
        }
        var countNodes = $('#count-nodes').text();
        $('.nodes-controls-footer .count').html(countNodes);
    });
}

/**
 * Load nodes collection repository
 */
function loadNodesCollectionRepository(containerClass) {
    var filterAssigned = $('input[name="assigned"]:checked').val();
    var filterPublished = $('input[name="published"]:checked').val();

    var sortFilter = $('select[name="sort-by"]');
    var sort = (sortFilter.length > 0)
        ? sortFilter.val()
        : 'ASC';

    var searchField = $('.search-form input');
    var search = (searchField.val() == '')
        ? ''
        : searchField.val();

    var ajaxLoader = $('.' + containerClass).prev('.ajax-loader');
    ajaxLoader.show();
    $('.' + containerClass).load(Routing.generate('collection_' + nodeType + '_repository', {_locale: locale, filtersAssigned: filterAssigned, filterPublished: filterPublished, sort: sort, search: search}), function () {
        ajaxLoader.hide();
        if (!$('.front-container').length > 0) {
            initializeRepositoryTree();
        }
        else {
            initializeRepositoryTreePublic();
        }
        var countNodes = $('#count-nodes').text();
        $('.nodes-controls-footer .count').html(countNodes);
    });
}

/**
 * Load collections section
 */
function loadCollectionsGroups(containerClass, publishedOnly) {
    var searchField = $('.search-form input');
    var search = (searchField.val() == '')
        ? ''
        : searchField.val();
    var publishedOnlyVal = (publishedOnly == true)
        ? 'true'
        : 'false';

    var is_front_controller=true;
    var ajaxLoader = $('.' + containerClass).prev('.ajax-loader');

    
    if (!$('.front-container').length > 0) {
           is_front_controller=false;
    }
    
    if (is_front_controller) {
        var url=Routing.generate(nodeType + '_collections', {_locale: locale, publishedOnly: publishedOnlyVal, search: search});
    }else{
        var url =Routing.generate(nodeType + '_collections', {_locale: locale, publishedOnly: publishedOnlyVal, search: search, show_empty_groups:1});
    }    
                
    ajaxLoader.show();
    $('.' + containerClass).load(url, function () {
        ajaxLoader.hide();
        treeCopy = $('#node-groups-tree').children();

        if (!$('.front-container').length > 0) {
            initializeTree();
        }
        else {
            initializeTreePublic();
        }
        var countCollections = $('#count-groups').text();
        $('.groups-controls-footer .count-groups')
            .html('<span class="count">' + countCollections + '</span> Collections');
    });
}

/**
 * edit node form
 */
function editNodeForm(elem, relatedGroups) {
    var nodeId = elem.attr('data-node');
    var ajaxLoader = $('.forms-container').find('.ajax-loader');
    ajaxLoader.show();
    window.isClicked = true;
    location.hash = nodeType + '/' + nodeId;
    setTimeout(function () {
        window.isClicked = false
    }, 1000);

  
    $('.forms-content').load(Routing.generate('edit_' + nodeType, {_locale: locale, id: nodeId}), function () {
        ajaxLoader.hide();
        initializeAddRepeating();
        initializeRemoveRepeating();
        initializeAddRepeating2();
        initializeRemoveRepeating2();

        selectTreeNodeByID(nodeId);

        $('#breadcrumb-modal .modal-body').html('');

        if ($('#collections-counter').length > 0) {
            var groupsCounter = ($('#categories-counter').text() != '')
                ? parseInt($('#categories-counter').text())
                : 0;
            var collectionsCounter = ($('#collections-counter').text() != '')
                ? parseInt($('#collections-counter').text())
                : 0;
            $('#categories-counter').text(groupsCounter + collectionsCounter);
        }
        autosize($('.edit-node > div > textarea'));

        // highlight parent groups in groups tree
        if (relatedGroups.length > 0) {
            
            $('.node-groups li.folder > a').removeClass('highlight');
            var tree = $("#node-groups-tree").jstree(true);
            tree.open_all();

            var toHighlight = [];
            for (i = 0; i < relatedGroups.length; i++) {

                var firstParentLi = $('.node-groups li[data-grp="' + relatedGroups[i] + '"]');

                toHighlight.push(firstParentLi.attr('id'));

                firstParentLi.parents('li').each(function() {
                    toHighlight.push($(this).attr('id'));
                });
            }
            for (var i = 0; i < toHighlight.length; i++) {
                $('.node-groups li#' + toHighlight[i] + ' > a').addClass('highlight');
            };
            $('.node-groups li').each(function() {
                if (!$(this).children('a').hasClass('highlight')) {
                    tree.close_node('#' + $(this).attr('id'));
                }
            });
            $('.node-groups li#groups-root > a').removeClass('highlight');
        }
    });
}


/**
 * edit group form
 */
function editGroupForm(elem) {
    var grpId = elem.attr('data-grp');
    var ajaxLoader = $('.forms-container').find('.ajax-loader');
    ajaxLoader.show();
    window.isClicked = true;
    location.hash = nodeType + '-group/' + grpId;
    setTimeout(function () {
        window.isClicked = false
    }, 1000);

    $('.forms-content').load(Routing.generate('edit_' + nodeType + '_group', {_locale: locale, id: grpId}), function () {
        ajaxLoader.hide();
        selectTreeNodeByID(grpId);
        autosize($('.edit-group > div > textarea'));
    });
}

/**
 * edit collection form
 */
function editCollectionForm(elem) {

    var collId = elem.attr('data-grp');
    var ajaxLoader = $('.forms-container').find('.ajax-loader');

    ajaxLoader.show();
    window.isClicked = true;
    location.hash = nodeType + '-collection/' + collId;
    setTimeout(function () {
        window.isClicked = false
    }, 1000);

    $('.forms-content').load(Routing.generate('edit_' + nodeType + '_collection', {_locale: locale, id: collId}), function () {
        ajaxLoader.hide();
        selectTreeNodeByID(collId);
        autosize($('.edit-group > div > textarea'));
    });
}

/**
 * initialize groups tree - frontend
 */
function initializeTreePublic() {    
    $('#node-groups-tree').jstree({
        'types': {
            'default': {'icon': 'glyphicon glyphicon-folder-open'},
            'file': {'icon': 'glyphicon glyphicon-file'}
        },
        'plugins': ['themes', 'types']
    });

    //highlight search keywords on node open/close
    $("#node-groups-tree").on('open_node.jstree', function (e, data) {
        search_highlight_keywords($(".search-form input").val(), '#node-groups-tree');
    });
    
    
    var tree = $("#node-groups-tree").jstree(true);
    
    if (location.hash) {
        selectTreeItem(tree);
    }
    else {
        treeExpandFirstLevel(tree);
    }

    countFilesInTree(tree);
    treeExpandAfterSearch(tree);
}

/**
 * select tree item in public tree
 */
function selectTreeItem(tree) {

    var parameters = location.hash.split("/");
    var nodeName = parameters[0];
    var nodeId = parameters[1];
    
    //find item by id
    if ($.isNumeric(nodeId)) {

        tree.deselect_all();
        tree.close_all();
        
        var tree_data = tree.get_json("#", {"flat":true});
        if (nodeName.indexOf('-group') > 0) {
            for (var i=0; i<tree_data.length; i++) {
                if (tree_data[i].data.grp == nodeId) {
                    //select node by node id
                    tree.select_node(tree_data[i].id);
                    break;
                }
            }
        }
        else {
            for (var i=0; i<tree_data.length; i++) {
                if (tree_data[i].data.node == nodeId) {
                    //select node by node id
                    tree.select_node(tree_data[i].id);
                    break;
                }
            }
        }
    }
}

/**
 * expand first level if the tree has only one item visible
 */
function treeExpandFirstLevel(tree) {
    if ($('#node-groups-tree li.folder').length == 1) {
        var itemId = $('#node-groups-tree li.folder').attr('id');
        tree.open_node(itemId);
    }
}

/**
 * expand tree after search
 */
function treeExpandAfterSearch(tree) {
    var searchField = $('.search-form input');
    if (searchField.val() != '') {
        tree.open_all();
        $('.search-form a').show();
    }
}

/**
 * count number of file nodes in tree
 */
function countFilesInTree(tree) {
    var treeItems = tree.get_json('#', { "flat" : true });
    var count = 0;
    var nodesList = [];
    for(var i = 0; i < treeItems.length; i++) {
        if (treeItems[i].type == 'file') {
            if ($.inArray(treeItems[i].data.node, nodesList) < 0) {
                nodesList.push(treeItems[i].data.node);
                count++;
            }
        }
    }
    $('.search-form .files-count span').html(count);
}

/**
 * initialize groups tree - backend
 */
function initializeTree() {
    
    window.is_move_button_clicked=false;
    
    $('#node-groups-tree').jstree({
        'core': {
            'check_callback': true
        },
        'types': {
            'default': {'icon': 'glyphicon glyphicon-folder-open'},
            'file': {'valid_children': [], 'icon': 'glyphicon glyphicon-file'}
        },
        'plugins': ['themes', 'html_data', 'dnd', 'state', 'ui', 'types']
    })
        .on('move_node.jstree', function (e, data) {
            
            if (window.is_move_button_clicked) {
                window.is_move_button_clicked=false;
                return false;
            }
            
            // new parent group id
            var parentItemId = data.node.parent;

            // old parent group id
            var oldParentItemId = data.old_parent;

            if (parentItemId != oldParentItemId) {
                if ($(".groups").is(":visible")) {
                    
                    var parentGrpId=0;
                    var oldParentGrpId=0;
                    
                    if (parentItemId!=='#') {
                        parentGrpId = $('#' + parentItemId).attr('data-grp');
                    }
                    
                    if (oldParentItemId!=="#") {
                        oldParentGrpId = $('#' + oldParentItemId).attr('data-grp');
                    }

                    if (parentGrpId == oldParentGrpId) {
                        return false;
                    }

                    if (data.node.type == 'file') {

                        if (parentGrpId != 0) {
                            // moved node id
                            var nodeId = data.node.li_attr['data-node'];

                            // attach node to new group
                            $.ajax(Routing.generate('move_' + nodeType + '_to_group', {
                                grpId: parentGrpId,
                                grpOldId: oldParentGrpId,
                                nodeId: nodeId
                            }))
                                .done(function (data) {
                                    if (data == 'ok') {
                                        messageModal('Moved');
                                    }
                                    else {
                                        messageModal('Item already added to group');
                                    }
                                });
                        }
                        else {
                            loadNodeGroups('node-groups', false);
                            messageModal('The item can not be moved to the root');
                        }

                    }
                    else if (data.node.type == 'default') {

                        // moved group id
                        var grpId = data.node.li_attr['data-grp'];

                        $.ajax(Routing.generate('update_' + nodeType + '_group_pid', {_locale: locale, id: grpId, pid: parentGrpId}))
                            .done(function (data) {
                                if (data == 'ok') {
                                    messageModal('Moved');
                                }
                                else {
                                    messageModal('Error');
                                }
                            });
                    }
                } else if ($(".collections").is(":visible")) {
                    var parentCollId = $('#' + parentItemId).attr('data-grp');
                    var oldParentCollId = $('#' + oldParentItemId).attr('data-grp');

                    if (parentCollId == oldParentCollId) {
                        return false;
                    }
                    if (data.node.type == 'file') {

                        if (parentCollId != 0) {
                            // moved node id
                            var nodeId = data.node.li_attr['data-node'];

                            // attach node to new collection
                            $.ajax(Routing.generate('move_' + nodeType + '_to_collection', {
                                _locale: locale,
                                collId: parentCollId,
                                collOldId: oldParentCollId,
                                nodeId: nodeId
                            }))
                                .done(function (data) {
                                    if (data == 'ok') {
                                        messageModal('Moved');
                                    }
                                    else {
                                        messageModal('Item already added to collection');
                                    }
                                });
                        }
                        else {
                            loadCollectionsGroups('node-groups');
                            messageModal('The item can not be moved to the root');
                        }

                    }
                    else if (data.node.type == 'default') {

                        // moved collection id
                        var collId = data.node.li_attr['data-grp'];

                        $.ajax(urlPrefix + '/admin/update-collection-pid/' + collId + '/' + parentCollId)
                            .done(function (data) {
                                if (data == 'ok') {
                                    messageModal('Moved');
                                }
                                else {
                                    messageModal('Error');
                                }
                            });
                    }
                }
            }

            else {
                var elements, elementsWeights, weight;
                var selectedNode = $("#" + data.node.id);
                var parentGrpId = $('#' + parentItemId).attr('data-grp');

                var updateWeightRoute;
                var updateRefWeightRoute;
                if ($(".collections").is(":visible")) {
                    updateWeightRoute = "update_collection_weights";
                    updateRefWeightRoute = "update_collection_ind_weights";
                }
                else {
                    updateWeightRoute = "update_" + nodeType + "_grp_weights";
                    updateRefWeightRoute = "update_" + nodeType + "_weights";
                }

                if (selectedNode.hasClass("file")) {
                    elements = $("#" + parentItemId).find('> ul > .file');
                    elementsWeights = {};
                    if (elements.length) {
                        weight = 1;
                        elements.each(function () {
                            var elementId = $(this).data('node');
                            elementsWeights[elementId] = weight++;
                        });
                    }

                    $.ajax({
                        url: Routing.generate(updateRefWeightRoute, {_locale: locale, groupId: parentGrpId}),
                        type: "POST",
                        data: {weights: elementsWeights}
                    });

                    return false;
                }
                else {
                    elements = $("#" + parentItemId).find('> ul > .folder');
                    elementsWeights = {};
                    if (elements.length) {
                        weight = 1;
                        elements.each(function () {
                            var elementId = $(this).data('grp');
                            elementsWeights[elementId] = weight++;
                        });
                    }

                    $.ajax({
                        url: Routing.generate(updateWeightRoute, {_locale: locale, pid: parentGrpId}),
                        type: "POST",
                        data: {weights: elementsWeights}
                    });

                    return false;
                }
            }
        })
        .on('copy_node.jstree', function (e, data) {

            var nodeId = data.node.li_attr['data-node'];
            var parentItemId = data.node.parent;

            if ($(".groups").is(":visible")) {
                var grpId = $('#' + parentItemId).attr('data-grp');

                $.ajax(Routing.generate('attach_' + nodeType + '_to_group', {_locale: locale, grpId: grpId, nodeId: nodeId}))
                    .done(function (data) {
                        if (data == 'ok') {
                            loadNodesRepository('nodes-repository', false);
                            messageModal('Added');
                        }
                        else if (data == '0') {
                            loadNodeGroups('node-groups', false);
                            loadNodesRepository('nodes-repository', false);
                            messageModal('The item can not be added to the root');
                        }
                        else {
                            messageModal('Item already added to group');
                        }
                    });
            } else if ($(".collections").is(":visible")) {
                var collId = $('#' + parentItemId).attr('data-grp');

                $.ajax(Routing.generate('attach_' + nodeType + '_to_collection', {_locale: locale, collId: collId, nodeId: nodeId}))
                    .done(function (data) {
                        if (data == 'ok') {
                            loadNodesCollectionRepository('nodes-repository');
                            messageModal('Added');
                        }
                        else if (data == '0') {
                            loadCollectionsGroups('node-groups');
                            loadNodesCollectionRepository('nodes-repository');
                            messageModal('The item can not be added to the root');
                        }
                        else {
                            messageModal('Item already added to collection');
                        }
                    });
            }
        })
        .on('delete_node.jstree', function (e, data) {

            if (data.node.type == 'file') {

                var nodeId = data.node.li_attr['data-node'];
                var parentItemId = data.node.parent;

                if ($(".groups").is(":visible")) {
                    var grpId = $('#' + parentItemId).attr('data-grp');

                    $.ajax(Routing.generate('delete_' + nodeType + '_from_groups', {_locale: locale, grpId: grpId, nodeId: nodeId}))
                        .done(function (data) {
                            if (data == 'ok') {
                                $('.forms-content').html('');
                                loadNodesRepository('nodes-repository', false);
                            }
                        });
                } else if ($(".collections").is(":visible")) {
                    var collId = $('#' + parentItemId).attr('data-grp');

                    $.ajax(Routing.generate('delete_' + nodeType + '_from_collections', {_locale: locale, collId: collId, nodeId: nodeId}))
                        .done(function (data) {
                            if (data == 'ok') {
                                $('.forms-content').html('');
                                loadNodesRepository('nodes-repository', false);
                            }
                        });
                }
            }
            else if (data.node.type == 'default') {
                if ($(".groups").is(":visible")) {
                    var grpId = data.node.li_attr['data-grp'];

                    $.ajax(Routing.generate('delete_' + nodeType + '_group', {_locale: locale, id: grpId}))
                        .done(function (data) {
                            if (data == 'ok') {
                                $('.forms-content').html('');
                            }
                        });
                } else if ($(".collections").is(":visible")) {
                    var collId = data.node.li_attr['data-grp'];

                    $.ajax(Routing.generate('delete_' + nodeType + '_collection', {_locale: locale, id: collId}))
                        .done(function (data) {
                            if (data == 'ok') {
                                $('.forms-content').html('');
                            }
                        });
                }
            }
        })
        .on('rename_node.jstree', function (e, data) {

            if (data.node.text == 'A new node' || data.old == 'A new node') {

                var itemId = data.node.id;
                var parentItemId = data.node.parent;                
                var parentId="0";//0=root level
                
                if (parentItemId!=="#") {
                    var parentId = $('#' + parentItemId).attr('data-grp');
                }
                
                var contentAjaxLoader = $('.forms-container').find('.ajax-loader');
                contentAjaxLoader.show();

                var postVariables, posting, nodeName;

                if (data.node.type == 'file') {
                    if ($(".groups").is(":visible")) {
                        nodeName = data.node.text;
                        postVariables = {
                            'name': nodeName,
                            'grpId': parentId
                        };

                        posting = $.post(Routing.generate('add_' + nodeType, {_locale: locale}), postVariables);

                        posting.done(function (response) {
                            var newItemId = response;

                            // change node data
                            data.node.li_attr['class'] = 'file unpublished';
                            data.node.li_attr['data-node'] = newItemId;

                            // change visible data
                            $('#' + itemId)
                                .addClass('file unpublished')
                                .attr('data-node', newItemId);

                            $('#' + itemId + ' a').click();

                            loadNodesRepository('nodes-repository', false);
                            contentAjaxLoader.hide();
                        });

                    } else if ($(".collections").is(":visible")) {
                        nodeName = data.node.text;
                        postVariables = {
                            'name': nodeName,
                            'collId': parentId
                        };

                        posting = $.post(Routing.generate('add_collections_' + nodeType, {_locale: locale}), postVariables);

                        posting.done(function (response) {
                            var newItemId = response;

                            // change node data
                            data.node.li_attr['class'] = 'file unpublished';
                            data.node.li_attr['data-node'] = newItemId;

                            // change visible data
                            $('#' + itemId)
                                .addClass('file unpublished')
                                .attr('data-node', newItemId);

                            $('#' + itemId + ' a').click();

                            loadNodesCollectionRepository('nodes-repository');
                            contentAjaxLoader.hide();
                        });

                    }
                }
                else if (data.node.type == 'default') {

                    if ($(".groups").is(":visible")) {
                        var groupName = data.node.text;
                        postVariables = {
                            'name': groupName,
                            'pid': parentId
                        };

                        posting = $.post(Routing.generate('add_' + nodeType + '_group', {_locale: locale}), postVariables);
                    } else if ($(".collections").is(":visible")) {
                        var collectionName = data.node.text;
                        postVariables = {
                            'name': collectionName,
                            'pid': parentId
                        };

                        posting = $.post(Routing.generate('add_' + nodeType + '_collection', {_locale: locale}), postVariables);
                    }

                    posting.done(function (response) {
                        var newItemId = response;

                        // change node data
                        data.node.li_attr['class'] = 'folder unpublished';
                        data.node.li_attr['data-grp'] = newItemId;

                        // change visible data
                        $('#' + itemId)
                            .addClass('folder unpublished')
                            .attr('data-grp', newItemId);

                        $('#' + itemId + ' a').click();

                        contentAjaxLoader.hide();
                    });
                }
            }
        });

    var tree = $("#node-groups-tree").jstree(true);
    treeExpandAfterSearch(tree);

}

/**
 * Initialize repository list - frontend
 */
function initializeRepositoryTreePublic() {
    var tree = $('#node-repository-tree').jstree({
        'types': {
            'file': {'icon': 'glyphicon glyphicon-file'}
        },
        'plugins': ['themes', 'types']
    });

    var tree = $("#node-repository-tree").jstree(true);
    countFilesInTree(tree);
}

/**
 * Initialize repository list - backend
 */
function initializeRepositoryTree() {
    $('#node-repository-tree').jstree({
        'core': {
            'check_callback': true
        },
        'types': {
            'file': {'valid_children': [], 'icon': 'glyphicon glyphicon-file'}
        },
        'plugins': ['themes', 'html_data', 'dnd', 'state', 'ui', 'types']
    })
        .on('rename_node.jstree', function (e, data) {

            var itemId = data.node.id;
            var contentAjaxLoader = $('.forms-container').find('.ajax-loader');
            contentAjaxLoader.show();

            var postVariables, posting;

            if ($(".groups").is(":visible")) {
                postVariables = {
                    'name': data.node.text,
                    'grpId': 0
                };

                posting = $.post(Routing.generate('add_' + nodeType, {_locale: locale}), postVariables);
            } else if ($(".collections").is(":visible")) {
                postVariables = {
                    'name': data.node.text,
                    'collId': 0
                };

                posting = $.post(Routing.generate('add_collections_' + nodeType, {_locale: locale}), postVariables);
            }


            posting.done(function (response) {
                var newItemId = response;

                // change node data
                data.node.li_attr['class'] = 'file unclassified';
                data.node.li_attr['data-node'] = newItemId;

                // change visible data
                $('#' + itemId)
                    .addClass('file unclassified')
                    .attr('data-node', newItemId);

                $('#' + itemId + ' a').click();

                contentAjaxLoader.hide();
            });
        });

}

/**
 * Create group/collection or node in groups/collections tree
 */
function createTreeItem(type) {
    var ref = $('#node-groups-tree').jstree(true);
    var sel = ref.get_selected();

    if (!sel.length) {
        return false;
    }
    sel = sel[0];
    sel = ref.create_node(sel, {"type": type, "text": "A new node"}, "first");
    if (sel) {
        ref.edit(sel);
    }
}

/**
 * Create group/collection in the root of groups/collections tree
 */
function createTreeRootItem() {
    var ref = $('#node-groups-tree').jstree(true);
    sel = ref.create_node("#", {"type": "default", "text": "A new node"}, "first");
    if (sel) {
        ref.edit(sel);
    }
}

/**
 * Create node in repository
 */
function createRepositoryItem() {
    var ref = $('#node-repository-tree').jstree(true);
    sel = ref.create_node("#", {"type": "file", "text": "A new node"}, "first");
    if (sel) {
        ref.edit(sel);
    }
}

/**
 * Message modal
 */
function messageModal(msg) {
    $('#messages-modal .modal-body')
        .text(msg);
    $('#messages-modal').modal('show');
}

/**
 * Alert if leaving unsaved form
 */
function leaveUnsaved() {
    if ($('.save-actions .unsaved').is(':visible')) {
        return confirm("You have unsaved data. Leave?");
    }
}

/**
 * Reset breadcrumbs in modal
 */
function resetModalBreadcrumbs() {
    $('.bc-groups .bc-item a, .bc-collections .bc-item a').show();
    $('.bc-groups .bc-item select, .bc-collections .bc-item select').remove();
}

/**
 * Initialize tree in modal
 */
function initializeModalTree(treeId) {
    checkedRelatedQuestionnaires = [];
    $(treeId).jstree({
        'types': {
            'default': {'icon': 'glyphicon glyphicon-folder-open'},
            'file': {'icon': ''}
        },
        'plugins': ['types']
    })
        .on('changed.jstree', function (e, data) {

            if (data.node.type == 'file') {
                var itemId = data.node.id;
                var checkbox = $('#' + itemId).find('input:checkbox');
                if (checkbox.is(':checked')) {
                    checkbox.prop('checked', false);

                    var removeIndex = checkedRelatedQuestionnaires.indexOf(itemId);
                    checkedRelatedQuestionnaires.splice(removeIndex, 1);
                }
                else {
                    checkbox.prop('checked', true);
                    
                    checkedRelatedQuestionnaires.push(itemId);
                }          
            }
        })
        .on('open_node.jstree', function (e, data) {
            $.each(checkedRelatedQuestionnaires, function(index, value) {
                $('#' + value).find('input:checkbox').prop('checked', true);
            })
        });
}

/* Citations and Organizations*/

$(document).ready(function () {
    $("." + nodeType + "-delete").on("click", function () {
        var id = $(this).parent().parent().find('input').data('id');
        $("#delete-" + nodeType).val(id);
        $('#delete-' + nodeType + '-modal').modal('show');
    });

    $("#delete-" + nodeType).on("click", function (e) {
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'delete-' + nodeType + '/' + id
        }).done(function (data) {
                if (data == 'ok') {
                    $('#' + nodeType + '-row-' + id).remove();
                }
            });
    });

    $("#batch-action").on("click", function (e) {
        e.preventDefault();
        if ($('#batch-actions').val() != 0) {
            $('#batch-delete-' + nodeType + '-modal').modal('show');
        }
    });

    $("#batch-delete-" + nodeType).on("click", function (e) {
        e.preventDefault();
        var ids = [];
        if ($('#batch-actions').val() != 0) {
            var actionUrl = $('#batch-actions').val();
            var checked = $('#' + nodeType + '-table').find('input:checked');
            checked.each(function () {
                if ($(this).data('id')) {
                    ids.push($(this).data('id'));
                }
            });
            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: {ids: ids}
            }).done(function (data) {
                    if (data == 'ok') {
                        if (ids.length != 0) {
                            ids.forEach(function (item) {
                                $('#' + nodeType + '-row-' + item).remove();
                            });
                        }
                    }
                });
        }
    });

    $("#selectAll").on("click", function () {
        if ($('#selectAll:checked').length > 0) {
            $('#' + nodeType + '-table').find('input:checkbox').prop("checked", true);
        }
        else {
            $('#' + nodeType + '-table').find('input:checkbox').prop("checked", false);
        }
    });

    $("body").on("click", ".questionnaireResources input[type=checkbox]", function () {
        $(".questionnaireResources input[type=checkbox]").prop('checked', false);
        $(this).prop("checked", true)
    });

    $(document).on("submit", "#search-form", function (e) {
        e.preventDefault();
        var searchTerm = $(this).find("input[name=search]").val();
        if (nodeType == 'user') {
            $(location).attr('href', $(this).closest("form").attr("action") + '/' + searchTerm);
        }
        else {
            $(location).attr('href', $(this).closest("form").attr("action") + '/false/' + searchTerm);
        }
    });

});


/* Repeating field 2 */
var $collectionHolder2;

// setup an "add a tag" link
var $addTagLink2 = $('<a href="#" class="add_tag_link2 btn btn-info">Add element</a>');
var $newLinkLi2 = $('<li></li>').append($addTagLink2);

function addTagForm2($collectionHolder2, $newLinkLi2) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder2.data('prototype');

    // get the new index
    var index = $collectionHolder2.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder2.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    var labelText = $('ul.repeating2').data('label');
    $newLinkLi2.find('a').text('Add ' + labelText);
    $newLinkLi2.before($newFormLi);

    // add a delete link to the new form
    addTagFormDeleteLink2($newFormLi);
}

function addTagFormDeleteLink2($tagFormLi2) {
    var elementLabel = $('ul.repeating2').data('label');
    var $removeFormA = $('<a class="delete_tag_link2 btn btn-danger" href="#">Delete ' + elementLabel + '</a>');
    $tagFormLi2.find('.delete_tag_link2').remove();
    $tagFormLi2.append($removeFormA);
    $('ul.repeating2').children('li:last').children('.delete_tag_link2').remove();


    $removeFormA.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi2.remove();
    });
}

function initializeAddRepeating2() {
    // repeating fields
    $collectionHolder2 = $('ul.repeating2');
    var labelText = $('ul.repeating2').data('label');
    $newLinkLi2.find('a').text('Add ' + labelText);
    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder2.append($newLinkLi2);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder2.data('index', $collectionHolder2.find(':input').length);

    $addTagLink2.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        var labelText = $('ul.repeating2').data('label');
        $newLinkLi2.find('a').text('Add ' + labelText);

        // add a new tag form (see next code block)
        addTagForm2($collectionHolder2, $newLinkLi2);
    });
}

function initializeRemoveRepeating2() {
    // repeating fields
    $collectionHolder2 = $('ul.repeating2');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder2.find('li').each(function () {
        addTagFormDeleteLink2($(this));
    });
}

// Up/Down Buttons & Resource handling

$(document).ready(function () {


    /*
    var Questions = [];
    var deletedQuestions = [];
    var updatedResources = [];
    var deletedResources = [];
    var filesToUpload = [];

  */



    $('body').on('click', '.tree-move-button', function () {
                
        var tree = $('#node-groups-tree').jstree();
        var sel_node_id = tree.get_selected();
        var sel_node=$("#" + sel_node_id);
        var direction = $(this).data("direction");
        
        //selected node types
        var is_leaf=sel_node.hasClass("file");
        var is_folder=sel_node.hasClass("folder");        
        
        if (!sel_node) {
            return false;
        }        
        
        //todo: to be replaced with a better solution for node_move envent
        window.is_move_button_clicked=true;
                
        var parent = tree.get_node(tree.get_parent(sel_node_id), false);
        
        //find the current node position
        var node_pos=$.inArray(sel_node_id[0], parent.children);
        
        //set the new node position
        if ("up" == direction) {
            if (node_pos==0) {
                return false;
            }
            node_pos--;
        }
        else {
            node_pos+=2;
        }
                
        tree.move_node(sel_node_id, parent, node_pos);
                
        //update weights for all items under the current node parent/////////////////////
        
        //parent ID
        var parent_data_id=0;
        
        if (parent.id !=='#'){
            parent_data_id=$("#"+parent.id).attr("data-grp");
        }
    
        var weights={};
        
        //get all children under the parent with new weights after move up/down
        for(i=0;i<parent.children.length;i++){
            
            var node=$("#"+parent.children[i]);
            
            //count only folder nodes
            if (is_folder && node.hasClass("folder")) {
                weights[$("#"+parent.children[i]).attr("data-grp")]=i;
            }            
            else if(is_leaf  && node.hasClass("file")){//count only leaf nodes
                weights[$("#"+parent.children[i]).attr("data-node")]=i;
            }
        };
        
        var updateWeightRoute;
        var updateRefWeightRoute;
            
        if ($(".collections").is(":visible")) {
            updateWeightRoute = "update_collection_weights";
            updateRefWeightRoute = "update_collection_ind_weights";
        }
        else {
            updateWeightRoute = "update_" + nodeType + "_grp_weights";
            updateRefWeightRoute = "update_" + nodeType + "_weights";
        }


        //moving node or node-group/////////////////////////////////////////////////////////
        
        //for nodes
        if (is_leaf) {
            $.ajax({
                url: Routing.generate(updateRefWeightRoute, {_locale: locale, groupId: parent_data_id}),
                type: "POST",
                data: {weights: weights}
            });
            return false;        
        }        
        //group nodes
        else if(is_folder) {            
            $.ajax({
                url: Routing.generate(updateWeightRoute, {_locale: locale, pid: parent_data_id}),
                type: "POST",
                data: {"weights": weights}
            });
            return false;
        }

    });


    $('#ajax-modal').on('hidden.bs.modal', function () {
        $(this).removeClass("edit-state");
        $(this).removeClass("questions-modal");
        $(this).removeClass("modal-wide");
    });
    $("#ajax-modal").on("show.bs.modal", function () {
        if ($(this).hasClass('modal-wide')) {
            var height = $(window).height() - 200;
            $(this).find(".modal-body").css("height", height);
        }
    });

    $('body').on('click', '#questions .question-row', function (e) {
        e.preventDefault();
        window.isClicked = true;
        var nextRow = $(this).next();
        var id = $(this).data('id');
        var ajaxLoader = $(this).find('.ajax-loader-sm');
        if (nextRow.html() == "") {
            ajaxLoader.show();
            $('#questions .question-row').removeClass('active');
            $(this).addClass('active');
            $.ajax({
                type: 'POST',
                url: Routing.getBaseUrl() + '/question-data/' + id
            }).done(function (data) {
                nextRow.html(data);
                $('#questions .question-data-row').addClass('hidden');
                nextRow.removeClass('hidden');
                ajaxLoader.hide();
            });
        }
        else {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).next('tr').addClass('hidden');
            }
            else {
                $('#questions .question-row').removeClass('active');
                $('#questions .question-data-row').addClass('hidden');
                $(this).addClass('active');
                $(this).next('tr').removeClass('hidden');
            }
        }
    });


    //edit question
    $("body").off("input", "#ajax-modal .question-name").on("input", "#ajax-modal .question-name", function () {

        if ($(this).val() != "") {
            if (!$("#ajax-modal #alert-question-title").hasClass("hidden")) {
                $("#ajax-modal #alert-question-title").addClass("hidden");
            }
        }
        else {
            if ($("#ajax-modal #alert-question-title").hasClass("hidden")) {
                $("#ajax-modal #alert-question-title").removeClass("hidden");
            }
        }
    });

    $("body").off("click", ".edit-question").on("click", ".edit-question", function (e) {
        e.preventDefault();
        window.questionPosition = $(this).data("position");

        var ajaxModal = $("#ajax-modal");
        ajaxModal.find(".modal-content").html(" ");
        var classificationCodesTable = ajaxModal.find(".classification-codes-table");
        classificationCodesTable.children('tr:not(:first)').remove();

        var questionModel = getQuestionModel($(this).data("id"));

        var modal = $(".hidden-form-elements");

        var cloned = modal.clone(true);

        var ajaxModal = $("#ajax-modal");

        ajaxModal.addClass("edit-state").addClass("questions-modal").addClass('modal-wide');
        ajaxModal.modal("show");
        questionModel.done(function (data) {
            var modal = $(".hidden-form-elements");

            ajaxModal.find(".modal-content").html(cloned.removeClass("hidden"));


            ajaxModal.find(".question-id").val(data.id);
            ajaxModal.find(".question-name").val(data.name);
            ajaxModal.find(".question-description").val(data.description);
            ajaxModal.find(".question-literal_text").val(data.literalText);
            ajaxModal.find(".question-post_text").val(data.postText);
            ajaxModal.find(".question-pre_text").val(data.preText);
            ajaxModal.find(".question-instructions").val(data.instructions);
            ajaxModal.find(".question-notes").val(data.notes);
            ajaxModal.find(".visual-rep-format-select").val(data.visualRepFormat).change();
            ajaxModal.find(".visual-rep-format-select").on("change", visualRepOnChange);

            questionVisualRepAjax(data.visualRepFormat, data.valRepFormat);


            switch (data.visualRepFormat) {

                case 1:
                    ajaxModal.find(".visual-rep-format-1").removeClass("hidden");
                    ajaxModal.find(".visual-rep-format-ajax").removeClass("hidden");

                    var visualRepInfo = data.valRepFormat;
                    if (visualRepInfo % 1 == 0) {
                        visualRepInfo = Math.floor(visualRepInfo).toString();
                    }
                    var format = $("<div>").addClass("visual-format-numeric").append($("<ul>"));

                    var decimalParts = visualRepInfo.split(".");
                    $.each(decimalParts, function (itemIndex, item) {
                        for (var index = 0; index < item; index++) {
                            format.find("ul").append($("<li>"))
                        }

                        if (itemIndex != decimalParts.length - 1) {
                            format.find("ul").append($("<li>").addClass("format-dot").html('.'));
                        }
                    });
                    $("#ajax-modal").find(".visual-format-preview").html(format);
                    break;
                case 2:
                    ajaxModal.find(".visual-rep-format-ajax").removeClass("hidden");
                    ajaxModal.find(".visual-rep-format-2").removeClass("hidden");

                    var visualRepInfo = parseInt(data.valRepFormat);
                    var format = $("<div>").addClass("visual-format-text").css("width", visualRepInfo * 26 + "px");
                    $("#ajax-modal").find(".visual-format-preview").html(format);
                    $("#ajax-modal").find(".visual-rep-info-field").val(visualRepInfo);
                    break;
                case 3:
                    ajaxModal.find(".classification-table").removeClass("hidden");
                    ajaxModal.find(".remove-classification").removeClass("hidden");
                    var classificationLink = $("<a>").attr("href", Routing.generate('classifications_back') + "#classification/" + data.classificationId).text(data.classificationName);
                    classificationLink.attr("target","_blank");
                    ajaxModal.find(".related-classification-name").html(classificationLink);

                    ajaxModal.find(".classification-id-field").val(data.classificationId);

                    var classificationCodesTable = ajaxModal.find(".classification-codes-table");

                    if (data.classificationCodes != null) {
                        data.classificationCodes.forEach(function (cCode) {
                            var row = '<tr>' +
                                '<td> <input type = "hidden" value = "' + cCode.id + '" />' + cCode.label + '</td>' +
                                '<td>' + cCode.value + '</td>' +
                                '<td>' + '<input type="text" value = "' + cCode.skipValue + '" /> </td>';
                            classificationCodesTable.append(row);
                        });
                    }
            }
        });
    });

    $("body").on("click", "#ajax-modal .remove-classification", function () {

        var ajaxModal = $("#ajax-modal");
        ajaxModal.find(".classification-id-field").val("");
        ajaxModal.find(".related-classification-name").html("");
        ajaxModal.find(".classification-id-field").val(-1);
        
        var classificationCodesTable = ajaxModal.find(".classification-codes-table");
        classificationCodesTable.children().children('tr:not(:first)').remove();

        $(this).addClass("hidden");

    });

    // show remove button related question items
    $("body").on('change', '#questions-items input[type="checkbox"]', function () {
        var checked = $(".form-related-items input:checkbox:checked");
        if (checked != null && checked.length > 0) {
            $('.remove-questions').removeClass("hidden");
        }
        else {
            $('.remove-questions').addClass("hidden");
        }

    });

    //handle resource url or file uploading
    $("body").off("input", "#resources_url").on("input", "#resources_url", function () {
        if ($(this).val() != null && $(this).val() != "") {
            $("#resources_filename").prop('disabled', true);
            var element = $("#resources_filename");
            element.wrap('<form>').parent('form').trigger('reset');
            element.unwrap();
        }
        else {
            $("#resources_filename").prop('disabled', false);
        }
    });

    $("body").off("change", "#resources_filename").on("change", "#resources_filename", function () {
        if ($(this).val() == "") {
            $("#resources_url").prop("disabled", false);
        }
        else {
            $("#resources_url").val("");
            $("#resources_url").prop("disabled", true);

        }
    });

    $("body").off("change", "#resources_docType").on("change", "#resources_docType", function () {
        if ($(this).val() == "") {
            $("#resources_url").prop("disabled", false);
            $("#resources_filename").prop('disabled', true);
            var element = $("#resources_filename");
            element.wrap('<form>').parent('form').trigger('reset');
            element.unwrap();
        }
    });

});


//helper functions
//uploading resource files throught ajax



//comparation based on ID
function containsObject(obj, list) {

    var i;
    for (i = 0; i < list.length; i++) {
        if (list[i].id === obj.id) {
            return list.indexOf(list[i]);
        }
    }
    return -1;

}

function questionVisualRepAjax(visualRepFormat, valRepFormat) {

    if (valRepFormat == null) {
        valRepFormat = 0;
    }
    $.ajax(Routing.generate('visual_rep_info', {
        _locale: locale,
        visualRepFormat: visualRepFormat,
        valRepFormat: valRepFormat
    })).done(function (data) {
        var ajaxModal = $("#ajax-modal");
        ajaxModal.find(".visual-rep-format-ajax").html(data);
    })
        .error(function (message) {
            alert(message);
        });
}

function getQuestionModel(id) {
    return $.ajax({
            url: Routing.generate('get_question_model', {
                _locale: locale,
                questionId: id
            }),
            dataType: "json"
        }
    )
}

function publishUnpublishNodeOrGroup(groupOrCollection, id, published) {

    $(".forms-container .ajax-loader").css("display", "block");
    return $.ajax({
        url: Routing.generate('publish_unpublish_' + nodeType + groupOrCollection, {
            _locale: locale,
            id: id,
            publish: published
        })
    }).done(function (data) {
        if (data == 'ok' && $('#node-groups-tree').length > 0) {

            // groups tree
            if (groupOrCollection != '') {
                if (published == 1) {
                    $('#node-groups-tree li[data-grp="' + id + '"]').removeClass('unpublished');
                }
                else {
                    $('#node-groups-tree li[data-grp="' + id + '"]').addClass('unpublished');
                }
            }
            else {
                if (published == 1) {
                    $('#node-groups-tree li[data-node="' + id + '"]').removeClass('unpublished');
                }
                else {
                    $('#node-groups-tree li[data-node="' + id + '"]').addClass('unpublished');
                }
            }

            // node repository tree
            if ($('#node-repository-tree').length > 0) {
                if (published == 1) {
                    $('#node-repository-tree li[data-node="' + id + '"]').removeClass('unpublished');
                }
                else {
                    $('#node-repository-tree li[data-node="' + id + '"]').addClass('unpublished');
                }
            }
        }
    });
}


//resource list collapse/expand
jQuery(document).ready(function ($) {
        //collapse all resources
        $(".resources-list-collapsable .collapse").collapse()
        
        //resource title click handler
        $(document.body).on('click','.resources-list-collapsable .resource-title', function (e) {            
            
            //get resource id
            resource_id=$(this).attr('aria-controls');
            
            //collapse/expand by resource id
            $(".resources-list-collapsable .collapse#"+resource_id).toggle().toggleClass("expanded");
            
            //set item clicked to active/off
            //$(this).toggleClass("expanded");
            
        });
});

//persist search across sections
jQuery(document).ready(function ($) {

    //check if search q param is set
    var q=getQueryString("q");
    
    //set the q param on navigation links
    $(".navigation .section").each(function() {                    
        var href=$(this).attr("href").split("?")[0];
        
        //remove q param
        $(this).attr("href",href);
        
        if (q != '') {
            $(this).attr("href",href + '?q='+q);
        }
    });
});

//returns the value of querystring by name
function getQueryString(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
            
            
///////////////////// google analytics //////////////////////////
jQuery(document).ready(function ($) {
//ga_tracking must be defined and set for the code to work
if (typeof ga_tracking !== 'undefined' || ga_tracking !== null) {
    if (ga_tracking !="") {        
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
        ga('create', ga_tracking, 'auto');
        ga('send', 'pageview');
        
    
    //global ajax error handler
    $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
        ga('send','event','ajax-error',settings.url, thrownError);
    });

    $( document ).ajaxComplete(function( event, jqxhr, settings) {
        ga('send','event','ajax-complete',settings.url);
    });
    
    }
}
});
///////////////////// end google analytics //////////////////////////

