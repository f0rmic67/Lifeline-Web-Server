from flask import Flask, jsonify, request, session
from EntityClasses import *
import DataBaseUtils
import jwt


app = Flask(__name__)

@app.route('/createAccount', methods=['POST'])
def create_account():
    reg = RegistrationEntity(**request.json)
    is_valid, error_message = reg.check_validity()

    # If the registration data is valid, create the account
    if is_valid:
        response_code, error_message = DataBaseUtils.register(reg)
        # If we successfully created an account, save the id and account type for the session
        if response_code == Response.SUCCESS:
            encoded_jwt = jwt.encode({"id": reg.id, "accType":reg.accType}, app.secret_key, algorithm="HS256").decode("utf-8")
            response = LoginResponse(error_message, response_code, encoded_jwt)
        else:
            response = LoginResponse(error_message, response_code)
    # Otherwise, notify the user
    else:
        response = LoginResponse(error_message, Response.INVALID)

    return jsonify(response.to_dict())

@app.route('/login', methods=['POST'])
def login():
    loginEntity = LoginEntity(**request.json)
    is_valid, error_message = loginEntity.check_validity()

    # If the registration data is valid, create the account
    if is_valid:
        session_info = DataBaseUtils.login(loginEntity)
        if session_info is None:
            response = LoginResponse("No such account exists.", Response.INVALID)
        else:            
            encoded_jwt = jwt.encode({"id": session_info[0], "accType":session_info[1]}, app.secret_key, algorithm="HS256").decode("utf-8")
            response = LoginResponse("Login Successful", Response.SUCCESS, encoded_jwt)
    else:
        response = LoginResponse(error_message, Response.INVALID)

    return jsonify(response.to_dict())

@app.route('/studentInfo', methods=['GET', 'POST'])
def search_id():
    auth_header = request.headers.get('Authorization')
    token = None
    if auth_header is not None:
        token = jwt.decode(auth_header, app.secret_key, algorithms=["HS256"])
    
    if request.method == 'GET':
        idToSearch = int(request.args.get('studentId'))
        is_self_lookup = token is not None and token['id'] == idToSearch
        should_get_medical_info = token is not None and not (token['accType'] == 1 and not is_self_lookup)
        print("Should get med info:", should_get_medical_info)
        response = DataBaseUtils.search_student_info(idToSearch, should_get_medical_info)
        
        if response.has_info() and not is_self_lookup:
            DataBaseUtils.record_lookup_timestamp(idToSearch)

        return jsonify(response.to_dict())
    elif request.method == 'POST':
        if token['id'] is None:
            print("Permission Denied")
            return jsonify(Response("Permission Denied", Response.FORBIDDEN).to_dict())

        studentInfo = StudentInfo.from_dict(request.json)
        print("Student info:", studentInfo.to_dict())
        try:
            DataBaseUtils.update_student_info(token['id'], studentInfo)
            print("Info updated")
            return jsonify(Response("Info updated successfully!", Response.SUCCESS).to_dict())
        except Exception as e:
            print("Database Error", e)
            return jsonify(Response("Database Error", Response.INVALID).to_dict())

@app.route('/recentSearches', methods=['GET'])
def get_recent_searches():
    auth_header = request.headers.get('Authorization')
    token = None
    if auth_header is not None:
        token = jwt.decode(auth_header, app.secret_key, algorithms=["HS256"])
    
    if token is None or token["accType"] < 2:
        return jsonify([])
    else:
        recentSearches = DataBaseUtils.get_recent_searches()
        print(recentSearches)
        return jsonify(recentSearches)


if __name__ == '__main__':
    app.secret_key = 'c5710a1f4104edb233cebb4d2d5e6ec7'
    context = ('lifeline-project.net.crt', 'lifeline-project.net.key')
    app.run(host='0.0.0.0', debug=True, ssl_context=context)
    """

    SELECT * FROM user WHERE account_type = 2
    [{'id': 111122223333, 'first_name': None, 'last_name': None, 'email': 'EMStest@gmail.com', 'pass': 'EMStest1', 'username': 'EMStest', 'account_type': 2}, {'id': 444455556666, 'first_name': 'Jane', 'last_name': 'Doe', 'email': 'EMStest2@gmail.com', 'pass': 'EMStest2', 'username': 'EMStest2', 'account_type': 2}]
    """
