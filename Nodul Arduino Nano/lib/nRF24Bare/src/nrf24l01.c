
#include <avr/io.h>
// #include <avr/interrupt.h>
#include <util/delay.h> //pentru _delay_ms() si delay_us()
#include <stdio.h>		//pentru printf
#include <stdbool.h>	//true/false
#include <string.h>		//functii de manipulare string

// nRF24L01 include files
#include "nrf24l01.h"
#include "nrf24l01_registrii.h"
#include "spi.h"

// Adresa de transmisie (de 5 octeti)
uint8_t tx_address[5] = {0xe7, 0xe7, 0xe7, 0xe7, 0xe7};


#define DATARATE RF_DR_2MBPS // 250kbps, 1mbps, 2mbps
#define POWER POWER_MAX	 // Set power (MAX 0dBm..HIGH -6dBm..LOW -12dBm.. MIN -18dBm)
#define CHANNEL 0x74		 // 2.4GHz-2.5GHz channel selection (0x01 - 0x7C), 0x74 = 116

// PIN map

// CE - Chip enable: LOW-Standby, HIGH+RX - Receptioneaza date, Puls in mod TX -Trimite date
#define CE_DDR DDRB
#define CE_PORT PORTB
#define CE_PIN DDB1 // CE conectat la PB1/D9
// CSN -Chip Select - activ pe low
#define CSN_DDR DDRB
#define CSN_PORT PORTB
#define CSN_PIN DDB2 // CSN conectat la PB2/D10

// Functii pentru manipularea bitilor
#define setbit(port, bit) (port) |= (1 << (bit))	// Pune bit pe 1
#define clearbit(port, bit) (port) &= ~(1 << (bit)) // Pune bit pe 0
#define ce_low() clearbit(CE_PORT, CE_PIN)			// Pune CE pe nivelul logic 0(Low)
#define ce_high() setbit(CE_PORT, CE_PIN)			// Pune CE pe nivelul logic 1(High) 3.3V/5V
#define csn_low() clearbit(CSN_PORT, CSN_PIN)		// Incepe o comanda SPI
#define csn_high() setbit(CSN_PORT, CSN_PIN)		// Incheie o comanda SPI

// Utilizat pentru a stoca comenzi SPI
uint8_t data;

// Trimite comenzi SPI către nRF24L01
uint8_t nrf24_send_spi(uint8_t register_address, void *data, unsigned int bytes)
{
	uint8_t status;
	csn_low();
	status = spi_exchange(register_address);
	for (unsigned int i = 0; i < bytes; i++)
		((uint8_t *)data)[i] = spi_exchange(((uint8_t *)data)[i]);
	csn_high();
	return status;
}

// Scrie date în registrul register_address
uint8_t nrf24_write(uint8_t register_address, uint8_t *data, unsigned int bytes)
{
	return nrf24_send_spi(W_REGISTER | register_address, data, bytes);
}
// Citește date din registru
uint8_t nrf24_read(uint8_t register_address, uint8_t *data, unsigned int bytes)
{
	return nrf24_send_spi(R_REGISTER | register_address, data, bytes);
}

void nrf24_init(void)
{
	// 1) CE/CSN ca output
	setbit(CE_DDR, CE_PIN);
	setbit(CSN_DDR, CSN_PIN);
	csn_high();
	ce_low();

	// 2) SPI + delay
	spi_master_init(); // Configurare SPI ca master
	_delay_ms(100);

	// 3) CONFIG: PowerUp + CRC ON pe 2 bytes
	uint8_t cfg = (1 << PWR_UP) | (1 << EN_CRC) | (1 << CRC0);
	nrf24_write(CONFIG, &cfg, 1);

	// 4) canal, datarate, power
	uint8_t ch = CHANNEL;
	nrf24_write(RF_CH, &ch, 1);
	uint8_t rf = (DATARATE | POWER);
	nrf24_write(RF_SETUP, &rf, 1);

	// 5) adresa TX
	nrf24_write(TX_ADDR, tx_address, 5);

	// 6) clear TX flags + flush TX
	uint8_t sts = (1 << TX_DS) | (1 << MAX_RT);
	nrf24_write(STATUS, &sts, 1);
	nrf24_write(FLUSH_TX, 0, 0); // Golește bufferul de trimitere
}

uint8_t nrf24_send_message(const void *msg)
{
	size_t len = strlen((const char *)msg); // fara caracterul NULL \0
	if (len > 32)
		len = 32;

	// Power up și TX (clear PRIM_RX)
	uint8_t cfg;
	nrf24_read(CONFIG, &cfg, 1);
	cfg |= (1 << PWR_UP);	// Bitul 1 (PWR_UP) devine 1 – power up
	cfg &= ~(1 << PRIM_RX); // Bitul 0 (PRIM_RX) devine 0 – mod TX
	nrf24_write(CONFIG, &cfg, 1);

	// Încarcă payload fără ACK
	csn_low();
	spi_send(W_ACK_PAYLOAD);
	/*
	for (size_t i = 0; i < len; i++)
	{
		spi_send(((uint8_t *)msg)[i]);
	}
		*/
	for (size_t i = 0; i < 32; i++)
	{
		if (i < len)
		{
			spi_send(((uint8_t *)msg)[i]);
		}
		else
		{
			spi_send(0); // completăm cu 0
		}
	}
	//spi_send(0); // Umplem ultimul byte cu zero/NULL
	csn_high();

	// Pulse CE >10µs
	ce_high();
	_delay_us(15); // minim 10µs conform datasheet
	ce_low();
	printf("TX: \"%s\"\n", (char *)msg);
	return 1;
}
