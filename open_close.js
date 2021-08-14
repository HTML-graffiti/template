$(function(){
    $("#hello u").on("click", function(){
    var id = $(this).data("click");
    $("#" + id).show(1000);
    })
});
