
$(function(){

    // If we are going to make a research, hide the description block
    $('.mainInput').focus(function() {
        $('#description').hide();
    });

    $('#autoComplete').keyup(function(event){

        // NOT => 38 : upArrow ; 40 : downArrow ; 13 : enter
        if(event.keyCode != 38 && event.keyCode != 40 && event.keyCode != 13){
            var place_to_eat = $(this).val(); //input retrieval
            console.log(place_to_eat);

            var url = Routing.generate('autoComplete', {find : place_to_eat});

            if(place_to_eat != ''){

                $.ajax({
                    type:'GET',
                    url: url,
                    dataType: 'json',
                    success:function(res){
                        afficheList(res);
                    },
                    error:function(){
                        alert('Error');
                    }
                });
            } else {
                $('#list').html('').hide();
            }

        }

        // IF 40 : downArrow
        if(event.keyCode==40){
            if($('#list ul li.active').length==0){
                $('#list ul li').first().addClass('active');
            }else{
                if(!$('#list ul li.active').is('#list ul li:last')){
                    $('#list ul li.active').removeClass('active').next().addClass('active');
                }
            }
        }

        // IF 38 : upArrow
        if(event.keyCode==38){
            if($('#list ul li.active').length>0){
                if(!$('#list ul li.active').is('#list ul li:first')){
                    $('#list ul li.active').removeClass('active').prev().addClass('active');
                }
            }
        }

        // IF enter
        if(event.keyCode==13){
            $('#autoComplete').val($('#list ul li.active').attr('place'));
            $('#list').html('').hide();

            var place = $('#autoComplete').val();
            var url2 = Routing.generate('one_place_to_eat', {name: place});
            populateBigInfoWindow(url2);
        }

    });


    $('#list').on('click', 'ul li', function(){
        var place_to_eat = $(this).attr('place');
        $('#list').html('').hide();
        $('#autoComplete').val(place_to_eat);
        $('#description').show();

        var place = $('#autoComplete').val();
        var url3 = Routing.generate('one_place_to_eat', {name: place});
        populateBigInfoWindow(url3);
    });

    function populateBigInfoWindow(url) {
        $.get(url, function(data) {
            console.log(data.onePlace[0].denomination);
            $('#description').html(
                '<h3>' + data.onePlace[0].denomination + '</h3>' +
                '<p>' + data.onePlace[0].adresse + ', ' + data.onePlace[0].codePostal + '</p>'
            ).show();
        });
    }

    function afficheList(json){
        console.log(json.places.length);

        if(json.places.length>0){
            var html='<ul>';

            $.each(json.places.slice(0,10), function(index, place_to_eat){
                console.log(index, place_to_eat);
                html += '<li place="'+place_to_eat.denomination+'">'+place_to_eat.denomination+'</li>';
            });

            html += '</ul>';

            $('#list').html(html).show();
        }else{
            $('#list').hide();
        }

    }

});