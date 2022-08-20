<?php
require_once 'koneksi.php';
$query = "SELECT * FROM dtraining";
$dtraining =  mysqli_query($conn, $query);

if (isset($_POST['del'])) {
  $id = $_POST['id'];
  $delQ = "DELETE FROM dtraining WHERE id = $id";
  $del =  mysqli_query($conn, $delQ);
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C.45</title>
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
  </style>

  <script>
    function myFunction() {
      var x = document.getElementById("myDIV");
      if (x.style.display === "block") {
        x.style.display = "none";
      } else {
        x.style.display = "block";
      }
      var x = document.getElementById("tombol");
      if (x.innerHTML === "Input") {
        x.innerHTML = "Hide";
      } else {
        x.innerHTML = "Input";
      }
    }
  </script>
</head>

<body>
  <button onclick="myFunction()" id="tombol">Input</button>

  <div id="myDIV">
    <form action="fungsi.php" method="post">
      input data
      <table>
        <tr>
          <td><label for="outlook">outlook</label></td>
          <td>
            <select name="outlook" id="outlook" required>
              <option value="" disabled selected>-- Pilih --</option>
              <option value="Sunny">Sunny</option>
              <option value="Overcast">Overcast</option>
              <option value="Rain">Rain</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="temperature">temperature</label></td>
          <td>
            <select name="temperature" id="temperature" required>
              <option value="" disabled selected>-- Pilih --</option>
              <option value="Hot">Hot</option>
              <option value="Mild">Mild</option>
              <option value="Cool">Cool</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="humidity">humidity</label></td>
          <td>
            <select name="humidity" id="humidity" required>
              <option value="" disabled selected>-- Pilih --</option>
              <option value="High">High</option>
              <option value="Normal">Normal</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="windy">windy</label></td>
          <td>
            <select name="windy" id="windy" required>
              <option value="" disabled selected>-- Pilih --</option>
              <option value="Weak">Weak</option>
              <option value="Strong">Strong</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="play">play</label></td>
          <td>
            <select name="play" id="play" required>
              <option value="" disabled selected>-- Pilih --</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </td>
        </tr>
      </table>
      <button type="submit" name="tambah" value="tambah">tambah</button>
      <br><br>
    </form>
  </div>
  <a href="hitung.php">hitung</a>
  <!-- <a href="http://localhost/dm/C45?target=tambah">add</a> -->
  <div></div>


  <table>
    <tr>
      <th>#</th>
      <th>outlook</th>
      <th>temperature</th>
      <th>humidity</th>
      <th>windy</th>
      <th>play</th>
      <th>delete</th>
    </tr>
    <?php foreach ($dtraining as $k => $v) { ?>
      <tr>
        <td><?= $k + 1; ?></td>
        <td><?= $v['outlook']; ?></td>
        <td><?= $v['temperature']; ?></td>
        <td><?= $v['humidity']; ?></td>
        <td><?= $v['windy']; ?></td>
        <td><?= $v['play']; ?></td>
        <td>
          <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $v['id']; ?>">
            <button type="submit" name="del" value="del">del</button>
          </form>
        </td>
      </tr>
    <?php } ?>
  </table>
  <br>
</body>

</html>