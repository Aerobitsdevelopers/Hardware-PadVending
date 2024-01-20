# app.py
from flask import Flask, render_template, send_from_directory, jsonify
import RPi.GPIO as GPIO
import threading
import time
import os
import webbrowser
from mfrc522 import SimpleMFRC522

app = Flask(__name__)

# Set up GPIO
GPIO.setmode(GPIO.BOARD)
motor_pin_1 = 11
motor_pin_2 = 37
motor_pin_3 = 36
tsop_pin = 32
rfid_power_pin = 22

GPIO.setwarnings(False)
GPIO.setup(motor_pin_1, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(motor_pin_2, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(motor_pin_3, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(rfid_power_pin, GPIO.OUT, initial=GPIO.LOW)
GPIO.setup(tsop_pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

reader = SimpleMFRC522()

def enable_rfid_module():
    GPIO.output(rfid_power_pin, GPIO.HIGH)

def disable_rfid_module():
    GPIO.output(rfid_power_pin, GPIO.LOW)
    
    
# Variable to track the display state
display_is_sleeping = False
display_sleep_offset = 0

def tsop_sensor_thread():
	global display_is_sleeping, display_sleep_offset
	while True:
		if GPIO.input(tsop_pin) == GPIO.LOW:
			if display_is_sleeping:
				os.system("xset dpms force on")
				display_is_sleeping = False
				display_sleep_offset = 0
				time.sleep(1)
		else:
			if not display_is_sleeping and display_sleep_offset > 5:
				os.system("xset dpms force off")
				disable_rfid_module()
				display_is_sleeping = True
			elif display_sleep_offset <= 5:
				display_sleep_offset = display_sleep_offset + 1
				time.sleep(1)

# Create and start the TSOP sensor thread
tsop_thread = threading.Thread(target=tsop_sensor_thread)
tsop_thread.start()

def read_rfid():
	try:
		# Read the RFID tag
		id, rfid_text = reader.read()
		return id, rfid_text
	except Exception as e:
		print(f"Error reading RFID: {e}")
		return None, None
	
@app.route("/")
def index():
    return render_template('index.html')
    
@app.route("/rfid")
def rfid():
    return render_template('rfid.html')
    
@app.route("/pay")
def pay():
    return render_template('pay.html')


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
		# Enable RFID module before scanning
		enable_rfid_module()

		while id is None:
			id, rfid_text = read_rfid()
			time.sleep(0.1)
		print(id, rfid_text)

		# Disable RFID module after scanning
		disable_rfid_module()
		# Return the id and rfid_text as JSON
		return jsonify(id=id, rfid_text=rfid_text)

	except Exception as e:
		# Disable RFID module in case of an error
		disable_rfid_module()
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
