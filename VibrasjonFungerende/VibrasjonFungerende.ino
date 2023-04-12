//#define EN 23
#define VIB 32
#define ENV 34
int NoiseLevel = 0;
void setup() {
  // put your setup code here, to run once:
  //pinMode(EN, OUTPUT);
  pinMode(VIB, OUTPUT);
  pinMode(ENV, INPUT);
  Serial.begin(115200);

}

void loop() {
  // put your main code here, to run repeatedly:
  //digitalWrite(EN, HIGH);

  NoiseLevel = analogRead(ENV);
  analogWrite(VIB, NoiseLevel/3);
  
  Serial.println(NoiseLevel);
  delay(30);
}
