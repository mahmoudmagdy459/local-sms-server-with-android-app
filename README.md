# php-sms-code-using-rest-sms-gateway-android-app

Trun your old android phone to SMS gateway and control app through my php script
``` 
function SMS_Connect($ipAddress,$port='8080',$is_secure=false,$api_version='v1',$get='');
  $get = ['device-status', 'sms-list', 'send-sms-o1']
``` 
****

| *device-status*                    |    | *sms-list*            |
|-----------------------------------|     |-----------------------|
| function getDeviceStatus();        |    |function getSMSList(); |
| function getAirplaneMode();        |                  
| function getNetworkOperatorName(); |    | *send-sms-o1*                                         |
| function getTimeStamp();           |    | ------------------------------------------------------|
| function getBatteryStatus();       |    | function SendSMS($user,$password,$from,$to,$message); |
| function getBatteryLevel();        |    | function Check_SendSMS();                             |
| function getSimState();            |

****
```
## Send SMS message
```php
include_once('config.php');
include_once('smsgateway.php');
 $SMSGateWay = new RSG();
  $sms_to = '+XXX-.....';  //Recipient number
  $sms_msg = ".........\n"; //Your message
  echo $SMSGateWay->SendSMS('','APP Username','',$sms_to,$sms_msg);
  echo $SMSGateWay->SMS_Connect(HOSTNAME,HOSTPORT,IS_SECURE,'v1','send-sms-o1');
  echo $SMSGateWay->Check_SendSMS();
```
****
## View Mobile SMS list
```php
include_once('config.php');
include_once('smsgateway.php');
 $SMSGateWay = new RSG();
  $SMSGateWay->SMS_Connect(HOSTNAME,HOSTPORT,IS_SECURE,API_VERSION,'sms-list');
  $sms_list = $SMSGateWay->getSMSList();
  echo '<table style="padding:5px;margin:0 auto 0;width:700px;" border="1">';
  echo '<tr style="background-color:#ff0000;color:#eeeeee;" align="center"><td colspan="3"><span>Inbox List</span></td></tr>';
  if(!empty($sms_list)){
  foreach($sms_list as $address => $i){
   echo '<tr><td style="padding:5px;font-weight:bold;">'.$address.'</td><td style="border:0px;"></td></tr>';
    if(is_array($i)){
     foreach($i as $info){
      if(is_array($info)){
       echo '<tr><td style="border:0px;"></td><td>'.$info['_id'].'</td><td style="padding:5px; ';
        if($SMSGateWay->is_rtl($info['body'])){ echo 'direction:rtl;'; }
        else { echo 'direction:ltr;'; }
       echo '">'.$info['body'].'</td></tr>';
      }
     }
    }
   }
  }
   echo '</table>';
  } 
  ```
  ****
