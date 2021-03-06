$(function () {
    $("#from").datepicker();
    $("#to").datepicker();

    $(document).on("keyup", ".volunteer-name", function () {
        var str = $(this).val();
        var target = $(this);
        $.ajax({
            type: 'get',
            url: 'reportsAjax.php?q=' + str,
            success: function (response) {
                var suggestions = $.parseJSON(response);
                console.log(target);
                target.autocomplete({
                    source: suggestions
                });
            }
        });
    });

    $("input[name='date']").change(function () {
        if ($("input[name='date']:checked").val() === 'date-range') {//Added === - GIOVI
            $("#fromto").show();
        } else {
            $("#fromto").hide();
        }
    });

    $("#report-submit").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'reportsAjax.php',
            data: $('#search-fields').serialize(),
            success: function (response) {
                $("#outputs").html(response);
            }
        });
    });

$(function() //This function hides the Select Individuals section when Total Hours or Shift/Vacancies are selected - GIOVI
{              
    $('#indititle').hide();//indititle was added on line 47 in reports.inc.php as an id for the title of the individuals - GIOVI
    $('#1').hide();
    $('#add-more').hide();
    $('#report-type').on('change', function() {
        var type = document.getElementById('report-type');
        if(type.value === 'volunteer-names') 
        { 
            $('#indititle').show();
            $('#1').show();

        } 
        else
        {
            $('#indititle').hide();
            $('#1').hide();

        }
                                               });
});

});
