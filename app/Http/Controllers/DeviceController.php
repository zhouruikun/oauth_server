<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //
    public function getDevice(Request $request)
    {
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
                         "extension1":"",
                         "extension2":"1"
                      }
                     }]
                   }
                }
                ';

                $result = sprintf($str,$data->header->messageId);
        }
       return json_encode($result);

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
