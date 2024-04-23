
import mysql.connector
from EntityClasses import *
from datetime import datetime
import hashlib

def register(registrationEntity):
    returnTuple = (Response.INVALID, "")

    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor()

        # Get all users with credentials matching the ones entered by the user
        query = 'SELECT * FROM user WHERE username = "%s" OR email = "%s" OR id = %d'%(registrationEntity.username, registrationEntity.email, registrationEntity.id)
        print(query)
        cursor.execute(query)
        rows = cursor.fetchall()
        print(rows, len(rows))

        # If rows do not exist from fetchall and there are no rows, then the account doesn't exist yet and we can proceed
        if rows is None or len(rows) < 1:
            ems_full_name = None

            # Get ems data if the account type is 2 (EMS)
            if registrationEntity.accType == 2:
                query = 'SELECT fname, lname FROM ems_employees WHERE ems_id = %d'%registrationEntity.id
                print(query)
                cursor.execute(query)
                ems_full_name = cursor.fetchone()
            
            # If the account type is not EMS or the account type is and there is EMS data, create the account
            if registrationEntity.accType != 2 or ems_full_name is not None: 
                
                password_hash = hashlib.sha256(registrationEntity.password.encode()).hexdigest()
                query = 'INSERT INTO user(id, email, pass, username, account_type) VALUES (%d, "%s", "%s", "%s", %d)'%(registrationEntity.id, registrationEntity.email, password_hash, registrationEntity.username, registrationEntity.accType)
                cursor.execute(query)
                print(query)
                returnTuple = (Response.SUCCESS, "Account Created")
                
                if registrationEntity.accType == 1:
                    query = "INSERT INTO student_medical_info(student_id, id) VALUES (%d, %d)"%(registrationEntity.id, registrationEntity.id)
                    print(query)
                    cursor.execute(query)

                    query = "INSERT INTO emergency_contacts(student_id, id) VALUES (%d, %d)"%(registrationEntity.id, registrationEntity.id)
                    print(query)
                    cursor.execute(query)
                elif registrationEntity.accType == 2:
                    query = 'UPDATE user SET first_name = "%s", last_name = "%s" WHERE id = %d'%(ems_full_name[0], ems_full_name[1], registrationEntity.id)
                    print(query)
                    cursor.execute(query)
                
                cnx.commit()
                
            else:
                returnTuple = (Response.FORBIDDEN, "Account creation failed, EMS ID is not registered as a valid EMS employee.")
        else:
            returnTuple = (Response.CONFLICT, "Account credentials already in use, please use unique credentials.")


    return returnTuple

#SELECT * FROM user WHERE username = :username AND pass = :pass
def login(loginEntity):
    result = None
    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor()

        password_hash = hashlib.sha256(loginEntity.password.encode()).hexdigest()
        # Get all users with credentials matching the ones entered by the user
        query = 'SELECT id, account_type FROM user WHERE username = "%s" AND pass = "%s"'%(loginEntity.username, password_hash)
        print(query)
        cursor.execute(query)
        result = cursor.fetchone()
        print(result)
    return result


def search_student_info(id, get_medical_info=False):
    studentInfo = StudentInfo()
    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor(dictionary=True)


        # Get the first and last name of the student
        query = 'SELECT first_name, last_name FROM user WHERE id = %d'%id
        cursor.execute(query)
        studentInfo.full_name = cursor.fetchone()

        # Get the student's contact info
        query = 'SELECT e_first_name, e_last_name, relation, phone_number FROM emergency_contacts WHERE student_id = %d'%id
        cursor.execute(query)
        studentInfo.emergency_contact = cursor.fetchone()

        if get_medical_info:
            # Get all users with credentials matching the ones entered by the user
            query = 'SELECT * FROM student_medical_info WHERE student_id = %d'%id
            cursor.execute(query)
            studentInfo.medical_info = cursor.fetchone()
            studentInfo.medical_info['dob'] = str(studentInfo.medical_info['dob'])

    return studentInfo

def record_lookup_timestamp(id):
    # Get current date and time
    current_datetime = datetime.now()
    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor(dictionary=True)
        query = 'INSERT INTO recent_lookups(search_time, student_id) VALUES ("%s", %d)'%(current_datetime, id)
        cursor.execute(query)
        cnx.commit()

def update_student_info(id, studentInfo):
    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor(dictionary=True)

        # Get the first and last name of the student
        query = 'UPDATE user SET first_name = "%s", last_name = "%s" WHERE id = %d'%(studentInfo.full_name['first_name'], studentInfo.full_name['last_name'], id)
        cursor.execute(query)
        cnx.commit()

        # Get the student's contact info
        query = 'UPDATE emergency_contacts SET e_first_name = "%s", e_last_name = "%s", relation = "%s", phone_number = "%s" WHERE student_id = %d'%(studentInfo.emergency_contact['e_first_name'], studentInfo.emergency_contact['e_last_name'], studentInfo.emergency_contact['relation'], studentInfo.emergency_contact['phone_number'], id)
        cursor.execute(query)
        cnx.commit()
        
        # Construct the SQL query
        query = "UPDATE student_medical_info SET "
        for key, value in studentInfo.medical_info.items():
            if key != 'id':  # Exclude the 'id' field from the update
                if isinstance(value, str):
                    query += "%s = '%s', "%(key, value)
                else:
                    query += "%s = %d, "%(key, value)
        query = query.rstrip(', ')  # Remove the trailing comma and space
        query += " WHERE id = %d;"%id  # Add the WHERE clause
        cursor.execute(query)
        cnx.commit()

def get_recent_searches():
    result = None
    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor(dictionary=True)

        # Get all users with credentials matching the ones entered by the user
        query = 'SELECT * FROM recent_lookups ORDER BY search_time'
        cursor.execute(query)
        result = cursor.fetchall()
        
        # Convert datetime objects to strings
        for item in result:
            item['search_time'] = item['search_time'].strftime('%Y-%m-%d %H:%M:%S')
    return result

def test():
    result = None
    # Establishing connection using context manager
    with mysql.connector.connect(user='dbmasteruser', password='Lifeline2024',
                                host='ls-3b7e6f89b80f6a9ff2d02a1394dd18e58f481247.cl444yoq0gck.us-east-2.rds.amazonaws.com',
                                database='Lifeline') as cnx:
        cursor = cnx.cursor(dictionary=True)

        # Get all users with credentials matching the ones entered by the user
        query = 'SELECT * FROM user WHERE account_type = 3'
        # query = 'SELECT * FROM recent_lookups ORDER BY search_time'
        print(query)
        cursor.execute(query)
        result = cursor.fetchall()
        
        # Convert datetime objects to strings
        """
        for item in result:
            item['search_time'] = item['search_time'].strftime('%Y-%m-%d %H:%M:%S')
        """
        print(result)
    return result

if __name__ == '__main__':
    test()
    # (1, 'John', 'Smith', 'test@gmail.com', 'Testpass1', 'test', 1)
    # e_first_name': 'Jane', 'e_last_name': 'Smith', 'relation': 'wife', 'phone_number': '111-222-3333'