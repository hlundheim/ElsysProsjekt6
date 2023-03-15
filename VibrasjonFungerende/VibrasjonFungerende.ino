#define EN 27
#define VIB 32
#define ENV 25
int NoiseLevel = 0;
void setup() {
  // put your setup code here, to run once:
  pinMode(EN, OUTPUT);
  pinMode(VIB, OUTPUT);
  pinMode(ENV, INPUT);
  Serial.begin(9600);

}

void loop() {
  // put your main code here, to run repeatedly:
  digitalWrite(EN, HIGH);

  NoiseLevel = analogRead(ENV);
  if(NoiseLevel > 200 && NoiseLevel < 400)
  {
    analogWrite(VIB, 20);
  }
  if(NoiseLevel > 400 && NoiseLevel < 600)
  {
    analogWrite(VIB, 40);
  }
  if(NoiseLevel > 600 && NoiseLevel < 800)
  {
    analogWrite(VIB, 60);
  }
  if(NoiseLevel > 800 && NoiseLevel < 1000)
  {
    analogWrite(VIB, 80);
  }
  if(NoiseLevel > 1000 && NoiseLevel < 1200)
  {
    analogWrite(VIB, 100);
  }
  if(NoiseLevel > 1200 && NoiseLevel < 1400)
  {
    analogWrite(VIB, 120);
  }
  if(NoiseLevel > 1400 && NoiseLevel < 1600)
  {
    analogWrite(VIB, 140);
  }
  if(NoiseLevel > 1600 && NoiseLevel < 1800)
  {
    analogWrite(VIB, 160);
  }
  if(NoiseLevel > 1800 && NoiseLevel < 2000)
  {
    analogWrite(VIB, 180);
  }
  
  //Serial.println(NoiseLevel);
}