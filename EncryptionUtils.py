from cryptography.hazmat.primitives import hashes
from cryptography.hazmat.backends import default_backend
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.primitives import padding
import base64

def get_cipher(session_id):
    # Hash the session ID with SHA-256
    session_id_bytes = str(session_id).encode('utf-8')
    hash_value = hashes.Hash(hashes.SHA256(), backend=default_backend())
    hash_value.update(session_id_bytes)
    hash_result = hash_value.finalize()

    # Extract key and IV from the hash
    key = hash_result[0:16]  # take substring from index 9 to index 17 (total 9 bytes)
    iv = hash_result[-16:]   # take last 16 bytes

    # Create and return the encryptor
    cipher = Cipher(algorithms.AES(key), modes.CBC(iv), backend=default_backend())
    return cipher

def encrypt_data(session_id, data):
    encryptor = get_cipher(session_id).encryptor()

    # Convert data to bytes if it's not already
    if not isinstance(data, bytes):
        if not isinstance(data, str):
            data = str(data)
        data_bytes = data.encode('utf-8')
    else:
        data_bytes = data

    # Pad the data to be a multiple of the block size (16 bytes for AES)
    padder = padding.PKCS7(128).padder()
    padded_data = padder.update(data_bytes) + padder.finalize()

    # Encrypt the padded data
    encrypted_data = encryptor.update(padded_data) + encryptor.finalize()

    # Encode the encrypted data as Base64
    encrypted_base64 = base64.b64encode(encrypted_data)

    return encrypted_base64.decode('utf-8')

def decrypt_data(session_id, encrypted_base64):
    # Decode Base64-encoded string back to bytes
    encrypted_data = base64.b64decode(encrypted_base64)

    decryptor = get_cipher(session_id).decryptor()

    # Decrypt the data
    decrypted_data = decryptor.update(encrypted_data) + decryptor.finalize()

    # Remove padding
    unpadder = padding.PKCS7(128).unpadder()
    unpadded_data = unpadder.update(decrypted_data) + unpadder.finalize()

    # Decode decrypted data back to string
    decrypted_str = unpadded_data.decode('utf-8')

    return decrypted_str



if __name__ == '__main__':
    # Example usage:
    session_id = 123456789  # Example session ID

    # Encrypt integer data
    encrypted_int = encrypt_data(session_id, 1234)
    print("Encrypted integer:", str(encrypted_int))

    # Encrypt string data
    encrypted_string = encrypt_data(session_id, "test_String")
    print("Encrypted string:", str(encrypted_string))
    print(isinstance(encrypted_string,str))
    decrypted_string = decrypt_data(session_id, encrypted_string)
    print("Decrypted string:", decrypted_string)
