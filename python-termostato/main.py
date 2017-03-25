#!/usr/bin/python
import thread
import lcd
import sys
import Adafruit_DHT
import time
import alarm
import os

timer = 10
maxtemp = 23
maxhumidity = 80
humidity = 0
temperature = 0

def main():

  global timer
  global temperature
  global humidity
  global maxtemp
  global maxhumidity

  thread.start_new_thread(checktemp, () )
  thread.start_new_thread(addInfo, () )

  while True:
    print("Start While")
    alarmTemp = 0

    if humidity > maxhumidity:
	  alarmTemp = 1
          print 'Alarma Humedad: {0:0.1f} %'.format(humidity)

    if temperature > maxtemp:
	  alarmTemp = 1
          print 'Alarma Temperatura: {0:0.1f} C'.format(temperature)

    if alarmTemp == 1:
	  print("Alarma auditiva")
  	  alarm.start()
	  timer = ( timer + 1 )
	  if timer > 10:
	    print("Enviando mail")
	    thread.start_new_thread(sendemail, () )
	    timer = 0

    time.sleep(10)


def addInfo():
    global temperature
    global humidity
    while True:
        time.sleep(10)
        os.system("/usr/bin/curl -k -s http://127.0.0.1/insert/temp/{0:0.1f}/hum/{1:0.1f} > /dev/null".format(temperature, humidity))

def sendemail():
   time.sleep(10)
   os.system("/usr/bin/curl -k -s http://127.0.0.1/sendemail > /dev/null")

def checktemp():
    while True:
        global humidity
        global temperature
        humidity, temperature = Adafruit_DHT.read_retry(11, 4)
        print 'Temp: {0:0.1f} C  Humidity: {1:0.1f} %'.format(temperature, humidity)
        lcd.show('Temperat: {0:0.1f} C'.format(temperature),'Humidity: {0:0.1f} %'.format(humidity))
        time.sleep(0.5)

#Start Main
try:
	main()
except KeyboardInterrupt:
	pass
finally:
	alarm.stop()
	lcd.show('Termostato','parado')


