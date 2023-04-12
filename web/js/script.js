$(document).ready(function () {
    $('.first-button').on('click', function () {
        $('.animated-icon1').toggleClass('open');
        $('.collapse').toggleClass('show');
    });


    $('.type-company-select select').on('change', function (){
        let typeCompany = $(this).val();

        slideInputCompany(typeCompany);
    });

    function slideInputCompany(typeCompany)
    {
        if(typeCompany == 1)
        {
            $('.ogrn').slideDown();
            $('.ogrnIp').slideUp();
            $('.inn').slideDown();
        }

        if(typeCompany == 2)
        {
            $('.ogrn').slideUp();
            $('.ogrnIp').slideDown();
            $('.inn').slideDown();
        }

        if(typeCompany == 3)
        {
            $('.ogrn').slideUp();
            $('.ogrnIp').slideUp();
            $('.inn').slideUp();
        }
    }

    let typeCompany = $('.type-company-select select').val();

    slideInputCompany(typeCompany);
});