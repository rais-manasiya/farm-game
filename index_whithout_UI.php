<?php
require('farmFactory.php');
session_start();

//initiate Game

if(isset($_SESSION['farm_game']))
{
  unset($_SESSION['farm_game']);
}


$_SESSION['farm_game']['all_entity'] = Config::getInstance()->all_entity;
$_SESSION['farm_game']['entity_count']= Config::$entity_count;
$_SESSION['farm_game']['all_die_entity'] = Config::$all_die_entity;
?>
<html>
 <script src="JS/jquery.min.js"></script>
<script>
	function startGame(){
		    let turn = $("#turn_cnt").val();
		    turn = parseInt(turn) + 1;
		    $("#turn_cnt").val(turn);
		    console.log(turn);
			let url = "ajaxGameExecuter.php?turn="+turn;
	
		 $.post(url, function(res, status){
              if(res)
              {
              	data = jQuery.parseJSON(res);
              	console.log(data.all_entity.FARMER);
              	$("#showMsg").html(data);
              }
          });    
	}
</script>
<body>
	<input type='text' id='turn_cnt' name='turn_cnt' value='<?php echo Config::$turn; ?>'>
	<button type="button" name="click" id="click" Onclick="startGame()">Click</button>
	<div><p id="showMsg"></p></div>
</body>
</html>