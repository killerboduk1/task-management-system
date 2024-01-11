require('./bootstrap');

$(document).ready(function() {

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });

    var timeout = null;
    $('#task-search').keyup(function() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {

        $('#task-search-result').html("");
        const data = {
            'search': $(this).val()
        }

        if($(this).val() == ''){
            $('#task-search-result').hide();
        }

        $.ajax({
            type:'POST',
            url:'/task/search',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            success:function(data){
                $('#task-search-result').show();
               for(var i = 0; i < data.length; i++)
               {
                $('#task-search-result').append(`
                    <a href="/task/view/${data[i].id}" class="text-decoration-none"><li class="list-group-item list-group-item-action">${data[i].title}</li></a>
                `);
               }
            }
         });

    }, 700);
    });

    $('#sort-task').on('change', function() {
        window.location = "/home?sort="+this.value;
    });

});


