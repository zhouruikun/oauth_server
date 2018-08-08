<?php

namespace App\Http\Controllers;
use Log;
use Bluerhinos\phpMQTT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class DeviceController extends Controller
{
    //
    public function getDevice(Request $request)
    {
        Log::info($request);
        $data= $request->getContent();
        $data = json_decode($data);

        switch ($data->header->namespace)
        {
            case 'AliGenie.Iot.Device.Discovery':
                $str = '
                   {
                  "header":{
                      "namespace":"AliGenie.Iot.Device.Discovery",
                      "name":"DiscoveryDevicesResponse",
                      "messageId":"%s",
                      "payLoadVersion":1
                   },
                   "payload":{
                      "devices":[{
                      "deviceId":"34ea34cf2e63",
                      "deviceName":"light1",
                      "deviceType":"light",
                      "zone":"123",          
                      "brand":"345",
                      "model":"567",     
                      "icon":"https://tmjl.zhoukuniyc.top/image/1.png",
                      "properties":[{
                        "name":"color",
                        "value":"Red"
                       }],
                      "actions":[
                        "TurnOn",
                        "TurnOff",
                        "SetBrightness",       
                        "AdjustBrightness",     
                        "SetTemperature",
                        "Query"          
                     ],
                      "extensions":{
                         "extension1":"1",
                         "extension2":"1"
                      }
                     }]
                   }
                }
                ';
                $result = sprintf($str,$data->header->messageId);

            case  'AliGenie.Iot.Device.Control':
                $str = '｛
                          "header":{
                              "namespace":"AliGenie.Iot.Device.Control",
                              "name":"TurnOnResponse",
                              "messageId":"%s",
                              "payLoadVersion":1
                           },
                           "payload":{
                              "deviceId":"%s"
                            }
                         ｝';
                $this->turnOn();
                $result = sprintf($str,$data->header->messageId,$data->payload->deviceId);
        }
          $status = 200;
          $type = 'application/json';
          $respo=(new  Response($result,$status))->header('Content-Type',$type);
          Log::info($respo);
          return $respo;
    }
    public function turnOn(){
        $server = "106.14.226.150";     // change if necessary
        $port = 1883;                     // change if necessary
        $username = "";                   // set your username
        $password = "";                   // set your password
        $client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish("ESP8266/sample/sub", "led = 0" , 0);
            $mqtt->close();
            //return "success";
        } else {
           // return "Time out!\n";
        }
    }











    public function test()
    {
        $str = '
                   {
                  "header":{
                      "namespace":"AliGenie.Iot.Device.Discovery",
                      "name":"DiscoveryDevicesResponse",
                      "messageId":"%s",
                      "payLoadVersion":1
                   },
                   "payload":{
                      "devices":[{
                      "deviceId":"34ea34cf2e63",
                      "deviceName":"light1",
                      "deviceType":"light",
                      "zone":"zz",          
                      "brand":"zz",
                      "model":"zzz",     
                      "icon":"zzz",
                      "properties":[{
                        "name":"color",
                        "value":"Red"
                       }],
                      "actions":[
                        "TurnOn",
                        "TurnOff",
                        "SetBrightness",       
                        "AdjustBrightness",     
                        "SetTemperature",
                        "Query"          
                     ],
                      "extensions":{
                         "extension1":"",
                         "extension2":""
                      }
                     }]
                   }
                }
                ';

        $result = sprintf($str,"dssd");

    return $result;
    }

}
