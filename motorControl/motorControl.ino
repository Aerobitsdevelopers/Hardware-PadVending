#include <Wire.h>

const int stepPin1 = 2;  // Connect this to the step pin of Motor 1
const int dirPin1 = 3;   // Connect this to the direction pin of Motor 1

const int stepPin2 = 4;  // Connect this to the step pin of Motor 2
const int dirPin2 = 5;   // Connect this to the direction pin of Motor 2

const int stepPin3 = 6;  // Connect this to the step pin of Motor 3
const int dirPin3 = 7;   // Connect this to the direction pin of Motor 3

void setup() {
  Serial.begin(9600);
  Wire.begin(8);                // join I2C bus with address #8
  Wire.onReceive(receiveEvent);  // register event

  pinMode(stepPin1, OUTPUT);
  pinMode(dirPin1, OUTPUT);

  pinMode(stepPin2, OUTPUT);
  pinMode(dirPin2, OUTPUT);

  pinMode(stepPin3, OUTPUT);
  pinMode(dirPin3, OUTPUT);
}

void loop() {
  // Your motor control code can go here
}

void receiveEvent() {
  // Receive motor control commands from Raspberry Pi
  while (Wire.available()) {
    int motorNumber = Wire.read();
    int motorValue = Wire.read();
    int steps = motorValue * 1000;

    // Control the corresponding motor based on received commands
    switch (motorNumber) {
      case 1:
        moveMotor(stepPin1, dirPin1, steps);
        break;
      case 2:
        moveMotor(stepPin2, dirPin2, steps);
        break;
      case 3:
        moveMotor(stepPin3, dirPin3, steps);
        break;
      // Add more cases if you have additional motors
    }
  }
}

void moveMotor(int stepPin, int dirPin, int steps) {
  digitalWrite(dirPin, (steps > 0) ? HIGH : LOW);  // Set the direction
  steps = abs(steps);
  
  // Send pulses to the step pin to move the motor
  for (int i = 0; i < steps; i++) {
    digitalWrite(stepPin, HIGH);
    delayMicroseconds(1000);  // Adjust delay based on your motor's requirements
    digitalWrite(stepPin, LOW);
    delayMicroseconds(1000);  // Adjust delay based on your motor's requirements
  }
}
