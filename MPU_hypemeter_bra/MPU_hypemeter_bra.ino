#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <FastLED.h>
#define LED_PIN 15
#define NUM_LEDS 10
//#define led 2

CRGB leds[NUM_LEDS];
Adafruit_MPU6050 mpu;
float hype;
float biggestHype = 0;

void setup(void) {
  //pinMode(led,OUTPUT);
  Serial.begin(115200);
  while (!Serial)
    delay(10); // will pause Zero, Leonardo, etc until serial console opens
    
  Serial.println("Hypemeter test!");

  // Try to initialize!
  if (!mpu.begin()) {
    Serial.println("Failed to find MPU6050 chip");
    while (1) {
      delay(10);
    }
  }
  Serial.println("aaah lets go da");

  Serial.println("");
  delay(100);

  FastLED.addLeds<WS2812, LED_PIN, GRB>(leds, NUM_LEDS);
  FastLED.setMaxPowerInVoltsAndMilliamps(3, 300);
  FastLED.clear();
  FastLED.show();
  for (int i = 0; i<NUM_LEDS;i++) {
 
  leds[i] = CRGB(0, 0, 255 );
  }
}

float getHype(sensors_event_t a){
  return abs(sqrt(pow(a.acceleration.x,2) + pow(a.acceleration.y,2)+ pow(a.acceleration.z,2))-9);
}

void loop() {
  /* Get new sensor events with the readings */
  sensors_event_t a, g, temp;
  mpu.getEvent(&a, &g, &temp);
  hype = getHype(a);
  if (hype > biggestHype) {
    biggestHype = hype;
  }
  biggestHype;
  
  FastLED.setBrightness(hype*255/biggestHype);
  FastLED.show();
  
  /* Print out the values */
  Serial.print("Acceleration X: ");
  Serial.print(a.acceleration.x);
  Serial.print(", Y: ");
  Serial.print(a.acceleration.y);
  Serial.print(", Z: ");
  Serial.print(a.acceleration.z);
  Serial.println(" m/s^2");

  Serial.print("HYPE:");
  Serial.println(hype);
  delay(30);
}
