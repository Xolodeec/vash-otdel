function selectCompanyBx24(data)
{
    let companyData = data[0]['company'][0];
    let companyID = companyData['id'].substr(3);

    if(companyID.length > 0)
    {
        $("#reportform-companyid").val(companyID);
        $("#reportform-companyname").val(companyData.title);
        $(".unselected-co-b24").removeClass("w-auto h-100 d-flex align-items-center").hide(200);
        $(".selected-co-bx24").html(companyData.title + '<i class="fa-solid fa-xmark"></i>').addClass("w-auto h-100 d-flex align-items-center").show(200);
    }
}

function unselectCompanyBx24()
{
    $(".selected-co-bx24").removeClass("w-auto h-100 d-flex align-items-center").hide(200);
    $(".unselected-co-b24").html('<i class="fa-sharp fa-solid fa-plus"></i>Выбрать компанию').addClass("w-auto h-100 d-flex align-items-center").show(200);

    $("#reportform-companyid").val(null)
    $("#reportform-companyname").val(null)
}

$(document).ready(function (){
    setSeparatorResponsible();
});