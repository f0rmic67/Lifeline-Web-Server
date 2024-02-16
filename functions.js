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
            });
            $("#pass").val('');
            $("#email").val('');
        }
//will have to check aginst the DB 

        let password = $("#pass").val();
        let email = $("#email").val();

      
    });

    $("#createStudentAcc").on('click touch' , function(){
        //make sure all fields have values and adhere to critea
        if($("#studentUserName").val() == "" || $("#studentEmail").val() == "" || $("#studentIdNumber").val() == "" || $("#studentPass").val() == "" || $("#studentReEnterPass").val() == "" ){
            Swal.fire({
                title : 'ERROR',
                text : 'You must fill in all fields',
                icon : 'error',
                confirmButtonText:'Okay'
            });
        }

            let student = {
                userName: $("#studentUserName").val(),
                email: $("#studentEmail").val(),
                IdNum: $("#studentIdNumber").val(),
                pass: $("#studentPass").val(),
                rePass: $("#studentReEnterPass").val()
            };
            
            if (!(student.email.includes('@pennwest.edu'))){
                Swal.fire({
                    title : 'ERROR',
                    text : 'You must have a pennwest email to create an account',
                    icon : 'error',
                    confirmButtonText:'Okay'

                });
            }

            if(student.userName.length < 8){
                Swal.fire({
                    title : 'ERROR',
                    text : 'Your username must be at least 8 characters',
                    icon : 'error',
                    confirmButtonText:'Okay'

                });
            }

            if(!(student.IdNum.toString().length == 16)){
                Swal.fire({
                    title : 'ERROR',
                    text : 'Your ID Must be 16 characters',
                    icon : 'error',
                    confirmButtonText:'Okay'

                });
            }

            if(student.pass.length < 8){
                Swal.fire({
                    title : 'ERROR',
                    text : 'Your password Must be 8 characters',
                    icon : 'error',
                    confirmButtonText:'Okay'

                });
                
            }

            if(student.pass != student.rePass){
                Swal.fire({
                    title : 'ERROR',
                    text : 'Your passwords do not match',
                    icon : 'error',
                    confirmButtonText:'Okay'

                });
                
            }

        $("#btnCreateStudentAcc").on("click touch" , function(){
            $.ajax({
                type: "POST",
                url: "studentCreateAcc.phpORPython/studentCreateAcc",
                data: "{student:" + JSON.stringify(student)+ "}",
                contentType: "application/json; charset=utf8",
                success: createStudentAccSuccess,
                failure: errorOccured,
                error: errorOccured
            });
            
            function createStudentAccSuccess(response){
                data = JSON.parse(response.d);
                if (data.sucess){
                    //work to be done once we connect db 
                }
            }

            
        });
            
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

