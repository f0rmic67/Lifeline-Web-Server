from Crypto.Cipher import AES
from Crypto.Util.Padding import pad, unpad
import base64
from Crypto.Random import get_random_bytes

KEY = b'c5710a1f4104edb233cebb4d2d5e6ec7'

def encrypt_data(data):
    global KEY
    cipher = AES.new(KEY, AES.MODE_CBC)
    ct_bytes = cipher.encrypt(pad(data.encode(), AES.block_size))
    iv = base64.b64encode(cipher.iv).decode('utf-8')
    ct = base64.b64encode(ct_bytes).decode('utf-8')
    return iv + ct

def decrypt_data(data):
    global KEY
    print(data)
    iv = base64.b64decode(data[:24])
    ct = base64.b64decode(data[24:])
    cipher = AES.new(KEY, AES.MODE_CBC, iv)
    pt = unpad(cipher.decrypt(ct), AES.block_size).decode('utf-8')
    return pt


if __name__ == '__main__':
    # Example usage:
    data = "HELLO WORLD!!"
    encrypted_data = encrypt_data(data)
    print(isinstance(encrypted_data, str))
    print("Encrypted data:", encrypted_data)
    print("Decrypted data:", decrypt_data(encrypted_data))
