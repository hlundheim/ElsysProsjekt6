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
CRGB leds[numLeds];
Adafruit_MPU6050 mpu;
sensors_event_t a, g, temp;
const char* ssid = "Pixel 7";       
const char* password = "ohanaelsys6"; 
TaskHandle_t wifi;
float noiseLevel = 0;
float highestNoise = 1000;
int noiseFloor = 140;
float prevRead[3]= {0,0,0};
float hype = 0;
int invHypeSens = 70;
const float baseHype = 5;
float biggestHype = baseHype;
float minBrightness = 10;
String effectData = "255,000,255,1,150,110,050,0,0,0";
String currentEffectData = "";
int color1[3];
int color2[3];
bool multiColor;
bool alternating;
bool altFlag = 0;
bool looping;
int loopPosition = 0;
bool rainbow;
int rainbowState = 0;
int rainbowCounter = 0;
unsigned long previousMillis;
unsigned long currentMillis;

float getHype(sensors_event_t a){
  float stabRead[3];
  int numRead = 15;
  float delta[3];
  for (int i = 0; i<numRead; i++) {
    mpu.getEvent(&a, &g, &temp); 
    stabRead[0]+=a.acceleration.x;
    stabRead[1]+=a.acceleration.y;
    stabRead[2]+=a.acceleration.z;
  }
  for (int i= 0; i<3; i++) {
    stabRead[i]=stabRead[i]/numRead;
  }
  for (int i= 0; i<3; i++) {
     delta[i]=abs(stabRead[i]-prevRead[i]);
  }
  for (int i= 0; i<3; i++) {
      prevRead[i] = stabRead[i];
  }
  return pow(delta[0],2)+pow(delta[1],2)+pow(delta[2],2)*2/3+hype/3;
}

void getColor(){
  String red1 = currentEffectData.substring(0,3);
  String green1 = currentEffectData.substring(4,7);
  String blue1 = currentEffectData.substring(8,11);
  multiColor = currentEffectData.substring(12,13).toInt();
  String red2 = currentEffectData.substring(14,17);
  String green2 = currentEffectData.substring(18,21);
  String blue2 = currentEffectData.substring(22,25);
  alternating = currentEffectData.substring(26,27).toInt();
  looping = currentEffectData.substring(28,29).toInt();
  rainbow = currentEffectData.substring(30,31).toInt();
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
  Serial.println("ESP start");
  int connectCounter = 0;
  WiFi.begin(ssid, password);             
  Serial.print("Connecting wifi...");
  while (WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
    connectCounter++;
    if (connectCounter > 30) {
      ESP.restart();
    }
  }
  Serial.print("Connected");
  if (!mpu.begin()) {
    Serial.println("Failed to find MPU6050 chip");
    delay(500);
    ESP.restart();
  }
  FastLED.addLeds<WS2812, ledPin, GRB>(leds, numLeds);
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
      
  previousMillis = millis();
}

void wifiHandler( void * pvParameters ){
  Serial.print("wifi running on core ");
  Serial.println(xPortGetCoreID());
  for(;;){
    if(WiFi.status()== WL_CONNECTED){                
      HTTPClient http;  
      String dataRequest = "update_band";   
      http.begin("https://ohana6.000webhostapp.com/esp32_update.php");
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");  
      int responseCode = http.POST(dataRequest);                
      if(responseCode > 0){
        Serial.println("HTTP code " + String(responseCode));                    
        if(responseCode == 200){                                                 
          String responseBody = http.getString(); 
          Serial.print("Server reply: ");                           
          Serial.println(responseBody);                                
          effectData = responseBody;
        }
      } else{
        Serial.print("Error sending POST, code: ");
        Serial.println(responseCode);
        ESP.restart();
      }
    http.end();                                                     
    } else{
      Serial.println("WIFI connection error"); 
      delay(500);
      ESP.restart();
    }
    delay(500);
  } 
}

void loop() {
  if (millis()-previousMillis > 50) {
    noiseLevel = analogRead(ENV);
    if (noiseLevel > highestNoise) {
      highestNoise = noiseLevel;
    }
    if(highestNoise > 300) {
      highestNoise = highestNoise *98/100;
    }
    if(noiseLevel > 1) {
       analogWrite(VIB, noiseFloor + noiseLevel/highestNoise*(255-noiseFloor));
    } else {
      analogWrite(VIB, 0);
    }
  }
  
  hype = getHype(a);
  if (hype > biggestHype) {
    biggestHype = hype;
  } else if (hype > baseHype) {
    biggestHype = biggestHype*99/100;
  }
  
  if ((millis()-previousMillis > 500) && ((effectData != currentEffectData) || alternating)) {
    currentEffectData = effectData;
    getColor();
    previousMillis = millis();  
  }
  if (!rainbow){
    for (int i = 0; i<numLeds;i++) {
      leds[i] = CRGB(color1[0], color1[1], color1[2]);
    }
    if(multiColor) {
        for (int i = 0; i<numLeds;i=i+2) {
          leds[i] = CRGB(color2[0], color2[1], color2[2]);
        }
    }
    if(looping) {
      for (int i = 0; i<numLeds;i++) {
        leds[(i+loopPosition) % numLeds] = leds[(i+loopPosition) % numLeds].nscale8(100+i*155/numLeds);
      }
      loopPosition++;
      if (loopPosition >= numLeds) {
        loopPosition = 0;
      }
    }
  } else { 
    for (int i = 0; i<numLeds;i++) {
      int ledPlacement = (i+rainbowCounter)%numLeds;
      leds[ledPlacement] += CRGB((rainbowState%3==0)*6*i,(rainbowState%3==1)*6*i,(rainbowState%3==2)*6*i);
    }
    for (int i = 0; i<numLeds;i++) {
      int ledPlacement = (i+rainbowCounter)%numLeds;
      leds[ledPlacement] -= CRGB((rainbowState%3==1)*6*i,(rainbowState%3==2)*6*i,(rainbowState%3==0)*6*i);
    }
    if(rainbowCounter % 10 == 0) {
      rainbowState++;
    }
    rainbowCounter++; 
  }
  
  FastLED.setBrightness(minBrightness + (255-minBrightness)*log((hype*(255-minBrightness)/biggestHype)/invHypeSens + 1)/log((255-minBrightness + 1)/invHypeSens+1));
  FastLED.show();
  //Serial.println(effectData);
  Serial.print(" HYPE:");
  Serial.println(hype);
  Serial.print("noiseLevel ");
  Serial.println(noiseLevel);
  //Serial.println(highestNoise);
  Serial.println(noiseFloor + noiseLevel/highestNoise*(255-noiseFloor));
  //Serial.println(biggestHype);
  //Serial.println(minBrightness + (255-minBrightness)*log((hype*(255-minBrightness)/biggestHype)/invHypeSens + 1)/log((255-minBrightness + 1)/invHypeSens+1));
  delay(10);
}
