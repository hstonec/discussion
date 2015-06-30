$(function(){
    $("#test").dialog({
        title: "Register Form",
        width: 500,
        height: 800,
        modal: true,
        resizable: false,
        buttons: [
            {
                text: "Sign Up Now",
                click: function () {
                    alert("afdasdf");
                }
            },
            {
                text:"Cancel",
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });
});