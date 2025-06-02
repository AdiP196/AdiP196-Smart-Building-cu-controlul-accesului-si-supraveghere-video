#include <avr/io.h>
#include <util/delay.h>
#include <stdio.h>
#include <avr/interrupt.h>
#include <string.h>

#include "STDIO_UART.h"
#include "lux_senzor.h"
#include "nrf24l01.h"

#include "spi.h"
#include "i2c.h"
#include "DHT11.h"

int main(void)
{

    uart_init();
    sei();
    i2c_init();
    temp_humidity_sensor_init();
    nrf24_init();

    if (!lux_sensor_init())
    {
        printf("Initializarea senzorului APDS nereusita!\n");
        while (1);
    }

    while (1)
    {

        uint16_t prox, ch0, ch1;
        float lux;
        int temp = 0, hum = 0;
        int status;

        if (lux_sensor_read_proximity(&prox))
        {
            printf("Prox = %u\t", prox);
        }

        if (lux_sensor_read_raw(&ch0, &ch1))
        {
            printf("Raw: CH0 = %u, CH1 = %u\t", ch0, ch1);
        }

        if (lux_sensor_read_lux(&lux))
        {
            printf("Lux = %u\n", (unsigned int)lux);
        }

        status = temp_humidity_sensor_detect(&temp, &hum);
        if (status)
        {
            temp_humidity_sensor_print(temp, hum, status);
        }
        else
        {
            printf("Eroare la citirea de la DHT22\n");
        }

        
        char msg[32];
        snprintf(msg, sizeof(msg), "Lux:%u Prox:%u Temp:%d Umidit:%d", (unsigned int)lux, prox, temp, hum);
        msg[31] = '\0'; // Asigură terminatorul NULL

        printf("Trimitem mesaj: \"%s\" (%u caractere)\n", msg, (unsigned int)strlen(msg));

        if (!nrf24_send_message(msg))
        {
            printf("TX: transmisie nereusita\n");
        }
        
        _delay_ms(2000);
    }
    return 0;
}

