#!/usr/bin/python
import thread
import lcd
import sys
import Adafruit_DHT
import time
import alarm
import os

timer = 10

def main():

  maxtemp = 25
  maxhumidity = 80

  while True:
    alarmTemp = 0
    humidity, temperature = Adafruit_DHT.read_retry(11, 4)
    print 'Temp: {0:0.1f} C  Humidity: {1:0.1f} %'.format(temperature, humidity)
    lcd.show('Temperat: {0:0.1f} C'.format(temperature),'Humidity: {0:0.1f} %'.format(humidity))
    thread.start_new_thread(addInfo, (humidity, temperature) )

    if humidity > maxhumidity:
	  print("Humedad mas de {0:0.1f}%".format(maxhumidity))
	  alarmTemp = 1


    if temperature > maxtemp:
	  print("Temperatura mas de {0:0.1f} C".format(maxtemp))
	  alarmTemp = 1

    if alarmTemp == 1:
	  alarm.start()
	  timer = timer + 1
	  if timer > 10:
	    thread.start_new_thread(sendemail, () )
	    timer = 0

    time.sleep(10)


def addInfo(humidity, temperature):
   os.system("/usr/bin/curl -k -s http://127.0.0.1/insert/temp/{0:0.1f}/hum/{1:0.1f} > /dev/null".format(temperature, humidity))

def sendemail():
   os.system("/usr/bin/curl -k -s http://127.0.0.1/sendemail > /dev/null")

#thread.start_new_thread(alarm.start, () )


try:
	main()
except KeyboardInterrupt:
	pass
finally:
	alarm.stop()
	lcd.show('Termostato','parado')


