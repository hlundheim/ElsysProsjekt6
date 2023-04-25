#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <FastLED.h>
#include <HTTPClient.h>        
#include <WiFi.h>  
#include <math.h>
#define ledPin 13
#define numLeds 10
#define VIB 32
#define ENV 34
int noiseLevel = 0;
CRGB leds[numLeds];
Adafruit_MPU6050 mpu;
sensors_event_t a, g, temp;
float prevRead[3]= {0,0,0};
const char* ssid = "OnePlus 5";       
const char* password = "ohanaelsys6"; 
float hype = 0;
int invHypeSens = 50;
const float baseHype = 5;
float biggestHype = baseHype;
float minBrightness = 10;
String effectData = "255,000,255,1,150,110,050,0,0,0";
String currentEffectData = "";
TaskHandle_t wifi;
int color1[3];
int color2[3];
bool multiColor;
bool alternating;
bool altFlag = 0;
bool looping;
int loopPosition = 0;
bool rainbow;
uint8_t rainbowState = 0;
unsigned long previousMillis;
unsigned long currentMillis;


float getHype(sensors_event_t a){
  // øk hype hvis delta hype øker
  float stabRead[3];
  int numRead = 10;
  float delta[3];
  for (int i = 0; i<numRead; i++) {
    mpu.getEvent(&a, &g, &temp); 
    stabRead[0]+=a.acceleration.x;
    stabRead[1]+=a.acceleration.y;
    stabRead[2]+=a.acceleration.z;
  }
  stabRead[0]=stabRead[0]/numRead;
  stabRead[1]=stabRead[1]/numRead;
  stabRead[2]=stabRead[2]/numRead;
  delta[0]=abs(stabRead[0]-prevRead[0]);
  delta[1]=abs(stabRead[1]-prevRead[1]);
  delta[2]=abs(stabRead[2]-prevRead[2]);
  prevRead[0] = stabRead[0];
  prevRead[1] = stabRead[1];
  prevRead[2] = stabRead[2];
  //return abs(sqrt(pow(a.acceleration.x,2) + pow(a.acceleration.y,2)+ pow(a.acceleration.z,2))-9.81)/2 + hype/2;
  for (int i= 0; i<3; i++) {
    
  }
  for (int i= 0; i<3; i++) {
    Serial.println(stabRead[i]);
  }
  for (int i= 0; i<3; i++) {
      Serial.println(delta[i]);
  }
  for (int i= 0; i<3; i++) {
    
  }
  for (int i= 0; i<3; i++) {
    
  }
  for (int i= 0; i<3; i++) {
    
  }
  Serial.println(sqrt(pow(delta[0],2)+pow(delta[1],2)+pow(delta[2],2)));
  return sqrt(pow(delta[0],2)+pow(delta[1],2)+pow(delta[2],2))*2/3+hype/3;
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
  //mpu.setGyroStandby(1,1,1);
  //mpu.setTemperatureStandby(1);
  
  FastLED.addLeds<WS2812, ledPin, GRB>(leds, numLeds);
  //FastLED.setMaxPowerInVoltsAndMilliamps(5, 50);
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
  FastLED.setBrightness(255);
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
  delay(5);
  hype = getHype(a);
  if (hype > biggestHype) {
    biggestHype = hype;
  } else if (hype > baseHype) {
    biggestHype -= 0.01;
  }
  
  if (millis()-previousMillis > 500 && effectData != currentEffectData) {
      currentEffectData = effectData;
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
  
  if(looping) {
    for (int i = 0; i<numLeds;i++) {
      leds[(i+loopPosition) % numLeds] = leds[(i+loopPosition) % numLeds].nscale8(i*255/numLeds);
      Serial.print((i+loopPosition) % numLeds);
    }
    loopPosition++;
    if (loopPosition >= numLeds) {
      loopPosition = 0;
    }
  }
  if(rainbow) {
    for (int i = 0; i<numLeds;i++) {
      leds[i] = CHSV(rainbowState + (i*20),255,255);
    }
    rainbowState++;
  }
  
  //FastLED.setBrightness(minBrightness + 226-(  226*exp( -(hype*(255-minBrightness)/biggestHype)/(  -(225.0/log(1.0/226.0))))  ));
  FastLED.setBrightness(minBrightness + (255-minBrightness)*log((hype*(255-minBrightness)/biggestHype)/invHypeSens + 1)/log((255-minBrightness + 1)/invHypeSens+1));
  FastLED.show();

  //Serial.println(effectData);
  Serial.print(" HYPE:");
  Serial.println(hype);
  Serial.print("noiseLevel ");
  Serial.println(noiseLevel);
  //Serial.println(minBrightness + 226-(  226*exp( -(hype*(255-minBrightness)/biggestHype)/(  -(225.0/log(1.0/226.0))  )   ) ));
  Serial.println(minBrightness + (255-minBrightness)*log((hype*(255-minBrightness)/biggestHype)/invHypeSens + 1)/log((255-minBrightness + 1)/invHypeSens+1));
}
