<?php
require_once 'koneksi.php';
require_once 'fungsi.php';

function getDistinct($atribut)
{
  global $conn;
  $query = "SELECT DISTINCT $atribut FROM dtraining";
  $dump = mysqli_query($conn, $query);
  foreach ($dump as $k => $v) {
    $data[] =  $v[$atribut];
  }
  return $data;
}
function getData($where = '')
{
  global $conn;

  $query = "SELECT * FROM dtraining $where";
  // var_dump($query);
  // die;
  $data = mysqli_query($conn, $query)->num_rows;
  // foreach ($data as $k => $v) {
  //   $result[$k][] =  $v['outlook'];
  //   $result[$k][] =  $v['temperature'];
  //   $result[$k][] =  $v['humidity'];
  //   $result[$k][] =  $v['windy'];
  //   $result[$k][] =  $v['play'];
  // }
  return $data;
}
function getEntropy($total, $totalY, $totalN)
{
  $hitung = round(((-$totalY / $total) * log($totalY / $total, 2)) + ((-$totalN / $total) * log($totalN / $total, 2)), 10);
  if (is_nan($hitung)) {
    $hitung = 0;
  }
  return $hitung;
}
$nilaiAtt['outlook'] = getDistinct('outlook');
$nilaiAtt['temperature'] = getDistinct('temperature');
$nilaiAtt['humidity'] = getDistinct('humidity');
$nilaiAtt['windy'] = getDistinct('windy');
$nilaiAtt['play'] = getDistinct('play');

$total = getdata();
$totalY = getdata('WHERE PLAY = \'yes\'');
$totalN = getdata('WHERE PLAY = \'no\'');
$Entropy = getEntropy($total, $totalY, $totalN);




$totalSunny = getdata('WHERE OUTLOOK = \'sunny\'');
$totalSunnyY = getdata('WHERE PLAY = \'yes\' AND OUTLOOK = \'sunny\'');
$totalSunnyN = getdata('WHERE PLAY = \'no\' AND OUTLOOK = \'sunny\'');
$EntropySunny = getEntropy($totalSunny, $totalSunnyY, $totalSunnyN);

$totalOvercast = getdata('WHERE OUTLOOK = \'overcast\'');
$totalOvercastY = getdata('WHERE PLAY = \'yes\' AND OUTLOOK = \'overcast\'');
$totalOvercastN = getdata('WHERE PLAY = \'no\' AND OUTLOOK = \'overcast\'');
$EntropyOvercast = getEntropy($totalOvercast, $totalOvercastY, $totalOvercastN);

$totalRain = getdata('WHERE OUTLOOK = \'rain\'');
$totalRainY = getdata('WHERE PLAY = \'yes\' AND OUTLOOK = \'rain\'');
$totalRainN = getdata('WHERE PLAY = \'no\' AND OUTLOOK = \'rain\'');
$EntropyRain = getEntropy($totalRain, $totalRainY, $totalRainN);

$GainOutlook = ($Entropy) - (($totalSunny / $total) * $EntropySunny) - (($totalOvercast / $total) * $EntropyOvercast) - (($totalRain / $total) * $EntropyRain);




$totalHot = getdata('WHERE TEMPERATURE = \'Hot\'');
$totalHotY = getdata('WHERE PLAY = \'yes\' AND TEMPERATURE = \'Hot\'');
$totalHotN = getdata('WHERE PLAY = \'no\' AND TEMPERATURE = \'Hot\'');
$EntropyHot = getEntropy($totalHot, $totalHotY, $totalHotN);

$totalMild = getdata('WHERE TEMPERATURE = \'Mild\'');
$totalMildY = getdata('WHERE PLAY = \'yes\' AND TEMPERATURE = \'Mild\'');
$totalMildN = getdata('WHERE PLAY = \'no\' AND TEMPERATURE = \'Mild\'');
$EntropyMild = getEntropy($totalMild, $totalMildY, $totalMildN);

$totalCool = getdata('WHERE TEMPERATURE = \'Cool\'');
$totalCoolY = getdata('WHERE PLAY = \'yes\' AND TEMPERATURE = \'Cool\'');
$totalCoolN = getdata('WHERE PLAY = \'no\' AND TEMPERATURE = \'Cool\'');
$EntropyCool = getEntropy($totalCool, $totalCoolY, $totalCoolN);

$GainTemperature = ($Entropy) - (($totalHot / $total) * $EntropyHot) - (($totalMild / $total) * $EntropyMild) - (($totalCool / $total) * $EntropyCool);



$totalHigh = getdata('WHERE HUMIDITY = \'High\'');
$totalHighY = getdata('WHERE PLAY = \'yes\' AND HUMIDITY = \'High\'');
$totalHighN = getdata('WHERE PLAY = \'no\' AND HUMIDITY = \'High\'');
$EntropyHigh = getEntropy($totalHigh, $totalHighY, $totalHighN);

$totalNormal = getdata('WHERE HUMIDITY = \'Normal\'');
$totalNormalY = getdata('WHERE PLAY = \'yes\' AND HUMIDITY = \'Normal\'');
$totalNormalN = getdata('WHERE PLAY = \'no\' AND HUMIDITY = \'Normal\'');
$EntropyNormal = getEntropy($totalNormal, $totalNormalY, $totalNormalN);

$GainHumidity = ($Entropy) - (($totalHigh / $total) * $EntropyHigh) - (($totalNormal / $total) * $EntropyNormal);



$totalWeak = getdata('WHERE Windy = \'Weak\'');
$totalWeakY = getdata('WHERE PLAY = \'yes\' AND Windy = \'Weak\'');
$totalWeakN = getdata('WHERE PLAY = \'no\' AND Windy = \'Weak\'');
$EntropyWeak = getEntropy($totalWeak, $totalWeakY, $totalWeakN);

$totalStrong = getdata('WHERE Windy = \'Strong\'');
$totalStrongY = getdata('WHERE PLAY = \'yes\' AND Windy = \'Strong\'');
$totalStrongN = getdata('WHERE PLAY = \'no\' AND Windy = \'Strong\'');
$EntropyStrong = getEntropy($totalStrong, $totalStrongY, $totalStrongN);

$GainWindy = ($Entropy) - (($totalWeak / $total) * $EntropyWeak) - (($totalStrong / $total) * $EntropyStrong);

$test = "This is a string";

// Function that returns the variable name
function getVariavleName($var)
{
  foreach ($GLOBALS as $varName => $value) {
    if ($value === $var) {
      return $varName;
    }
  }
  return;
}
$max = max($GainOutlook, $GainTemperature, $GainHumidity, $GainWindy);

$cOutlook = "label";
$cTemperature = "label";
$cHumidity = "label";
$cWindy = "label";

if ($max) {
  $varName = getVariavleName($max);
  $label = substr($varName, 4);
  $varName = "c" . substr($varName, 4);
  $$varName = "colored";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }

    a {
      border: 0 solid black;
      margin-left: 8px;
      margin-right: 5px;
    }

    div {
      padding-bottom: 10px;
    }

    #myDIV {
      display: none;
    }

    .colored {
      background-color: #D6EEEE;
    }
  </style>
</head>

<body>
  <a href="http://localhost/dm/C45/">Index</a>
  <br>
  <br>
  Nilai Gain Tertinggi dimiliki oleh atribut <span><?= $label; ?></span> dengan nilai: <span><?= $max; ?></span>
  <table>
    <tr>
      <th>Atribut</th>
      <th>Nilai</th>
      <th>Jumlah Kasus</th>
      <th>Yes</th>
      <th>No</th>
      <th>Entropy</th>
      <th>Gain</th>
    </tr>
    <tr>
      <td>Total</td>
      <td></td>
      <td><?= $total; ?></td>
      <td><?= $totalY; ?></td>
      <td><?= $totalN; ?></td>
      <td><?= $Entropy; ?></td>
      <!-- <td></td> -->
    </tr>
    <tr>
      <td class="<?= $cOutlook; ?>">Outlook</td>
      <td class="<?= $cOutlook; ?>"></td>
      <td class="<?= $cOutlook; ?>"></td>
      <td class="<?= $cOutlook; ?>"></td>
      <td class="<?= $cOutlook; ?>"></td>
      <td class="<?= $cOutlook; ?>"></td>
      <td class="<?= $cOutlook; ?>"><?= $GainOutlook; ?></td>
    </tr>
    <?php
    foreach ($nilaiAtt['outlook'] as $k => $v) {
      $var = "total" . $v;
      $varY = "total" . $v . "Y";
      $varN = "total" . $v . "N";
      $varE = "Entropy" . $v; ?>
      <tr>
        <td></td>
        <td><?= $v; ?></td>
        <td><?= $$var; ?></td>
        <td><?= $$varY; ?></td>
        <td><?= $$varN; ?></td>
        <td><?= $$varE; ?></td>
        <!-- <td></td> -->
      </tr>
    <?php } ?>

    <tr>
      <td class="<?= $cTemperature; ?>">Temperature</td>
      <td class="<?= $cTemperature; ?>"></td>
      <td class="<?= $cTemperature; ?>"></td>
      <td class="<?= $cTemperature; ?>"></td>
      <td class="<?= $cTemperature; ?>"></td>
      <td class="<?= $cTemperature; ?>"></td>
      <td class="<?= $cTemperature; ?>"><?= $GainTemperature; ?></td>
    </tr>
    <?php
    foreach ($nilaiAtt['temperature'] as $k => $v) {
      $var = "total" . $v;
      $varY = "total" . $v . "Y";
      $varN = "total" . $v . "N";
      $varE = "Entropy" . $v; ?>
      <tr>
        <td></td>
        <td><?= $v; ?></td>
        <td><?= $$var; ?></td>
        <td><?= $$varY; ?></td>
        <td><?= $$varN; ?></td>
        <td><?= $$varE; ?></td>
        <!-- <td></td> -->
      </tr>
    <?php } ?>

    <tr>
      <td class="<?= $cHumidity; ?>">Humidity</td>
      <td class="<?= $cHumidity; ?>"></td>
      <td class="<?= $cHumidity; ?>"></td>
      <td class="<?= $cHumidity; ?>"></td>
      <td class="<?= $cHumidity; ?>"></td>
      <td class="<?= $cHumidity; ?>"></td>
      <td class="<?= $cHumidity; ?>"><?= $GainHumidity; ?></td>
    </tr>
    <?php
    foreach ($nilaiAtt['humidity'] as $k => $v) {
      $var = "total" . $v;
      $varY = "total" . $v . "Y";
      $varN = "total" . $v . "N";
      $varE = "Entropy" . $v; ?>
      <tr>
        <td></td>
        <td><?= $v; ?></td>
        <td><?= $$var; ?></td>
        <td><?= $$varY; ?></td>
        <td><?= $$varN; ?></td>
        <td><?= $$varE; ?></td>
        <!-- <td></td> -->
      </tr>
    <?php } ?>

    <tr>
      <td class="<?= $cWindy; ?>">Windy</td>
      <td class="<?= $cWindy; ?>"></td>
      <td class="<?= $cWindy; ?>"></td>
      <td class="<?= $cWindy; ?>"></td>
      <td class="<?= $cWindy; ?>"></td>
      <td class="<?= $cWindy; ?>"></td>
      <td class="<?= $cWindy; ?>"><?= $GainWindy; ?></td>
    </tr>
    <?php
    foreach ($nilaiAtt['windy'] as $k => $v) {
      $var = "total" . $v;
      $varY = "total" . $v . "Y";
      $varN = "total" . $v . "N";
      $varE = "Entropy" . $v; ?>
      <tr>
        <td></td>
        <td><?= $v; ?></td>
        <td><?= $$var; ?></td>
        <td><?= $$varY; ?></td>
        <td><?= $$varN; ?></td>
        <td><?= $$varE; ?></td>
        <!-- <td></td> -->
      </tr>
    <?php } ?>
  </table>
</body>

</html>
