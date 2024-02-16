function loadPage(){
 addListeners();
}
function addListeners(){
    //validate user input before submitting login information

    $("#subLog").on('click touch' ,function() {
        if ($("#pass").val() == ""  || $("#email").val() =="")
        {
            Swal.fire({
                title : 'ERROR',
                text : 'You Must fill in both fields',
                icon : 'error',
                confirmButtonText:'Okay'
            })
            $("#pass").val('');
            $("#email").val('');
        }
//will have to check aginst the DB 

        let password = $("#pass").val();
        let email = $("#email").val();

      
    });
}


    //functions to validate user input before sending to server
    function validateSearch(){

    }

    //display proper form for chosen account type
    //this would happen after the user has made an account and signed in 
    function accountType(){

    }

    //validate user input before submitting form
    function validateStudent(){

    }

    //validate user input before submitting form
    function validateEMS(){

    }

