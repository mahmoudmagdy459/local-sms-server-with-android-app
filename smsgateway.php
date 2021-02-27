<?php
/***************************************************/
/****    REST SMS GATEWAY ANDROID APP           ****/
/****      API CONNECTION PHP Class             ****/
/****            VERSION 1.0                    ****/
/***************************************************/
/****  REQUIREMENTS:                            ****/
/****    - STATIC IP ADDRESS;                   ****/
/****    - ROUTER PORT FORWARDING               ****/
/****    - NO-IP ANDROID APP [NO-IP UPDATER];   ****/
/****    - NO-IP ACCOUNT:                       ****/
/****           % HOST                          ****/
/****           % USER                          ****/
/****           % PASSWORD                      ****/
/***************************************************/

class RSG {
 public static $connect = false;
 public static $url = '';
 public static $result = array();
 public static $timestamp = '';
 public static $is_airplane_mode = false;
 public static $network_operator_name = '';
 public static $sim_state = 'absent';
 public static $is_network_roaming = false;
 public static $battery_status = '';
 public static $battery_level = 0;
 public static $sms_list_limit = 10;
 public static $sms_list_offset = 0;
 public static $sms_list_size = 7;
 public static $sms_list_messages = array();
 public function setTimeStamp($x){
  self::$timestamp = $x;
 }
 public function setAirplaneMode($x){
  self::$is_airplane_mode = $x;
 }
 public function setNetworkOperatorName($x){
  self::$network_operator_name = ucfirst($x);
 }
 public function setSimState($x){
  self::$sim_state = ucfirst($x);
 }
 public function setIsNetworkRoaming($x){
  self::$is_network_roaming = $x;
 }
 public function setBatteryStatus($x){
  self::$battery_status = ucfirst($x);
 }
 public function setBatteryLevel($x){
  self::$battery_level = $x;
}
public function setSMSListLimit($x){
 self::$sms_list_limit = $x;
}
public function setSMSListOffset($x){
 self::$sms_list_offset = $x;
}
public function setSMSListSize($x){
 self::$sms_list_size = $x;
}
  public function getTimeStamp(){
   if(!empty($this->timestamp)){
    $datetime = date('d-m-Y h:i:s A', self::$timestamp);
    return $datetime;
   }
   else {
     return date('d-m-Y h:i:s A');
   }
  }
  public function getAirplaneMode(){
   return self::$is_airplane_mode;
  }
  public function getNetworkOperatorName(){
   return self::$network_operator_name;
  }
  public function getSimState(){
   return self::$sim_state;
  }
  public function getIsNetworkRoaming(){
   return self::$is_network_roaming;
  }
  public function getBatteryStatus(){
   return self::$battery_status;
  }
  public function getBatteryLevel(){
   return self::$battery_level;
  }
  public function getSMSListLimit(){
   return self::$sms_list_limit;
  }
  public function getSMSListOffset(){
   return self::$sms_list_offset;
  }
  public function getSMSListSize(){
   return self::$sms_list_size;
  }
  public function UnsetResult(){
    self::$result = '';
    self::$result = array();
  }
  public function is_rtl($string) {
	 $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
	 return preg_match($rtl_chars_pattern, $string);
  }
  public function SMS_Connect($ipAddress,$port='8080',$is_secure=false,$api_version='v1',$get=''){
   $url = '';
   $fields_string = '';
   $portocal = '';
    switch($is_secure){
     case true:
      $protocal = 'https://';
     break;
     case false:
      $protocal = 'http://';
     break;
   }
     $url = $protocal.$ipAddress.':'.$port;
   if($get == 'device-status'){ self::UnsetResult();$get_url = '/'.$api_version.'/device/status/';$url .=$get_url; }
   if($get == 'sms-list'){ self::UnsetResult();$get_url = '/'.$api_version.'/sms/';$url .=$get_url; }
   if($get == 'send-sms'){
      self::UnsetResult();$get_url = '/sms/send/';$url .=$get_url;
     $fields = array(
       'from' => urlencode(__SMS_FROM__),
       'phone' => urlencode(__SMS_TO__),
       'message' => urlencode(__SMS_MESSAGE__)
     );
     foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
     rtrim($fields_string, '&');
      $url .= '?'.$fields_string;
   }
   if($get == 'send-sms-o1'){
      self::UnsetResult();$get_url = '/SendSMS/';$url .=$get_url;
     $fields = array(
       'user' => __SMS_USER__,
       'password' => __SMS_PASS__,
       'phoneNumber' => __SMS_TO__,
       'msg' => __SMS_MESSAGE__
     );
     foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
     rtrim($fields_string, '&');
      $url .= $fields_string;
      $url = substr($url, 0, -1);
   }  
if(function_exists('curl_init')){
$handle = curl_init();
curl_setopt ($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_NOBODY, false);
curl_setopt($handle, CURLOPT_HEADER, false);
      self::$result = curl_exec($handle);
      if (self::$result === false) {
      //echo curl_error($handle).' :: '.curl_errno($handle);
       }
      if($handle == true){ self::$connect = true;
      curl_close($handle);
      }
}
    }
  public function getDeviceStatus(){
    if(self::$connect == true){
     if(!empty(self::$result)){
      $rx = json_decode(self::$result, true);
      if($rx['is_airplane_mode'] == false){ $rx['is_airplane_mode'] = 0; }
       else { $rx['is_airplane_mode']= 1; }
      if($rx['telephony']['is_network_roaming'] == false){$rx['telephony']['is_network_roaming'] = 0;}
       else { $rx['telephony']['is_network_roaming'] = 1; }
      self::setTimeStamp($rx['timestamp']);
      self::setAirplaneMode($rx['is_airplane_mode']);
      self::setNetworkOperatorName($rx['telephony']['network_operator_name']);
      self::setSimState($rx['telephony']['sim_state']);
      self::setIsNetworkRoaming($rx['telephony']['is_network_roaming']);
      self::setBatteryStatus($rx['battery']['status']);
      self::setBatteryLevel($rx['battery']['level']);
       self::$connect = false;
     }
    }
   else {
    echo 'Error: SMS Server Connection';
   }
  }
  public function getSMSList(){
   $inbox_list = array();
    if(self::$connect == true){
     if(!empty(self::$result)){
      $rx = json_decode(self::$result, true);
      self::setSMSListLimit($rx['limit']);
      self::setSMSListOffset($rx['offset']);
      self::setSMSListSize($rx['size']);
      $rx['telephony'] = 0;
      self::setSimState($rx['telephony']['sim_state']);
      if(is_array($rx['messages'])){
       foreach($rx['messages'] as $key => $value){
        self::$sms_list_messages[][$key] = $value;
       }
      }
     }
     foreach(self::$sms_list_messages as $i => $array){
      if(is_array($array)){
        foreach($array as $i2 => $array2){
          $inbox_list[$array2['address']][] = $array2;
        }
      }
     }
      return $inbox_list;
    }
   else {
    echo 'Error: SMS Server Connection';
   }
  }
  public function SendSMS($user,$password,$from,$to,$message){
     if(!defined('__SMS_USER__') || !defined('__SMS_PASS__') || !defined('__SMS_FROM__') || !defined('__SMS_TO__') || !defined('__SMS_MESSAGE__')){
       define('__SMS_USER__', $user);
       define('__SMS_PASS__', $password);
       define('__SMS_FROM__', $from);
       define('__SMS_TO__', $to);
       define('__SMS_MESSAGE__', $message);
     }
     else {
       define('__SMS_USER__', $user);
       define('__SMS_PASS__', $password);
       define('__SMS_FROM__', $from);
       define('__SMS_TO__', $to);
       define('__SMS_MESSAGE__', $message);
     }
   }
 public function Check_SendSMS(){
   if(self::$connect == true){
    if(!empty(self::$result)){
     if(is_string(self::$result)){
      if(self::$result == 'OK'){
       $message = 'SMS Sent to Your Phone';
        return $message;
      }
      else {
       $message = '';
        return $message;
      }
     }
   }
  }
 }
}


?>