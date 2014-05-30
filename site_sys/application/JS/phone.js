$(document).ready(function() {
    $("div.hidden").hide();
    
    $("a.add_phone").click(function(e) {
        $("div.hidden:not(:visible):first").show('slow');
        if(!$("div.hidden:not(:visible)").length){
            $("a.add_phone").hide(10);
        }
        e.preventDefault();
    });
    
    $("button.del_phone").click(function(e) {
        var inputParent = $(this).parent();
        var inputWrap = inputParent.find('div');
        console.log(inputWrap);
        inputWrap.html(inputWrap.html());
        inputParent.hide('slow');
        if($("a.add_phone:not(:visible)").length) {
            $("a.add_phone").show();
        }
        e.preventDefault();
    });
});



