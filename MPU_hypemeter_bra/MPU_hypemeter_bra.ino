#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <FastLED.h>
#include <HTTPClient.h>        
#include <WiFi.h>  
#define LED_PIN 15
#define NUM_LEDS 10
#define led 2
CRGB leds[NUM_LEDS];
Adafruit_MPU6050 mpu;
const char* ssid = "OnePlus 5";       
const char* password = "ohanaelsys6"; 
float hype;
float biggestHype = 0;
String data_to_send = "";
String band_state = "";
TaskHandle_t wifi;
int color[3];

float getHype(sensors_event_t a){
  return abs(sqrt(pow(a.acceleration.x,2) + pow(a.acceleration.y,2)+ pow(a.acceleration.z,2))-9);
}

void getColor(const String& band_state, int& color){
  String values = band_state;
  String Sr = strtok(values, ",");
  color[0] = Sr.toInt(); 
  String Sg = strtok(NULL, ",");
  color[1] = Sg.toInt(); 
  String Sb = strtok(NULL, ",");
  color[2] = Sb.toInt(); 
}


void setup(void) {
  pinMode(led,OUTPUT);
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

  FastLED.addLeds<WS2812, LED_PIN, GRB>(leds, NUM_LEDS);
  FastLED.setMaxPowerInVoltsAndMilliamps(3, 300);
  FastLED.clear();
  FastLED.show();
  for (int i = 0; i<NUM_LEDS;i++) {
  leds[i] = CRGB(0, 0, 255 );
  }
    xTaskCreatePinnedToCore(
      wifiHandler,   /* Task function. */
      "wifi",     /* name of task. */
      10000,       /* Stack size of task */
      NULL,        /* parameter of the task */
      1,           /* priority of the task */
      &wifi,      /* Task handle to keep track of created task */
      0);          /* pin task to core 0 */   
}

void wifiHandler( void * pvParameters ){
  Serial.print("wifi running on core ");
  Serial.println(xPortGetCoreID());

  for(;;){
      if(WiFi.status()== WL_CONNECTED){                   //Check WiFi connection status  
      HTTPClient http;  
      //Create new client
      data_to_send = "check_LED_status=1";    //If button wasn't pressed we send text: "check_LED_status"
      
      //Begin new connection to website     
      http.begin("https://ohana6.000webhostapp.com/esp32_update.php");   //Indicate the destination webpage 
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");         //Prepare the header
      int response_code = http.POST(data_to_send);                                //Send the POST. This will giveg us a response code Denne tar fakka lang tid
      //If the code is higher than 0, it means we received a response
      if(response_code > 0){
        Serial.println("HTTP code " + String(response_code));                     //Print return code
        if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String response_body = http.getString();                                //Save the data comming from the website
          band_state = response_body;
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(response_body);
                  
        }//End of response_code = 200
      }//END of response_code > 0
      
      else{
       Serial.print("Error sending POST, code: ");
       Serial.println(response_code);
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
  sensors_event_t a, g, temp;
  mpu.getEvent(&a, &g, &temp);
  hype = getHype(a);

  if (hype > biggestHype) {
    biggestHype = hype;
  }
  getColor();
  for (int i = 0; i<NUM_LEDS;i++) {
    leds[i] = CRGB(color[0], color[1], color[2]);
  }

  FastLED.setBrightness(hype*255/biggestHype);
  FastLED.show();

  Serial.print(band_state);
  Serial.print("HYPE:");
  Serial.println(hype);
  delay(50);
}
