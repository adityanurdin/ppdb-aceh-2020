// SideBar
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});
// Delete Confirm
function confirm_delete() {
    return confirm('are you sure?');
}