$("#sendform").submit(function(event){ 
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to login.php using AJAX
    $.ajax({
        url: "transfer.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $('#sendmessage').html(data);   
            }
        },
        error: function(){
            $("#sendmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            
        }
    
    });

});
