<<?php

  function humanTiming ($time)
  {

      $time = time() - $time; // to get the time since that moment
      $time = ($time<1)? 1 : $time;
      $tokens = array (
          31536000 => 'année',
          2592000 => 'mois',
          604800 => 'semaine',
          86400 => 'jour',
          3600 => 'heure',
          60 => 'minute',
          1 => 'seconde'
      );

      foreach ($tokens as $unit => $text) {
          if ($time < $unit) continue;
          $numberOfUnits = floor($time / $unit);
          return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
      }

  }
?>
