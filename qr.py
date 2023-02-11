#!/usr/bin/env python3
#sudo chown -R pi:pi /var/www/
#sudo apt-get install apache2 php7.3
#sudo a2enmod php7.3
#sudo su
#mysql -u root
#ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';

#startup seq
#sudo nano /etc/rc.local
#sudo python3 /home/pi/qr.py &
#reboot

import serial
import requests
import mysql.connector

#port = "/dev/ttyAMA0"  # Raspberry Pi 2
port = "/dev/ttyS0"    # Raspberry Pi 3

ser = serial.Serial(port, baudrate = 9600, timeout = 0.5)
while True:
    data = ser.readline()
    output = data.decode("utf-8")
    output.strip()
    if (len(output) > 0):
        print(output)
        data = {'scan':output}
        status = requests.get('http://iinventori/scan.php', params=data)
        print(status.text)
    
