<?php

namespace App\Http\Controllers;
use Log;
use Bluerhinos\phpMQTT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class DeviceController extends Controller
{
    public  $result='';
    //
    public function getDevice(Request $request)
    {
        Log::info($request);
        $data= $request->getContent();
        $data = json_decode($data);

        switch ($data->header->namespace) {
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
                $resultstr = sprintf($str, $data->header->messageId);
                break;
            case  'AliGenie.Iot.Device.Control':
                $result = $this->DeviceControl($data);
                if ($result->result == true) {
                    $str = '｛
                          "header":{
                              "namespace":"AliGenie.Iot.Device.Control",
                              "name":"%s",
                              "messageId":"%s",
                              "payLoadVersion":1
                           },
                           "payload":{
                              "deviceId":"%s"
                            }
                         ｝';
                    $resultstr = sprintf($str, $result->name, $data->header->messageId, $data->payload->deviceId);
                } else {
                    $str = '｛
                          "header":{
                              "namespace":"AliGenie.Iot.Device.Control",
                              "name":"%s",
                              "messageId":"%s",
                              "payLoadVersion":1
                           },
                           "payload":{
                              "deviceId":"%s"
                               "errorCode":"%s",
                                "message":"%s"
                            }
                         ｝';
                    $resultstr = sprintf($str, $result->name, $data->header->messageId, $result->deviceId, $result->errorCode, $result->message);
                }
                break;
            }
        $status = 200;
        $type = 'application/json';
        $respo = (new  Response($resultstr, $status))->header('Content-Type', $type);
        Log::info($respo);
        return $respo;
    }

    public function DeviceControl($str)
    {
            switch ($str->header->name)
            {
                case 'TurnOn':
                    $this->turnOn();
                    $result['result'] = true;
                    $result['name'] = 'TurnOnResponse';
                    $result['deviceId'] = $str->payload->deviceId;
                    break;
                case 'TurnOff':
                    $this->turnOff();
                    $result['result'] = true;
                    $result['name'] = 'TurnOffResponse';
                    $result['deviceId'] = $str->payload->deviceId;
                    break;
            }
            return json_encode($result);
    }
    public function turnOn(){
        $server = "106.14.226.150";     // change if necessary
        $port = 1883;                     // change if necessary
        $username = "";                   // set your username
        $password = "";                   // set your password
        $client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish("ESP8266/sample/sub", "led = 1" , 0);
            $mqtt->close();
            //return "success";
        } else {
           // return "Time out!\n";
        }
    }



    public function turnOff(){
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
