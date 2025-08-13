//this one is for the aside bar counting latest students no. from latest class created
//also the number of class
$(document).ready(function(){
    $.ajax({
        url: 'php_ud/aside-bar-countings.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('.total-classes').text(response.total_classes);
                $('.latest_students_total').text(response.latest_students_total);
            }
        },
        error: function () {
            console.error('Failed to fetch aside bar counts.');
        }
    });
});
