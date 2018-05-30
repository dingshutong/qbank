// hide empty tables
$('.form-related-items table').each(function () {
    if ($(this).find('tbody tr').length == 0) {
        $(this).hide();
    }
    else {
        $(this).prev('.related-items-info').hide();
    }
});

// remove related items
$(".remove-related-items").on("click", function () {
    var container = $(this).parents("fieldset").first();
    var checked = container.find(".form-related-items").find("[type=checkbox]:checked");
    var relatedTable = container.find('table');
    checked.each(function () {
        $(this).parents("tr").first().remove();
    });
    $(this).css('display', 'none');
    $('form .saved').hide();
    $('form .unsaved').show();
    if (container.find('tbody tr').length == 0) {
        container.find('table').hide();
        container.find('.related-items-info').show();
    }
});

// add related items
$("body").off("click",".add-related-items").on("click",".add-related-items", function () {
    
    var target = $(this).data("target");
    var container = $(this).data("container");
    var ajaxLoader = $(this).next('.ajax-loader-inline');
    var excludedIds = [];
    var selectedItems = $(container).find(":checkbox");
    selectedItems.each(function () {
        var id = $(this).val();
        excludedIds.push(id);
    });
    
    $(".add-related-items.currentModal").removeClass('currentModal');
    $(this).addClass('currentModal');
    ajaxLoader.show();

    $.ajax({
        url: $(this).data("url"),
        method: "POST",
        dataType: "html",
        data: { excludedIds: excludedIds },
        success: function (response) {
            var data = $(response);
            $(target).find(".modal-content").html(data);
            $(target).modal('show');
            ajaxLoader.hide();
        }
    })
});

// Search on modal
$(document).on("submit", "#search-form-modal", function (e) {
    e.preventDefault();
    var searchTerm = $(this).find("input[name=search]").val();
    var modalData = $(this).closest('.modal-body').find('.modal-data');
    var modalContent = $(this).closest('.modal-content');
    var container = $(".currentModal").data("container");
    var excludedIds = [];
    var selectedItems = $(container).find(":checkbox");
    var entityName = $(this).attr("data-entityName");
    var url = $(this).closest("form").attr("action") + '/' + entityName + '/false';
    var ajaxLoader = $(this).find('.ajax-loader-inline');
    if (searchTerm) {
        url += '/' + searchTerm;
    }
    selectedItems.each(function () {
        var id = $(this).val();
        excludedIds.push(id);
    });

    ajaxLoader.show();

    $.ajax({
        url: url,
        method: "POST",
        dataType: "html",
        data: { excludedIds: excludedIds },
        success: function (response) {
            var data = $(response);
            if (searchTerm) {
                modalData.html(data);
            }
            else {
                modalContent.html(data);
            }
            ajaxLoader.hide();
        }
    });
});

