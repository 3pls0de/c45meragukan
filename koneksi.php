<?php

$conn = new mysqli("localhost", "root", "", "DM_c45");

// Check Connection
if ($conn->connect_errno) {
  echo "Gagal menyambungkan ke MYSQL" . $conn->connect_errno;
  exit();
}
