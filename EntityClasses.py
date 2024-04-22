class Response:
    SUCCESS = 200
    UNAUTHORIZED = 401
    FORBIDDEN = 403
    CONFLICT = 409
    INVALID = -1

    def __init__(self, message, responseCode):
        self.message = message
        self.responseCode = responseCode

    def to_dict(self):
        return {
            'message': self.message,
            'responseCode': self.responseCode
        }

class LoginResponse(Response):
    def __init__(self, message, responseCode, token=None):
        super().__init__(message, responseCode)
        self.token = token

    def to_dict(self):
        returnDictionary = super().to_dict()
        returnDictionary['token'] = self.token
        return returnDictionary

class RegistrationEntity:
    def __init__(self, accType, username, email, id, password1, password2, agreedToTerms):
        self.accType = accType
        self.username = username
        self.email = email
        self.id = id
        self.password1 = password1
        self.password2 = password2
        self.agreedToTerms = agreedToTerms
    
    def check_validity(self):
        if self.username is None or self.username == "":
            return (False, "Username must be entered.")
        elif self.email is None or self.email == "":
            return (False, "Email must be entered.")
        elif self.id is None or self.id < 0:
            return (False, "A valid ID must be entered")
        elif self.password1 is None or self.password1 == "":
            return (False, "Password must be entered")
        elif self.password2 is None or self.password2 == "":
            return (False, "Password must be entered")
        elif self.password1 != self.password2:
            return (False, "Passwords do not match")
        elif not self.agreedToTerms:
            return (False, "Must agree to terms to register")
        elif self.accType < 1 or self.accType > 3:
            return(False, "Must select a valid accoutn t")
        else:
            return(True, "")
        
class LoginEntity:
    def __init__(self, username, password):
        self.username = username
        self.password = password
    
    def check_validity(self):
        if self.username is None or self.username == "":
            return (False, "Username must be entered.")
        elif self.password is None or self.password == "":
            return (False, "Password must be entered.")
        else:
            return(True, "")

class StudentInfo:
    def __init__(self, full_name=None, emergency_contact=None, medical_info=None):
        self.full_name=full_name
        self.emergency_contact=emergency_contact
        self.medical_info=medical_info
    
    def to_dict(self):
        return {
            'full_name': self.full_name,
            'emergency_contact':self.emergency_contact,
            'medical_info':self.medical_info
        }

    def has_info(self):
        return self.full_name is not None and self.emergency_contact is not None and self.medical_info is not None
    
    @classmethod
    def from_dict(cls, dictionary):
        return cls(dictionary['full_name'], dictionary['emergency_contact'], dictionary['medical_info'])
