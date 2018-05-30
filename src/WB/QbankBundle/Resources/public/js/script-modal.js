// repeating fields
var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link">Add Alias</a>');
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
    $newLinkLi.before($newFormLi);
    
    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a class="delete_tag_link" href="#">Delete Alias</a>');
    $tagFormLi.find('.delete_tag_link').remove();
    $tagFormLi.append($removeFormA);
    $('ul.repeating').children('li:last').children('.delete_tag_link').remove();
    

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

function initializeAddRepeating()
{
    // repeating fields
    $collectionHolder = $('ul.repeating');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
}

function initializeRemoveRepeating()
{
    // repeating fields
    $collectionHolder = $('ul.repeating');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
}

jQuery(document).ready(function($){

    // initialize add link for repeating fields
    //initializeAddRepeating();

    // select group on click (Groups)
    $('.ind-groups h4').live('click', function (e) {
        $('.ind-groups h3, .ind-groups h4, .ind-groups p')
            .removeClass('selected');
        $(this)
            .addClass('selected');
        editGroupForm($(this));
    });
    $('.ind-groups h3').live('click', function (e) {
        $('.ind-groups h3, .ind-groups h4, .ind-groups p')
            .removeClass('selected');
        $(this)
            .addClass('selected');
    });

    // select indicator on click (Groups)
    $('.ind-groups p').live('click', function (e) {
        $('.ind-groups h3, .ind-groups h4, .ind-groups p')
            .removeClass('selected');
        $(this)
            .addClass('selected');
        editIndicatorForm($(this));
    });

    // select indicator (Repository)
    $('.ind-repository p').live('click', function (e) {
        $('.ind-groups h4')
            .removeClass('highlignt');
        $('.ind-repository p')
            .removeClass('selected');
        $(this)
            .addClass('selected');

        if ($(this).children('span').attr('data-refgrp')) {
            var relatedGroups = $(this)
                .children('span')
                .attr('data-refgrp')
                .split(',');
        }
        else {
            var relatedGroups = [];
        }

        for (i = 1; i < relatedGroups.length; i++) {
            $('.ind-groups h4[data-grp="'+ relatedGroups[i] +'"]')
                .addClass('highlignt');
        }

        editIndicatorForm($(this));
    });

    // add indicator
    $('.add-ind').click(function (e) {
        e.preventDefault();
        $('.forms-content')
            .html('');
        $('#add-indicator-modal .grp-bradcrumb')
            .html('');
        $('#add-indicator-modal .modal-header h4')
            .text('Add an Indicator');
        $('#add-indicator-modal .modal-form').load(urlPrefix + '/admin/add-indicator', function () {
            initializeAddRepeating();
            $('#add-indicator-modal').modal();
        });
    });

    $('.add-ind-to-grp').click(function (e) {
        e.preventDefault();
  
        if ($('.ind-groups h4.selected').length > 0) {
            var selectedGroup = $('.ind-groups h4.selected').attr('data-grp');

            // parent groups bradcrumb
            var parentGroupsList = '';
            var parentGroups = $('.ind-groups h4.selected').parents('ul');

            for (i = 0; i < parentGroups.length; i++) {
                var parentItem = parentGroups[i];
                var parentItemText = parentItem.children[0].children[0].innerText;
                parentGroupsList = parentItemText + ' > ' + parentGroupsList;
            }
            parentGroupsList = 'Indicators Groups' + ' > ' + parentGroupsList;
            
            $('.forms-content')
                .html('');
            $('#add-indicator-modal .grp-bradcrumb')
                .html(parentGroupsList);
            $('#add-indicator-modal .modal-header h4')
                .text('Add an Indicator to Indicator Groups');
            $('#add-indicator-modal .modal-form').load(urlPrefix + '/admin/add-indicator', function () {
                initializeAddRepeating();
                $('#add-indicator-modal').modal();
            });
        }
        else {
            $('#messages-modal .modal-body')
                .html('Please select an Indicator Group');
            $('#messages-modal').modal();
        }
    });

    $('#add-indicator-modal .save-changes').click(function (e) {
        e.preventDefault();
        $('#add-indicator-modal form').submit();
    });

    $('#add-indicator-modal form').live('submit', function (e) {
        e.preventDefault();
        
        var grpId = $('.ind-groups h4.selected').attr('data-grp');

        if (validation($(this))) {
            var postVariables = $(this).serializeArray();
            var modalAjaxLoader = $('#add-indicator-modal .modal-footer .ajax-loader');

            modalAjaxLoader.show();

            var posting = $.post(urlPrefix + '/admin/add-indicator/' + grpId, postVariables);

            posting.done(function (data) {
                if (data == 'ok') {
                    $('#add-indicator-modal').modal('hide');
                    $('#add-indicator-modal .modal-body input').val('');
                    modalAjaxLoader.hide();
                    loadIndicatorsRepository();
                    if (grpId != 'undefined') {
                        loadIndicatorGroups();
                    }
                }
            });
        }
    });

    // delete indicator from repository - trigger modal
    $('.del-ind').click(function (e) {
        e.preventDefault();
        var selectedItem = $('.ind-repository .selected');

        if (selectedItem.length > 0) {
            var itemLabel = selectedItem.text();
            $('#del-indicator-modal .modal-body')
                .html('Delete "' + itemLabel + '"?');
            $('#del-indicator-modal').modal();
        }
        else {
            $('#messages-modal .modal-body')
                .html('Please select an Indicator');
            $('#messages-modal').modal();
        }

    });

    // delete indicator from repository
    $('#del-indicator-modal .save-changes').click(function (e) {
        e.preventDefault();
        var selectedItem = $('.ind-repository .selected');
        var indId = selectedItem
                        .attr('data-ind');

        $.ajax(urlPrefix + '/admin/delete-indicator/' + indId)
            .done(function (data) {
                if (data == 'ok') {
                    $('#del-indicator-modal').modal('hide');
                    loadIndicatorsRepository();
                    loadIndicatorGroups();
                    $('.forms-content').html('');
                }
            });
    });


    // add group
    $('.add-ind-grp').click(function (e) {
        e.preventDefault();

        if ($('.ind-groups h3.selected').length > 0
            || $('.ind-groups h4.selected').length > 0
        ) {
            // parent groups bradcrumb
            var parentGroupsList = '';
            var parentGroups = $('.ind-groups h4.selected').parents('ul');

            for (i = 0; i < parentGroups.length; i++) {
                var parentItem = parentGroups[i];
                var parentItemText = parentItem.children[0].children[0].innerText;
                parentGroupsList = parentItemText + ' > ' + parentGroupsList;
            }
            parentGroupsList = 'Indicators Groups' + ' > ' + parentGroupsList;

            $('#add-group-modal .grp-bradcrumb')
                .html(parentGroupsList);
            $('#add-group-modal .modal-form').load(urlPrefix + '/admin/add-indicator-group', function () {
                $('#add-group-modal').modal();
            });
        }
        else {
            $('#messages-modal .modal-body')
                .html('Please select an Indicator Group');
            $('#messages-modal').modal();
        }
    });

    $('#add-group-modal .save-changes').click(function (e) {
        e.preventDefault();
        $('#add-group-modal form').submit();
    });

    $('#add-group-modal form').live('submit', function (e) {
        e.preventDefault();

        if (validation($(this))) {
            if ($('h4.selected').length > 0) {
                var grpPid = $('h4.selected')
                                .attr('data-grp');
            }
            else {
                var grpPid = 0;
            }
            $('input[name="indicatorsGroup[pid]"]').val(grpPid);
            
            var postVariables = $(this).serializeArray();
            var modalAjaxLoader = $('#add-group-modal .modal-footer .ajax-loader');

            modalAjaxLoader.show();

            var posting = $.post(urlPrefix + '/admin/add-indicator-group', postVariables);

            posting.done(function (data) {
                if (data == 'ok') {
                    $('#add-group-modal').modal('hide');
                    $('#add-indicator-modal .modal-body input').val('');
                    $('#add-indicator-modal .modal-body textarea').val('');
                    modalAjaxLoader.hide();
                    loadIndicatorGroups();
                }
            });
        }
    });

    // delete group/indicator - trigger modal
    $('.del-ind-grp').click(function (e) {
        e.preventDefault();
        var selectedItem = $('.ind-groups .selected');
        var itemLabel = selectedItem.text();
        var modalHeader = $('#del-group-modal .modal-header h4');
        var modalBody = $('#del-group-modal .modal-body');

        if (selectedItem.length > 0) {
            if (selectedItem.get(0).nodeName == 'H4') {
                modalHeader.html('Delete an Indicator Group');
            }
            else if (selectedItem.get(0).nodeName == 'P') {
                modalHeader.html('Delete an Indicator from Indicator Groups');
            }
            modalBody.html('Delete "' + itemLabel + '"?');
            $('#del-group-modal').modal();
        }
        else {
            $('#messages-modal .modal-body')
                .html('Please select an Indicator or an Indicator Group');
            $('#messages-modal').modal();
        }
    });

    // delete group/indicator action
    $('#del-group-modal .save-changes').click(function (e) {
        e.preventDefault();
        var selectedItem = $('.ind-groups .selected');

        if (selectedItem.get(0).nodeName == 'H4') {

            var grpId = selectedItem
                        .attr('data-grp');

            $.ajax(urlPrefix + '/admin/delete-indicator-group/' + grpId)
                .done(function (data) {
                    if (data == 'ok') {
                        $('#del-group-modal').modal('hide');
                        loadIndicatorGroups();
                    }
                    else {
                        $('#del-group-modal').modal('hide');
                        $('#messages-modal .modal-body')
                            .text('Group contains subgroups');
                        $('#messages-modal').modal('show');
                    }
                });
        }
        else if (selectedItem.get(0).nodeName == 'P') {

            var indId = selectedItem
                            .attr('data-ind');
            var grpId = selectedItem
                            .parent('li')
                            .parent('ul')
                            .parent('li')
                            .children('h4')
                            .attr('data-grp');

            $.ajax(urlPrefix + '/admin/delete-indicator-from-groups/' + grpId + '/' + indId)
                .done(function (data) {
                    if (data == 'ok') {
                        $('#del-group-modal').modal('hide');
                        loadIndicatorGroups();
                        loadIndicatorsRepository();
                    }
                });
        }
    });
    
    // edit indicator
    $('.edit-indicator').live('submit', function (e) {
        e.preventDefault();
        
        if (validation($(this))) {
            var indId = $(this).find('input[name="indId"]').val();
            var postVariables = $(this).serializeArray();
            var contentAjaxLoader = $('.forms-container').find('.ajax-loader');

            contentAjaxLoader.show();

            var posting = $.post(urlPrefix + '/admin/edit-indicator/' + indId, postVariables);

            posting.done(function (data) {
                if (data == 'ok') {
                    loadIndicatorGroups();
                    loadIndicatorsRepository();
                    contentAjaxLoader.hide();
                }
            });
        }
    });
    
    // edit group
    $('.edit-group').live('submit', function (e) {
        e.preventDefault();
        
        if (validation($(this))) {
            var grpId = $(this).find('input[name="grpId"]').val();
            var postVariables = $(this).serializeArray();
            var contentAjaxLoader = $('.forms-container').find('.ajax-loader');

            contentAjaxLoader.show();

            var posting = $.post(urlPrefix + '/admin/edit-indicator-group/' + grpId, postVariables);

            posting.done(function (data) {
                if (data == 'ok') {
                    loadIndicatorGroups();
                    contentAjaxLoader.hide();
                }
            });
        }
    });

    // move indicator/group up
    $('.move-up').click(function (e) {
        e.preventDefault();

        if ($('.selected').get(0).nodeName == 'H4') {
            var groupToMove = $('h4.selected').parent('li');

            /*if (groupToMove.prev('li').children('ul').length > 0) {
                groupToMove.prev('li').children('ul:last').prepend(groupToMove);
            }
            else */
            if (groupToMove.prev('li').length > 0) {
                groupToMove.prev('li').before(groupToMove);
            }
            else if (groupToMove.parent('ul').parent('li').length > 0) {
                groupToMove.parent('ul').parent('li').before(groupToMove);
            }
            attachPidToGroup();
        }
        else if ($('.selected').get(0).nodeName == 'P') {
            alert('move indicator');
        }
    });

    // move indicator/group down
    $('.move-dn').click(function (e) {
        e.preventDefault();

        if ($('.selected').get(0).nodeName == 'H4') {
            var groupToMove = $('h4.selected').parent('li');

            /*if (groupToMove.next('li').children('ul').length > 0) {
                groupToMove.next('li').children('ul:first').prepend(groupToMove);
            }
            else */
            if (groupToMove.next('li').length > 0) {
                groupToMove.next('li').after(groupToMove);
            }
            else if (groupToMove.parent('ul').parent('li').length > 0) {
                groupToMove.parent('ul').parent('li').after(groupToMove);
            }

            attachPidToGroup();
        }
        else if ($('.selected').get(0).nodeName == 'P') {
            alert('move indicator');
        }
    });

    // filter indicators
    $('#filter-indicators').change(function () {
        var filterVal = $(this).val();
        loadIndicatorsRepository();
    });

    // drag & drop
    initializeDragDrop();


    /**
     * rearange parent id-s
     */
    function attachPidToGroup()
    {
        // make pairs [groupId, parentId] for each group
        var pids = new Array();
        $('.ind-groups h4').each(function () {
            var groupId = $(this).attr('data-grp');
            var parentId = 0;
            if ($(this).parents('ul').prev('h4').length > 0) {
                parentId = $(this).parents('ul').prev('h4').attr('data-grp');
            }
            pids.push({gid:groupId, pid:parentId});
        });

        // array to object
        var postVariables = $.extend({}, pids);

        var posting = $.post(urlPrefix + '/admin/update-parent-ids', postVariables);

        posting.done(function (data) {
            if (data == 'ok') {
               alert('ok');
            }
        });
    }

})

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
    form.find('input[required="required"]').each(function(){
        if ($(this).val() == '') {
            $(this).addClass('error');
            errors++;
        } else {
            $(this).removeClass('error');
        }
    });
    form.find('select[required="required"]').each(function(){
        if ($(this).val() == 'none') {
            $(this).addClass('error');
            errors++;
        } else {
            $(this).removeClass('error');
        }
    });
    form.find('input.email').each(function(){
        var email_value = $(this).val();
        if (email_value.indexOf('@') < 0 || email_value.indexOf('.') < 0) {
            $(this).addClass('error');
            errors++;
        }else {
            $(this).removeClass('error');
        }
    });
    form.find('textarea[required="required"]').each(function(){
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
 * Load indicator groups section
 */
function loadIndicatorGroups()
{
    var contentAjaxLoader = $('.ind-groups-container .ajax-loader-2');
    contentAjaxLoader.show();
    $('.ind-groups').load(urlPrefix + '/admin/indicator-groups', function () {
        contentAjaxLoader.hide();
        initializeDragDrop();
        if ($('form.edit-group').length > 0) {
            var grpId = $('form.edit-group input[name="grpId"]').val();
            $('h4[data-grp="'+ grpId +'"]').addClass('selected');
        }
    });
}

/**
 * Load indicators repository
 */
function loadIndicatorsRepository()
{
    var filter = $('#filter-indicators').val();
    var contentAjaxLoader = $('.ind-repository-container .ajax-loader-2');
    contentAjaxLoader.show();
    $('.ind-repository').load(urlPrefix + '/admin/indicator-repository/' + filter, function () {
        contentAjaxLoader.hide();
        initializeDragDrop();
        if ($('form.edit-indicator').length > 0) {
            var indId = $('form.edit-indicator input[name="indId"]').val();
            $('p[data-ind="'+ indId +'"]').addClass('selected');
        }
    });
}

/**
 * Initialize drag & drop
 */
function initializeDragDrop()
{
    $('.ind-repository li').draggable({
        cursor: 'move',
        revert: 'invalid',
        start: function( event, ui ) {
            //console.log(ui)
            //$(this).css({position: 'absolute'});
            //var draggedCopy = $(this).clone(true).css({position: 'relative', left: 0, top: 0});
            //$(this).after(draggedCopy);
        },
        stop: function(event, ui) {
            $(this)
                .css({position: 'static'})
                .removeClass('ui-draggable');
        }
    });
    $('.ind-groups li h4').droppable({
        accept: '.ind-repository li',
        activeClass: 'ui-state-hover',
        hoverClass: 'ui-state-active',
        drop: function(event, ui) {
            var target = $(this);
            var dragged = ui.draggable.get(0);

            var grpId = target.attr('data-grp');
            var indId = dragged.childNodes[1].dataset.ind;

            $.ajax(urlPrefix + '/admin/attach-indicator-to-group/' + grpId + '/' + indId)
                .done(function (data) {
                    if (data == 'ok') {
                        target
                            .removeClass('ui-draggable-dragging')
                            .next('ul')
                            .prepend(dragged);
                        $('.ui-droppable')
                            .removeClass('ui-state-hover');
                        // temp
                        loadIndicatorsRepository();
                    }
                    else {
                        $('#messages-modal .modal-body')
                            .text('Indicator already added to group');
                        $('#messages-modal').modal('show');
                    }

                });
        }
    });
}

/**
 * edit indicator form
 */
function editIndicatorForm(elem)
{
    var indId = elem.attr('data-ind');
    var contentAjaxLoader = $('.forms-container').find('.ajax-loader');

    contentAjaxLoader.show();
    $('.forms-content').load(urlPrefix + '/admin/edit-indicator/' + indId, function () {
        contentAjaxLoader.hide();
        initializeAddRepeating();
        initializeRemoveRepeating();
    });
}

/**
 * edit group form
 */
function editGroupForm(elem)
{
    var grpId = elem.attr('data-grp');
    var contentAjaxLoader = $('.forms-container').find('.ajax-loader');

    contentAjaxLoader.show();
    $('.forms-content').load(urlPrefix + '/admin/edit-indicator-group/' + grpId, function () {
        contentAjaxLoader.hide();
    });
}
