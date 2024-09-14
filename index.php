<?php

$db_name = 'mysql:host=localhost;dbname=registration_db';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $courses = $_POST['courses'];
   $courses = filter_var($courses, FILTER_SANITIZE_STRING);
   $gender = $_POST['gender'];
   $gender = filter_var($gender, FILTER_SANITIZE_STRING);

   $select_registration = $conn->prepare("SELECT * FROM `registration_form` WHERE name = ? AND number = ? AND email = ? AND courses = ? AND gender = ?");
   $select_registration->execute([$name, $number, $email, $courses, $gender]);

   if($select_registration->rowCount() > 0){
      $message[] = 'Nama sudah terdaftar!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `registration_form`(name, number, email, courses, gender) VALUES(?,?,?,?,?)");
      $insert_message->execute([$name, $number, $email, $courses, $gender]);
      $message[] = 'Registrasi berhasil! Tunggu email dari kami untuk masuk ke tahap selanjutnya!';
   }

}

?>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
         <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
      ';
   }
}
?>