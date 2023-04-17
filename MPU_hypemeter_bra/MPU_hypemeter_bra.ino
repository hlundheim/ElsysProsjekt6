#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <FastLED.h>
#include <HTTPClient.h>        
#include <WiFi.h>  
#define ledPin 13
#define numLeds 10
#define VIB 32
#define ENV 34
int noiseLevel = 0;
CRGB leds[numLeds];
Adafruit_MPU6050 mpu;
const char* ssid = "OnePlus 5";       
const char* password = "ohanaelsys6"; 
float hype = 0;
const float baseHype = 5;
float biggestHype = baseHype;
String dataToSend = "";
String effectData = "255,000,255,1,150,110,050,0,0,0";
TaskHandle_t wifi;
int color1[3];
int color2[3];
bool multiColor;
bool alternating;
bool altFlag = 0;
bool looping;
bool rainbow;
unsigned long previousMillis;
unsigned long currentMillis;


float getHype(sensors_event_t a){
  return abs(sqrt(pow(a.acceleration.x,2) + pow(a.acceleration.y,2)+ pow(a.acceleration.z,2))-9.81)/2 + hype/2;
}

void getColor(){
  String red1 = effectData.substring(0,3);
  String green1 = effectData.substring(4,7);
  String blue1 = effectData.substring(8,11);
  multiColor = effectData.substring(12,13).toInt();
  String red2 = effectData.substring(14,17);
  String green2 = effectData.substring(18,21);
  String blue2 = effectData.substring(22,25);
  alternating = effectData.substring(26,27).toInt();
  rainbow = effectData.substring(28,29).toInt();
  if(altFlag == 0) {
    color1[0] = red1.toInt(); 
    color1[1] = green1.toInt(); 
    color1[2] = blue1.toInt(); 
    color2[0] = red2.toInt(); 
    color2[1] = green2.toInt(); 
    color2[2] = blue2.toInt();
    if(alternating) {
          altFlag = 1;
    }
  } else {
      color2[0] = red1.toInt(); 
      color2[1] = green1.toInt(); 
      color2[2] = blue1.toInt(); 
      color1[0] = red2.toInt(); 
      color1[1] = green2.toInt(); 
      color1[2] = blue2.toInt(); 
      altFlag = 0;
  }
}

void setup(void) {
  pinMode(VIB, OUTPUT);
  pinMode(ENV, INPUT);

  Serial.begin(115200);
  Serial.println("ESP test!");

  int connectCounter = 0;
  WiFi.begin(ssid, password);             
  Serial.print("Connecting...");
  while (WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
    connectCounter++;
    if (connectCounter > 10) {
      ESP.restart();
    }
  }
  Serial.print("Connected, my IP: ");
  Serial.println(WiFi.localIP());
  
  
  if (!mpu.begin()) {
    Serial.println("Failed to find MPU6050 chip");
    while (1) {
      delay(10);
    }
  }
  
  Serial.println("MPU funker");
  Serial.println("");
  
  FastLED.addLeds<WS2812, ledPin, GRB>(leds, numLeds);
  FastLED.setMaxPowerInVoltsAndMilliamps(5, 300);
  FastLED.clear();
  FastLED.show();

    xTaskCreatePinnedToCore(
      wifiHandler,   // Task function. 
      "wifi",     // name of task. 
      10000,       // Stack size of task 
      NULL,        // parameter of the task 
      1,           // priority of the task 
      &wifi,      // Task handle to keep track of created task 
      0);          // pin task to core 0 
      
  //Wire.setTimeout(3000); //hmmmmmmm
  delay(1000);
  previousMillis = millis();
}

void wifiHandler( void * pvParameters ){
  Serial.print("wifi running on core ");
  Serial.println(xPortGetCoreID());

  for(;;){
      if(WiFi.status()== WL_CONNECTED){                
      HTTPClient http;  
      dataRequest = "update_band";   
          
      http.begin("https://ohana6.000webhostapp.com/esp32_update.php");
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");  
      int responseCode = http.POST(dataRequest);                
      if(responseCode > 0){
        Serial.println("HTTP code " + String(responseCode));                    
        if(responseCode == 200){                                                 
          String responseBody = http.getString();                               
          effectData = responseBody;
          Serial.print("Server reply: ");                           
          Serial.println(responseBody);    
        }
      } else{
       Serial.print("Error sending POST, code: ");
       Serial.println(responseCode);
      }
      http.end();                                                               
    } else{
      Serial.println("WIFI connection error");
      delay(500);
    }
    delay(500);
  } 
}

void loop() {
  noiseLevel = analogRead(ENV);
  analogWrite(VIB, noiseLevel/3);
  
  sensors_event_t a, g, temp;
  mpu.getEvent(&a, &g, &temp); 
  delay(30);
  hype = getHype(a);

  if (hype > biggestHype) {
    biggestHype = hype;
  } else if (hype > baseHype) {
    biggestHype -= 0.01;
  }
  
  if (millis()-previousMillis > 500) {
      getColor();
      previousMillis = millis();  
  }
 
  for (int i = 0; i<numLeds;i++) {
    leds[i] = CRGB(color1[0], color1[1], color1[2]);
  }
  if(multiColor) {
    for (int i = 0; i<numLeds;i=i+2) {
    leds[i] = CRGB(color2[0], color2[1], color2[2]);
    }
  }

  FastLED.setBrightness(30 + hype*225/biggestHype);
  FastLED.show();

  //Serial.println(effectData);
  Serial.print(" HYPE:");
  Serial.println(hype);
  // Serial.print("Acceleration X: ");
  // Serial.print(a.acceleration.x);
  // Serial.print(", Y: ");
  // Serial.print(a.acceleration.y);
  // Serial.print(", Z: ");
  // Serial.print(a.acceleration.z);
  // Serial.println(" m/s^2");
  Serial.print("noiseLevel ");
  Serial.println(noiseLevel);
}
