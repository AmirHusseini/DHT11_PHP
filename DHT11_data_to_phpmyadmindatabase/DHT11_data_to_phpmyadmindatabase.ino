
#include "DHT.h"
#include <SPI.h>
#include <WiFiEspClient.h>
#include <SoftwareSerial.h>
#include <WiFiEsp.h>

//your wifi ssid and password
char ssid[] = ""; // your network SSID (name)
char pass[] = ""; // your network password

//Define your pin on arduino mega for DHT sensor
#define DHTPIN 4  
#define DHTTYPE DHT11

DHT dht(DHTPIN,DHTTYPE);


float humidityData;
float temperatureData;

//Your server ip address
char server[] = "";

//Client server for wifi 
WiFiEspClient client; 
int status = WL_IDLE_STATUS; // the Wifi radio's status

SoftwareSerial soft(10,11); // RX, TX your esp8266 wifi shield is connected to arduino mega 

/* Setup for Ethernet and RFID */
void setup() {
  // initialize dht sensor
  dht.begin();
  
  // initialize serial for debugging
  Serial.begin(9600);
  
  // initialize serial for ESP module
  soft.begin(9600);
  
  // initialize ESP module
  WiFi.init(&soft);

  // attempt to connect to WiFi network
  while ( status != WL_CONNECTED) {
    Serial.print("Attempting to connect to WPA SSID: ");
    Serial.println(ssid);
    
    // Connect to WPA/WPA2 network
    status = WiFi.begin(ssid, pass);
  }
  // you're connected now, so print out the data
  Serial.println("You're connected to the network");
  
  Serial.println();
}
//------------------------------------------------------------------------------


/* Infinite Loop */
void loop(){
  
  humidityData = dht.readHumidity();
  temperatureData = dht.readTemperature(); 

  //Sending the information to the database
  Sending_To_phpmyadmindatabase(); 
  
  //Wait until all outgoing characters in buffer have been sent and disconnect from the server
  client.flush();
  client.stop();
  
  delay(300000); // interval 5 minutes
    
  
}

    //CONNECTING WITH MYSQL
  void Sending_To_phpmyadmindatabase()   
 {
   if (client.connect(server, 80)) {
    Serial.println("Connected to Database");
    
    // Make a HTTP request:
    Serial.print("GET /PHPDatabaseDht11/dht.php?humidity=");
    client.print("GET /PHPDatabaseDht11/dht.php?humidity=");     //YOUR URL
    Serial.println(humidityData);
    client.print(humidityData);
    client.print("&temperature=");
    Serial.println("&temperature=");
    client.print(temperatureData);
    Serial.println(temperatureData);
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: ");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
 }
