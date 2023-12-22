$(function() {
    $('td a#a_id').click(function() {
        return confirm("Are You sure that You want to delete this?");
    });
});