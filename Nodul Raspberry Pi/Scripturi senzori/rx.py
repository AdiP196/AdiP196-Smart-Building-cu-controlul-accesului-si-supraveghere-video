from RF24 import RF24, RF24_PA_LOW, RF24_2MBPS, RF24_CRC_16
import time

radio = RF24(22, 1)  # CE=GPIO22, CSN=SPI0 CS0

ADDRESS = b"\xE7\xE7\xE7\xE7\xE7"

def setup():
    if not radio.begin():
        raise RuntimeError("NRF24L01 nu a putut fi inițializat")

    radio.setPALevel(RF24_PA_LOW)
    radio.setDataRate(RF24_2MBPS)
    radio.setChannel(0x74)
    radio.setCRCLength(RF24_CRC_16)
    radio.setAutoAck(True)        # <- important
    radio.disableDynamicPayloads()
    radio.setPayloadSize(32)
    radio.openReadingPipe(0, ADDRESS)
    radio.startListening()
    print("Receptor pornit. Aștept mesaje...")

def main():
    setup()
    while True:
        if radio.available():
            received = radio.read(32)
            try:
                message = received.decode('utf-8').rstrip('\0')
                print(f"Mesaj primit: {message}")

                # Scriem mesajul în fișierul pentru pagina web
                with open("/var/www/html/sensor_data.txt", "w") as f:
                    f.write(message + "\n")

            except Exception as e:
                print("Eroare decodare mesaj.", e)
        time.sleep(0.1)

if __name__ == "__main__":
    main()
