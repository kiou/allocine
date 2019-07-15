/**
 * Jquery
 */
$(function(){
    
    options = {
        emoji: 'star',
        count: 5,
        fontSize: 22,
        inputName: 'rating',
        onUpdate: function(count) {
            $('input[name="rating"]').val(count);
        }
    }

    $('#rating').emojiRating(options);

    /* Champ formatioin en ajax besoin */
    $(document).on('change','.formCategorie',function(){
        var select = $(this);
        var selectSousCategorie = $('.formSousCategorie');
        var value = select.val();
        var url = select.attr('data-url')+'/'+value;
    
        if(value != ''){
            $.ajax(url,{dataType : "JSON"})
                .done(function(data){
                    selectSousCategorie.find('option').not('option:first').remove();
                    for (var i = 0; i < data.return.length; i++) {
                        selectSousCategorie.append('<option value="'+data.return[i].id+'">'+data.return[i].titre+'</option>');
                    }
                })
                .fail(function(){
                    alert('Erreur Ajax');
                });
        }else selectSousCategorie.find('option').not('option:first').remove();

    });

    /* Slider */
    if ($('.slider').length != 0) {
        var owl = $('.slider');

        owl.on('initialized.owl.carousel', function(event){
            $('.owl-item.active').find('.sliderContenu').addClass('active');
        });

        owl.owlCarousel({
            items: 1,
            responsiveRefreshRate: 10,
            nav: true,
            autoplay: true,
            autoplaySpeed: 2000,
            autoplayTimeout: 8000,
            navSpeed: 800,
            margin:30,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        });

        owl.on('translate.owl.carousel', function() {
            $('.owl-item .sliderContenu').removeClass('active');
        });

        owl.on('translated.owl.carousel', function(event) {
            $('.owl-item.active').find('.sliderContenu').addClass('active');
        });
    }

    /* Header mobile */
    $(document).on('click','.headerBtnMobile',function(){
        $(this).addClass('active');

        $('.headerMobile').fadeIn(200);
    });

    /* Fermer header mobile */
    $(document).on('click','.headerMobile',function(e){
        if($(e.target).attr('class') == 'headerMobile'){
             $('.headerBtnMobile').removeClass('active');

             $(this).fadeOut(200);
        }
    });

    /* Menu collant */
    $(".header").sticky({topSpacing:0});

    /* Navigation via JS */
    $(document).on('click','.navFull',function(e){
        e.preventDefault();

        var elem = $(this);
        var lien = (elem.attr('href') != undefined) ? elem.attr('href') : elem.attr('data-url');
        window.location.href = lien;

    });

    /* Changement de langue */
    $('.headerSelecteur select').on('change',function(){
        top.location.href = $(this).val();
    });

    /* Menu déroulant */
    $('ul.sf-menu').superfish();

    /* menu déroulant */
    $(document).on('click','.navigation .noLink', function(e){
        e.preventDefault();
    });

    /* Afficher la newsletter */
    $(document).on('click', '.openNewsletter', function (e) {
        e.preventDefault();
        $('.newsletter').addClass('active');
    });

    /* Fermer la newsletter */
    $(document).on('click', '.newsletterClose', function () {
        $('.newsletter').removeClass('active');
        if($('.message').length) $('.message').slideToggle(function(){
            $('.message').remove();
            $('input[name="userbundle_newsletter[email]"]').val('');
        });
    });

    /* Valider la newsletter */
    $(document).on('click','#newsletterForm button',function(e){
        e.preventDefault();
        var button = $(this);
        var url = $('#newsletterForm').attr('action');
        var html = '';

        if(!button.hasClass('current')){
            button.prepend('<i class="fas fa-cog fa-spin"></i>');
            button.addClass('current');

            var fd = new FormData(document.getElementById("newsletterForm"));

            $.ajax(url,{
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                dataType: 'json',
                cache:false
            })
            .done(function(data){
                button.find('.fas').remove();
                button.removeClass('current');

                /* Supprimer le message si il éxiste déjà */
                if($('.message').length) $('.message').remove();

                /* Afficher le résultat */
                if(data.succes != undefined){
                    html = '<div class="message succes"><p>';
                        html += data.succes;
                    html += '</p></div>';

                    /* Reset des champs */
                    $('input[name="userbundle_newsletter[email]"]').val('');
                }
                else{
                    var label = Object.keys(data.error);

                    html = '<div class="message error"><p>';
                        for (var i = 0; i < label.length; i++) {
                            html += data.error[label[i]][0]+'<br>';
                        }
                    html += '</p></div>';
                }

                /* Afficher le contenu des messages */
                $(html).hide().prependTo($('#newsletterForm')).fadeIn();
            })
            .fail(function(){
                alert('Erreur ajax');
            });
        }
    });

    /* Partage sur les réseaux sociaux */
    $(document).on('click','.partage button',function(e){
        e.preventDefault();

        var button = $(this);
        var url = button.attr('data-url');
        var titre = button.attr('data-titre');

        var popupWidth = 640;
        var popupHeight = 320;
        var windowLeft = window.screenLeft || window.screenX;
        var windowWidth = window.innerWidth || document.documentElement.clientWidth;
        var popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2 ;

        if(button.hasClass('twitter')){
           var shareUrl = 'https://twitter.com/intent/tweet?text='+ encodeURIComponent(titre)+'&url='+encodeURIComponent(url)
           var popupTitre = 'Partage sur twitter';
        }else if (button.hasClass('facebook')){
            var shareUrl = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url)
            var popupTitre = 'Partage sur facebook';
        }else if (button.hasClass('linkedin')){
            var shareUrl = 'https://www.linkedin.com/shareArticle?url='+encodeURIComponent(url)
            var popupTitre = 'Partage sur Linkedin';
        }

        window.open(shareUrl, popupTitre, 'scrollbars=yes, width=' + popupWidth + ', height=' + popupHeight + ', top= 0' + ', left=' + popupLeft);

    });

    /* Calendrier */
    $('.calendrierPlus').on('click',function(e){

        e.preventDefault();

        var lien = $(this);
        var mois = parseInt(lien.attr('data-mois')) + 1;
        var annee = parseInt(lien.attr('data-annee'));
        var nav = $('.calendrierNav');

        if(mois > 12){
            mois = 1;
            annee += 1;
        }

        var url = lien.attr('data-url')+'/'+annee+'/'+mois;

        if(!nav.hasClass('current')) {
            nav.prepend('<i class="fa fa-refresh fa-spin"></i>');
            nav.addClass('current');

            $.ajax(url, {
                dataType: "json"
            })
                .done(function (data) {
                    nav.find('.fa-refresh').remove();
                    nav.removeClass('current');

                    /* Calendrier */
                    $('.calendrierNav p').html(data.date);
                    $('.calendrierContent').hide().html(data.contenu).fadeIn('fast');

                    /* Mise à jour des liens de navigation */
                    $('.calendrierPlus').attr('data-mois', mois);
                    $('.calendrierPlus').attr('data-annee', annee);

                    if (mois == 1) {
                        $('.calendrierMoins').attr('data-mois', 1);
                        $('.calendrierMoins').attr('data-annee', annee - 1);
                    } else {
                        $('.calendrierMoins').attr('data-mois', mois);
                        $('.calendrierMoins').attr('data-annee', annee);
                    }

                })
                .fail(function () {
                    alert('Erreur Ajax');
                });

        }

    });

    $('.calendrierMoins').on('click',function(e){

        e.preventDefault();

        var lien = $(this);
        var mois = parseInt(lien.attr('data-mois')) - 1;
        var annee = parseInt(lien.attr('data-annee'));
        var nav = $('.calendrierNav');

        if(mois < 1){
            mois = 12;
            annee -= 1;
        }

        var url = lien.attr('data-url')+'/'+annee+'/'+mois;

        if(!nav.hasClass('current')) {
            nav.prepend('<i class="fa fa-refresh fa-spin"></i>');
            nav.addClass('current');

            $.ajax(url, {
                dataType: "json"
            })
                .done(function (data) {
                    nav.find('.fa-refresh').remove();
                    nav.removeClass('current');

                    /* Calendrier */
                    $('.calendrierNav p').html(data.date);
                    $('.calendrierContent').hide().html(data.contenu).fadeIn('fast');

                    /* Mise à jour des liens de navigation */
                    $('.calendrierMoins').attr('data-mois', mois);
                    $('.calendrierMoins').attr('data-annee', annee);


                    if (mois == 12) {
                        $('.calendrierPlus').attr('data-mois', 1);
                        $('.calendrierPlus').attr('data-annee', annee + 1);
                    } else {
                        $('.calendrierPlus').attr('data-mois', mois);
                        $('.calendrierPlus').attr('data-annee', annee);
                    }

                })
                .fail(function () {
                    alert('Erreur Aajax');
                });

        }

    });

    /* Fermer un popup evenement */
    $(document).on('click','.calendrierEvenement .fa-times',function(){
        $('.calendrierEvenement').removeClass('active');
    });

    /* Popup des événements */
    $(document).on('click', '.calendrierPuce' ,function(){

        var date = $(this);
        var evements = date.next('.calendrierEvenement');

        if(evements.hasClass('active'))
            evements.removeClass('active');
        else{
            $('.calendrierEvenement').removeClass('active');
            evements.addClass('active');

        }
    });

});

$(window).on('load', function() {
    $('.newsletter').css({'display':'block'});
});