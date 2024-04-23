# Lifeline-Web-Server
Senior Project repository for Lifeline Web Server: Christian Beatty, Jeremiah Neff, Joshua Panaro, Anthony Stepich.

To deploy this site, upload all .php, .js, and .css files to the htdocs folder of an Apache web server. all .py files should be placed in a subdirectory named api. Alternatively, the same can be achieved on a local machine using xampp. 

To start the api endpoint for android app connectivity, navigate to the api directory and type the command "screen -dmS server python3 ApiEndpoint.py"

Account type: stored in $_SESSION['acc_type'] for reference by multiple pages, int value
    0: no account/not logged in
    1: student account
    2: EMS account
    3: EMS Admin account
