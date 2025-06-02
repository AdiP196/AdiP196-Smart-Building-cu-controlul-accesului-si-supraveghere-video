#ifndef __NORDIC_NRF24L01_RADIO_H__
#define __NORDIC_NRF24L01_RADIO_H__

// comenzi SPI
#define R_REGISTER 0x00 // Citește date dintr-un registru
#define W_REGISTER 0x20 // Scrie date intr-un registru
#define W_TX_PAYLOAD_NOACK 0xB0 // Scrie payload fără ACK
#define FLUSH_TX 0xE1           // Golește bufferul TX
#define W_ACK_PAYLOAD 0b10101000 /* 1010 1PPP | PPP = pipe number */

// REGISTER MAP
#define CONFIG 0x00
#define EN_CRC 3  // Activeaza CRC
#define CRC0 2    // Selectează 1 sau 2 bytes CRC
#define PWR_UP 1  // Power Up
#define PRIM_RX 0 // Setează mod RX (1) sau TX (0)

#define RF_CH 0x05    // Selectează canalul RF (0x00 – 0x7F = 2.4–2.525 GHz).
#define RF_SETUP 0x06 // Controlează puterea și viteza de transmisie:
#define RF_DR_2MBPS 0x08
#define POWER_MAX 0x06
#define POWER_LOW 0x02 // 0b00000010

#define STATUS 0x07
#define TX_DS 5  //	Pachet transmis cu succes
#define MAX_RT 4 // S-au atins maximul de retransmisi

#define TX_ADDR 0x10

#endif 
