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

    var rb = $(".dropbtn-report");
    var rw = $(".wrapper-report");
    rb.click(function() {
        rw.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });

    var pb = $(".dropbtn-profile");
    var pw = $(".wrapper-profile");
    pb.click(function() {
        pw.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });

    var ob = $(".dropbtn-order");
    var ow = $(".wrapper-order");
    ob.click(function() {
        ow.toggleClass('open'); /* <-- toggle the application of the open class on click */
    });
});

function setProductPrice(id, elementID)
{
    var price = 0;

    $.ajax({
        url: '/forms/default/get-product-price',         /* Куда пойдет запрос */
        method: 'get',             /* Метод передачи (post или get) */
        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
        data: {id: id},     /* Параметры передаваемые в запросе. */
        success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
            $(elementID).val(data);           /* В переменной data содержится ответ от index.php. */
        }
    });

    return price;
}