# app.py
from flask import Flask, render_template, send_from_directory, jsonify
import RPi.GPIO as GPIO
from gpiozero import DistanceSensor
import time
import os
import webbrowser
from mfrc522 import SimpleMFRC522
import threading

app = Flask(__name__)

# Set up GPIO
GPIO.setmode(GPIO.BCM)
motor_pin_1 = 17
motor_pin_2 = 26
motor_pin_3 = 16
ultrasonic = DistanceSensor(echo=12, trigger=4, threshold_distance=0.5)

GPIO.setwarnings(False)
GPIO.setup(motor_pin_1, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(motor_pin_2, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(motor_pin_3, GPIO.OUT, initial=GPIO.LOW)

reader = SimpleMFRC522()

def ultrasonic_thread():
	while True:
		ultrasonic.wait_for_in_range()
		os.system("xset dpms force on")
		
		ultrasonic.wait_for_out_of_range()
		last_out_of_range_time = time.time()

		while time.time() - last_out_of_range_time < 5:
			if ultrasonic.distance < ultrasonic.threshold_distance:
				last_out_of_range_time = time.time()
			time.sleep(0.1)
		
		os.system("xset dpms force off")
	    
ultrasonic_thread = threading.Thread(target=ultrasonic_thread)
ultrasonic_thread.start()
	
@app.route("/")
def index():
    return render_template('index.html')
    
@app.route("/rfid")
def rfid():
    return render_template('rfid.html')
    
@app.route("/pay")
def pay():
    return render_template('pay.html')

@app.route("/outofstock")
def out_of_stock():
    return render_template('outofstock.html')


@app.route("/css/<path:filename>")
def serve_css(filename):
    css_dir = os.path.join(app.root_path, 'css')
    return send_from_directory(css_dir, filename)

@app.route("/js/<path:filename>")
def serve_js(filename):
    js_dir = os.path.join(app.root_path, 'js')
    return send_from_directory(js_dir, filename)
    
@app.route("/scanRFID")
def scan_RFID():
	try:
		print("Waiting for RFID scan...")
		id, rfid_text = None, None

		while id is None:
			id, rfid_text = read_rfid()
			time.sleep(0.1)
		print(id, rfid_text)

		# Return the id and rfid_text as JSON
		return jsonify(id=id, rfid_text=rfid_text)

	except Exception as e:
		return jsonify(error=str(e))
		
@app.route("/controlMotor1")
def control_motor_1():
    # Turn on the motor for 2 seconds as an example
    GPIO.output(motor_pin_1, GPIO.HIGH)
    time.sleep(3)
    GPIO.output(motor_pin_1, GPIO.LOW)
    return "Motor 1 controlled"
    
@app.route("/controlMotor2")
def control_motor_2():
    # Turn on the motor for 2 seconds as an example
    GPIO.output(motor_pin_2, GPIO.HIGH)
    time.sleep(3)
    GPIO.output(motor_pin_2, GPIO.LOW)
    return "Motor 2 controlled"
    
@app.route("/controlMotor3")
def control_motor_3():
    # Turn on the motor for 2 seconds as an example
    GPIO.output(motor_pin_3, GPIO.HIGH)
    time.sleep(3)
    GPIO.output(motor_pin_3, GPIO.LOW)
    return "Motor 3 controlled"

if __name__ == "__main__":
	webbrowser.open('http://0.0.0.0:5000', new=1, autoraise=True)
	app.run(debug=False, host="0.0.0.0", port=5000)
