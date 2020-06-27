<?php 
/*
*Plugin Name: Contact Form
*Plugin URI: 
*Description: Plugin achraform
*Author: Achraf
*Author URI: https://github.com/Achraf-wanna
*Version: 0.1
*/

require_once(ABSPATH . 'wp-config.php');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection, DB_NAME);


function newTableData()
{
    global $connection;

    $sql = "CREATE TABLE Posts(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, Nom varchar(100) NOT NULL, email varchar(150) NOT NULL, text varchar(250) NOT NULL)";
    $result = mysqli_query($connection, $sql);
    return $result;
}

if ($connection == true){
    newTableData();
}



add_action("admin_menu", "addMenu");
function addMenu()
{
  add_menu_page("Contact Form", "Achraform", 4, "contact-form", "contactform" );

}

function contactform()
{
echo <<< 'EOD'
<div style="display:flex;align-items:center;flex-direction:column">
<br>
  <h1> Welcome to <span  style="color:#487eb0;">Achraform</span></h1>
  <h4 style="margin-top: 4px">Your free easy way to build contact forms</h4>
  
  
  <p>Copy the shortcode and paste it on the contact us page If you want to generate a simple contact form with : <br><center>Name , Email , Message </center></p>
  <br>
  <div>


<input type = "text" value="[Achraform]" id="myInput">
<input type="submit" value="Copy ShortCode" name="submitcheck" onclick="myFunction()"  style="background-color: #273c75;border-color:#273c75;height:40px;border-radius:16px;color:white;">

<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}
</script>

</div>
<br>
<p>if you want to remove an input , just replace "name" in the input bellow with the input you want to remove <br><center>and copy to the shortcode</center></p>
<input style="margin-right: 120px" type = "text" value="[Achraform name='false']" id="myInput1">
<input style="margin-left: 188px; margin-top: -35px ; background-color: #273c75;border-color:#273c75;height:40px;border-radius:16px;color:white;" type="submit" value="Copy ShortCode" name="submitcheck" onclick="myFunction1()">

<script>
function myFunction1() {
  var copyText = document.getElementById("myInput1");
  copyText.select();
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
}
</script>
<div>
<h2>Donate To Support Us :</h2>
<center><a href="https://www.paypal.com" target="_blank"><button style="width:90px; background-color: yellow;border-color:yellow;font-weight:bold;height:40px;border-radius:16px;color:black;margin-top:10%;">Donate</button></a></center>
</div>
</div>
EOD;
}




    function contact($atts){
        extract(shortcode_atts(
            array(
                'name' => 'true',
                'email' => 'true',
                'text' => 'true'
                
        ), $atts));
    
        if($name== "true"){
            $name1 = '<label style="margin-left: 10%">NAME:</label><input style="width: 80%; margin-left: 10%" type="text" name="nom" required>';
        }else{
            $name1 = "";
        }

        if($email== "true"){
            $email1 = '<label style="margin-left: 10%">EMAIL:</label><input style="width: 80%; margin-left: 10%" type="email" name="email" required>';
        }else{
            $email1 = "";
        }

        if($text== "true"){
            $text1 = '<label style="margin-left: 10%">TEXT:</label><textarea style="width: 80%; margin-left: 10%" type="text" name="text" required></textarea><br>';
        }else{
            $text1 = "";
        }



        echo '<form method="POST"  >' .$name1 . $email1 . $text1 . '<input style="margin-top:20px; width: 20%; margin-left: 40%" value="Submit" type="submit" name="submitcheck">
        </form>';
    }
    add_shortcode('Achraform', 'contact');

    

    function form($name, $email,  $text)
    {
        global $connection;
  
      $sql = "INSERT INTO posts(Nom, email, text) VALUES ('$name', '$email', '$text')";
      $result = mysqli_query($connection , $sql);
     
      return $result;
    }

    if(isset($_POST['submitcheck'])){

        $name = $_POST['nom'];
        $email = $_POST['email'];
        $text = $_POST['text'];

        form($name, $email, $text);

    

    }



?>