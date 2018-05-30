/**
 * Created by Neske on 3/18/2015.
 */

$('body').off('click', '.move-related-item').on('mouseenter', '.move-related-item', function (e) {
    var parentRow = $(this).parents('tr');
    parentRow.find('td').addClass('highlight');
    parentRow.find('input').addClass('highlight');
    parentRow.find('textarea').addClass('highlight');
});
$('body').off('click', '.move-related-item').on('mouseout', '.move-related-item', function (e) {
    var parentRow = $(this).parents('tr');
    parentRow.find('td').removeClass('highlight');
    parentRow.find('input').removeClass('highlight');
    parentRow.find('textarea').removeClass('highlight');
});

$('body').off('click', '.move-related-item').on('click', '.move-related-item', function (e) {
    e.preventDefault();

    var direction = $(this).attr("data-direction");
    if (direction == "down") {
        $(this).closest("tr").next().after($(this).closest("tr"));
    }
    else {
        $(this).closest("tr").prev().before($(this).closest("tr"));
    }
    var weights = $(this).closest('tbody').find('.relation-weight');
    var weight = 1;
    weights.each(function(){
        $(this).val(weight++);
    });
    $('form .saved').hide();
    $('form .unsaved').show();
});
