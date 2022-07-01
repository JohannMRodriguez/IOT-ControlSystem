#include <WiFiManager.h>
#include <WiFi.h>
#include <strings_en.h>
#include <WiFiClient.h>
#include <WebServer.h>
#include <HTTPClient.h>

#include <DHT.h>
#include <DHT_U.h>

#define DHTpin 5 //defino el pin GPIO5 de la NodeMCU como la entrada digital para el sensor
#define DHTTYPE DHT11

DHT dht(DHTpin, DHTTYPE);

String dispositivo = "NodeMCU"; //siempre se enviaran los datos desde de la NodeMCU

//creamos los datos que almacenan las mediciones realizadas por el sensor
float temperatura;
float humedad;

//variable para actuar 
int motor;

//Para usar en la web
String protocolo="http://";
String host="iotpagina3.000webhostapp.com";
String recurso="/paginaPrincipal/recibir.php";
int port = 80;

String url = protocolo + host + recurso;

void setup() {
   pinMode(19, OUTPUT);
  
   // ponemos toda la parte de "WifiManager - Basic" para la conexion con la red
    WiFi.mode(WIFI_STA); // explicitly set mode, esp defaults to STA+AP

    // put your setup code here, to run once:
    Serial.begin(115200);
    
    // WiFi.mode(WiFi_STA); // it is a good practice to make sure your code sets wifi mode how you want it.

    //WiFiManager, Local intialization. Once its business is done, there is no need to keep it around
    WiFiManager wm;

    //reset settings - wipe credentials for testing
    //wm.resetSettings();

    // Automatically connect using saved credentials,
    // if connection fails, it starts an access point with the specified name ( "AutoConnectAP"),
    // if empty will auto generate SSID, if password is blank it will be anonymous AP (wm.autoConnect())
    // then goes into a blocking loop awaiting configuration and will return success result

    bool res;
    // res = wm.autoConnect(); // auto generated AP name from chipid
    // res = wm.autoConnect("AutoConnectAP"); // anonymous ap
    res = wm.autoConnect("NodeMCU ESP32S","passwordESP32"); // password protected ap

    if(!res) {
        Serial.println("Failed to connect");
        // ESP.restart();
    } 
    else {
        //if you get here you have connected to the WiFi    
        Serial.println("connected...yeey :)");
    }

    dht.begin();
}

void loop() {
  temperatura = dht.readTemperature();
  humedad = dht.readHumidity();

  String postData = "dispositivo="+dispositivo+"&temperatura="+String(temperatura)+"&humedad="+String(humedad)+"&motor="+String(motor);
  
  WiFiClient client;
  HTTPClient http; //Creamos el objeto del tipo HTTPClient
  http.begin(client,url); //Inicializamos el objeto con la URL
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  
  int httpCode = http.POST(postData);
  String respuesta=http.getString();

  Serial.println("Respuesta del Servidor");
  Serial.println(httpCode);
  Serial.println(respuesta);
  Serial.println("-----------------------------------------------");

  //trabajamos sobre el valor de los actuadores
  int ini=respuesta.indexOf(":"); //busca la posicion del primer :
  int fin=respuesta.indexOf("}", ini);//busca la posicion de la coma, comenzando desde la posicion del ":"   //Se termina la comunicación
  motor=respuesta.substring(ini+1, fin).toInt();
  
  delay(200);  
  http.end();
  
  Serial.println("Respuesta de las variables");
  Serial.print("Variable Motor:");
  Serial.println(motor);
  Serial.println("-----------------------------------------------");

  if (motor){digitalWrite(19, HIGH);}
  else{digitalWrite(19, LOW);}
  
  delay(3000);
}
