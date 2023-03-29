#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <FastLED.h>
#include <HTTPClient.h>        
#include <WiFi.h>  
#define ledPin 15
#define numLeds 10
#define EN 33
#define VIB 32
#define ENV 34
int noiseLevel = 0;
CRGB leds[numLeds];
Adafruit_MPU6050 mpu;
const char* ssid = "OnePlus 5";       
const char* password = "ohanaelsys6"; 
float hype;
float biggestHype = 5;
String dataToSend = "";
String effectData = "255,000,255,1,150,110,050,0,0,0";
TaskHandle_t wifi;
int color[3];
int color2[3];
bool multiColor;
bool alternating;
bool altFlag = 0;
bool looping;
bool rainbow;
unsigned long previousMillis;
unsigned long currentMillis;


float getHype(sensors_event_t a){
  return abs(sqrt(pow(a.acceleration.x,2) + pow(a.acceleration.y,2)+ pow(a.acceleration.z,2))-9)/2 + hype/2;
}

void getColor(){
  String red1 = effectData.substring(0,2);
  String green1 = effectData.substring(4,6);
  String blue1 = effectData.substring(8,10);
  multiColor = effectData.substring(12,12).toInt();
  String red2 = effectData.substring(14,16);
  String green2 = effectData.substring(18,20);
  String blue2 = effectData.substring(22,24);
  alternating = effectData.substring(26,26).toInt();
  rainbow = effectData.substring(28,28).toInt();
  if(altFlag == 0) {
    color[0] = red1.toInt(); 
    color[1] = green1.toInt(); 
    color[2] = blue1.toInt(); 
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
      color[0] = red2.toInt(); 
      color[1] = green2.toInt(); 
      color[2] = blue2.toInt(); 
      altFlag = 0;
  }

}

void setup(void) {
  pinMode(EN, OUTPUT);
  pinMode(VIB, OUTPUT);
  pinMode(ENV, INPUT);
  digitalWrite(EN, HIGH);

  Serial.begin(115200);
  Serial.println("ESP test!");
  
  WiFi.begin(ssid, password);             //Start wifi connection
  Serial.print("Connecting...");
  while (WiFi.status() != WL_CONNECTED) { //Check for the connection
    delay(500);
    Serial.print(".");
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
  FastLED.setMaxPowerInVoltsAndMilliamps(3, 300);
  FastLED.clear();
  FastLED.show();
  // for (int i = 0; i<numLeds;i++) {
  // leds[i] = CRGB(0, 0, 255 );
  // }
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
      if(WiFi.status()== WL_CONNECTED){                   //Check WiFi connection status  
      HTTPClient http;  
      //Create new client
      dataToSend = "check_LED_status=1";    //If button wasn't pressed we send text: "check_LED_status"
      
      //Begin new connection to website     
      http.begin("https://ohana6.000webhostapp.com/esp32_update.php");   //Indicate the destination webpage 
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");         //Prepare the header
      int responseCode = http.POST(dataToSend);                                //Send the POST. This will giveg us a response code Denne tar fakka lang tid
      //If the code is higher than 0, it means we received a response
      if(responseCode > 0){
        Serial.println("HTTP code " + String(responseCode));                     //Print return code
        if(responseCode == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String responseBody = http.getString();                                //Save the data comming from the website
          effectData = responseBody;
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(responseBody);
                  
        }//End of responseCode = 200
      }//END of responseCode > 0
      
      else{
       Serial.print("Error sending POST, code: ");
       Serial.println(responseCode);
      }
      http.end();                                                                 //End the connection
    }//END of WIFI connected
    else{
      Serial.println("WIFI connection error");
      delay(500);
    }
    delay(500);
  } 
}


void loop() {
  noiseLevel = analogRead(ENV);
  analogWrite(VIB, noiseLevel/5);
  
  sensors_event_t a, g, temp;
  mpu.getEvent(&a, &g, &temp); //Prøv ut å fikse litt greier her kanskje add større delay eller noe
  delay(30);
  hype = getHype(a);

  if (hype > biggestHype) {
    biggestHype = hype;
  }
  if (millis()-previousMillis > 500) {
      getColor();
      previousMillis = millis();  
  }
  if(rainbow) {
    
  }
  for (int i = 0; i<numLeds;i=i+2) {
    leds[i] = CRGB(color[0], color[1], color[2]);
  }
  if(multiColor) {
    for (int i = 1; i<numLeds-1;i=i+2) {
    leds[i] = CRGB(color2[0], color2[1], color2[2]);
    }
  }

  FastLED.setBrightness(10 + hype*245/biggestHype);
  FastLED.show();

  Serial.print(effectData);
  Serial.print(" HYPE:");
  Serial.println(hype);
  // Serial.print("Acceleration X: ");
  // Serial.print(a.acceleration.x);
  // Serial.print(", Y: ");
  // Serial.print(a.acceleration.y);
  // Serial.print(", Z: ");
  // Serial.print(a.acceleration.z);
  // Serial.println(" m/s^2");
  Serial.print("noiseLevel");
  Serial.println(noiseLevel);
}
