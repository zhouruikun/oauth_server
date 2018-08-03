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
                      "zone":"",          
                      "brand":"",
                      "model":"",     
                      "icon":"https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1533312561637&di=ceb67291219470e5ffe6a7eaa105deea&imgtype=0&src=http%3A%2F%2Fwww.suunto.cn%2Fcontentassets%2Fa831335e43eb4b3b90b55547ed33ab41%2Ficon-steps.png",
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

                $result = sprintf($str,$data->header->messageId);
        }
       return $result;

    }
}
