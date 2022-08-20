<?php
require_once 'koneksi.php';


// public function where($where)
// 	{
// 		if (is_array($where)) {
// 			$this->v_where = " WHERE ";
// 			foreach ($where as $key => $value) {
// 				$this->v_where .= $key . " = " . $value;
// 				if ($key == array_key_last($where)) {
// 					$this->v_where .= "";
// 				} else {
// 					$this->v_where .= " AND ";
// 				}
// 			}
// 		} else {
// 			$this->v_where = " WHERE ";
// 			$this->v_where .= $where;
// 		}
// 		return $this;
// 	}





if (isset($_POST['tambah'])) {
  $outlook = $_POST['outlook'];
  $temperature = $_POST['temperature'];
  $humidity = $_POST['humidity'];
  $windy = $_POST['windy'];
  $play = $_POST['play'];

  $query = "INSERT INTO dtraining (id, outlook, temperature, humidity, windy, play)
                         VALUES ('', '{$outlook}', '{$temperature}', '{$humidity}', '{$windy}', '{$play}')";
  $insert = mysqli_query($conn, $query);
  unset($_POST['tambah']);
  header('location: index.php');
}
