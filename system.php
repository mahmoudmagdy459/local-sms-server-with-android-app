<?php
@session_start();
include_once('config.php');
include_once('smsgateway.php');



/*---------------------------------*/
/*----       INDEX PAGE        ----*/
/*---------------------------------*/

if(isset($_GET['logout'])){
 if(!empty($_SESSION['_username'])){
  unset($_SESSION['_username']);
 }
}
if(isset($_POST['sms_system_login_btn'])){
  $_SESSION['_username'] = sha1($username);
if($_POST['_username'] == $username && $_POST['_password'] == $password){   
echo '<!DOCTYPE html><html><head><title>SMS GateWay</title></head><body>';
   $SMSGateWay = new RSG();
    echo $SMSGateWay->SMS_Connect(HOSTNAME,HOSTPORT,IS_SECURE,API_VERSION,'device-status');
    echo $SMSGateWay->getDeviceStatus();  
 echo '<table style="margin:0 auto 0;" border="1">';
 echo '<tr><td colspan="2" align="center"><a href="'.$_SERVER['PHP_SELF'].'?logout=1">logout</a></td></tr>';
 echo '<tr style="background-color:#ff0000;color:#eeeeee;" align="center"><td colspan="2"><span>Device Information</span></td></tr>';
 echo '<tr><td>Airplane Mode</td><td>'.$SMSGateWay->getAirplaneMode().'</td></tr>';
 echo '<tr><td>Network Operator</td><td>'.$SMSGateWay->getNetworkOperatorName().'</td></tr>';
 echo '<tr><td><img src="data:image/png;base64,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AA5gP6/L7jPYgtcX5Lf/+b3a/37Yv/0fOn+V4wM4APnll19++eXvd3wAByC//PLLL7/8/Y4P4ADkl19++eWXv9/xARyA/PLLL7/88vc7PoADkF9++eWXX/5+xwdwAPLLL7/88svf7/gADkB++eWXX375+x0fwAHIL7/88ssvf7/jAzgA+eWXX3755e93fAAHIL/88ssvv/z9jg/gAOSXX3755Ze/3/EBHID88ssvv/zy9zs+gAOQX3755Zdf/n7HB3AA8ssvv/zyy9/v+AAOQH755Zdffvn7HR/AAcgvv/zyyy9/v+MDOAD55Zdffvnl73d8AAcgv/zyyy+//P2OD+AA5Jdffvnll7/f8QEcgPzyyy+//PL3Oz6AA5Bffvnll1/+fscHcADyyy+//PLL3+/4AA5Afvnll19++fsdH8AByC+//PLLL3+/4wM4APnll19++eXvd3wAByC//PLLL7/8/Y4P4ADkl19++eWXv9/xARyA/PLLL7/88vc7PoADkF9++eWXX/5+xwdwAPLLL7/88svf7/gADkB++eWXX375+x0fwAHIL7/88ssvf7/jAzgA+eWXX3755e93fAAHIL/88ssvv/z9jg/gAOSXX3755Ze/3/EBHID88ssvv/zy9zs+gAOQX3755Zdf/n7HB3AA8ssvv/zyy9/v+AAOQH755Zdffvn7HR/AAcgvv/zyyy9/v+MDOAD55Zdffvnl73d8AAcgv/zyyy+//P2OD+AA9vP6e/67W/CGgvz2P79X+98P+7f/Q+evcnwAB0D7p/3T/vsdH8AB0P5p/7T/fscHcAC0f9o/7b/f8QEcAO2f9k/773d8AAdA+6f90/77HR/AAdD+af+0/37HB3AAtH/aP+2/3/EBHADtn/ZP++93fAAHQPun/dP++x0fwAHQ/mn/tP9+xwdwALR/2j/tv9/xARwA7Z/2T/vvd3wAB0D7p/3T/vsdH8AB0P5p/7T/fscHcAC0f9o/7b/f8QEcAO2f9k/773d8AAdA+6f90/77HR/AAdD+af+0/37HB3AAtH/aP+2/3/EBHADtn/ZP++93fIBjPIArspuXh/MV57SBWezf/qc/r2NzS/tXAAq8+lw2AADAAApAgQoAAGB1FIACFQAAwOooAAUqAACA1VEAClQAAACrowAUqAAAAFZHAShQAQAArI4CUKACAABYHQWgQAUA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" width="24px" height="24px" />Date/Time</td><td>'.$SMSGateWay->getTimeStamp().'</td></tr>';
 echo '<tr><td><img src="data:image/png;base64,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" width="24px" height="24px" />Battery Status</td><td>'.$SMSGateWay->getBatteryStatus().'</td></tr>';
 echo '<tr valign="middle"><td><img src="data:image/png;base64,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/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP9PofUGb+2fMDPe39M73+B5SZf/b8QE97/0yv/wFl5p89P9DT3j/T639Amflnzw/0tPfP5D7u4QLazD97fqCnvX8m92oPF9Bm/tnzAz3t/TO5x3u4gDbzz54f6Gnvn8nd38MFtJl/9vxAT3v/TO7aHi6gzfyz5wd62vtnau+TXNjDBbSZf/b8QE97/0ztwV4uoM38s+cHetr7Z2IfkvyylwtoM//s+YGe9v6Z2J09XUCb+WfPD/S098+0nib5aU8X0Gb+2fMDPe39M6mXSX7e2wW0mX/2/EBPe/9M6WWS3/Z4AW3mnz0/0NPePxN6mi/8m/9eLqDN/LPnB3ra++cs9yHLb/j7j//nv7cLaDP/7PmBnvb+OYu9z/Ln/D//Ub89X0Cb+WfPD/S0989p72OWv9XvcZaf7X8tf/6Ev9NyAW3mnz0/0NPeP+3qph+A+WfPD/S090+7uukHYP7Z8wM97f3Trm76AZh/9vxAT3v/tKubfgDmnz0/0NPeP+3qph+A+WfPD/S090+7uukHYP7Z8wM97f3Trm76AZh/9vxAT3v/tKubfgDmnz0/0NPeP+3qph+A+WfPD/S090+7uukHYP7Z8wM97f3Trm76AZh/9vxAT3v/tKubfgDmnz0/0NPeP+3qph+A+WfPD/S090+7uukHYP7Z8wM97f3Trm76AZh/9vxAT3v/tKsbfwAAVLTfn2YfVzi/g7UPAYCZ2u9Ps1crnN/B2ocAwEzt96fZ4xXO72DtQwBgpvb70+z+Cud3sPYhADBT+/1pdm2F8ztY+xAAmKn9/rR6n+TCCud3sPZBADBT+/1p9WCNw1tD+yAAmKn9/jT6kOSXNQ5vDe3DAGCm9vvT6M4qJ7eS9mEAMFP7/dm6p0l+WuXkVtI+EABmar8/W/Yyyc/rHNt62ocCwEzt92fLx/+3lc5sVe2DAWCm9vuzRU+zw3/z/7f24QAwU/v9OWYfsvyGv139P/+/ax8SADO1359j9D7Ln/PfzR/1+5r2YQEwU/v9ObSPWf5Wv8dZfrb/tezkJ/x9q/YBAjCT96fMBQDQ4P0pcwEANHh/ylwAAA3enzIXAECD96fMBQDQ4P0pcwEANHh/ylwAAA3enzIXAECD96fMBQDQ4P0pcwEANHh/ylwAAA3enzIXAECD96fMBQDQ4P0pcwEANHh/ylwAAA3en7JP6V+CJElb9inkXfoXIUnSlr0LeZH+RUiStGUvQp6kfxGSJG3Zk5CT9C9CkqQt+z3kVvoXIUnSlt0KuZr+RUiStGVXQy6nfxGSJG3Z5ZAkeZb+ZUiStEXPwmd3078QSZK26G747Er6FyJJ0hZdCZ/9kOR5+pciSdIxe57lzeMvbqZ/MZIkHbOb4b9cTPIm/cuRJOkYvcny1vEFt9O/IEmSjtHt8D9dSvI6/UuSJGnNXmd54/iKG+lflCRJa3Yj/F/nkjxK/7IkSVqjR1neNr7Br0nepn9pkiQd0tssbxr/wPX0L06SpEO6Hr7LvfQvT5Kk7+le+G7nk5ykf4mSJP2TTrK8YRzgxyQP079MSZK+pYdZ3i5W8GP8lwBJ0v47icd/defj9wRIkvbbvfjP/kd1Pf6IoCRpP72N3+2/mV/jhwVJkvo9ij/nv7lzWX60or87QJK0da+zvEF+wl/RpSx/w5K/SliSdOzeZHlz/MU+O3Ixyc0kz9P/BSJJOls9z/LGXAy79UOSK0nuJnmW/i8aSdLp7FmWt+RKlreFU+ZykqtJbiX5PcmTJC+SvEvyKf1fYJKkTp+yvAUvsrwNv2d5K65meTsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABjkX2jb55O89LYXAAAAAElFTkSuQmCC" width="24px" height="24px" />Battery Level</td><td>'.$SMSGateWay->getBatteryLevel().'&#37;</td></tr>';
 echo '<tr><td><img src="data:image/png;base64,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" width="24px" height="24px" />SimCard Status</td><td>'.$SMSGateWay->getSimState().'</td></tr>';
 echo '</table><br />';

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
 } 
 else {
   echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
   echo '<table style="margin:0 auto 0;margin-top:20%;">';
   echo '<tr><td><input type="text" name="_username" value="" placeholder="Username" /></td></tr>';
   echo '<tr><td><input type="password" name="_password" value="" placeholder="Password" /></td></tr>';
   echo '<tr><td><input type="submit" name="sms_system_login_btn" value="Login" /></td></tr>';
   echo '</table>';
   echo '</form>';
 }

echo '<br /></body></html>';
