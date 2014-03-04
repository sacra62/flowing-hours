/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
    $(".users.settings").on("click","a",function(){
        var $id = "#"+$(this).attr("id").replace("_settings","");
        $( $id ).dialog({
            modal: true, 
            zIndex: 10000, 
            autoOpen: true,
            width: 'auto', 
            resizable: false,
            buttons: {
                Save: function () {
                    saveSettings($(this),$id);
                    console.log($id);
                    if($id=="#app_theme"){
                    window.location.reload();
                    }
                    
                }
            },
            close: function (event, ui) {
                $(this).dialog("close");
            }
        });
    });
    
    
});

function saveSettings(dlg,formparent){
    //all is good. we need to set tasklist id 
    
    var formid = formparent+"_form";
    var form = $(formid);
    $.post( baseURL+"users/saveSettings",form.serialize(), function( result ) {
        if(result!="1"){
            alert("something went wrong");
        }
        else {
                
            //success - add the task to the list
            dlg.dialog("close");
        }
        
        
    // no issues go ahead and save.
    });
}