#!/home/adi/Desktop/Licenta/RFID/venv/bin/python3

import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
import time

reader = SimpleMFRC522()

db = mysql.connector.connect(
    host="localhost",
    user="admin",
    passwd="parola",
    database="sistemsupraveghere"
)

cursor = db.cursor()

try:
    while True:
        print("Apropie un card pentru înregistrare...")
        id, text = reader.read()
        name = input("Introdu numele utilizatorului: ")

        cursor.execute("SELECT * FROM users WHERE rfid_uid = %s", (str(id),))
        result = cursor.fetchone()

        if result:
            print("Card deja înregistrat.")
        else:
            cursor.execute("INSERT INTO users (name, rfid_uid) VALUES (%s, %s)", (name, str(id)))
            db.commit()
            print("Utilizator înregistrat cu succes.")

        time.sleep(2)
except KeyboardInterrupt:
    print("Oprire script.")
finally:
    GPIO.cleanup()
    db.close()
