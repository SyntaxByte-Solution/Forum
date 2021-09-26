<?php

namespace App\Classes;

class Helper {
   /**
    * Encode array from latin1 to utf8 recursively
    * @param $dat
    * @return array|string
    */
   public static function convert_from_latin1_to_utf8($dat) {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }

   function notification_icon($action_type) {
      switch($action_type) {
          case 'thread-reply':
              return 'resource24-reply-icon';
          case 'resource-vote':
              return 'resource24-vote-icon';
          case 'resource-like':
              return 'resource24-like-icon';
          case 'warning-warning':
              return 'warning24-icon';
          case 'user-follow':
              return 'followfilled24-icon';
          case 'avatar-change':
          case 'cover-change':
              return 'image24-icon';
          case 'poll-action':
              return 'poll24-icon';
          case 'poll-vote':
              return 'pollvote24-icon';
          case 'poll-option-add':
              return 'polloptionadd24-icon';
          case 'post-tick':
              return 'posttick24-icon';
          default:
              return 'notification24-icon';
      }
  }
}