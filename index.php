<?php
require('farmFactory.php');
session_start();

//initiate Game

if(isset($_SESSION['farm_game']))
{
  unset($_SESSION['farm_game']);
}


$_SESSION['farm_game']['all_entity'] = Config::$all_entity;
$_SESSION['farm_game']['entity_count']= Config::$entity_count;
$_SESSION['farm_game']['all_die_entity'] = Config::$all_die_entity;
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Farm Game</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .btn_custom{margin-left: 10px;margin-bottom: 10px;}

      .alert {
          width: 250px;
          margin: 10px auto 0px;
          padding: 10px;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
  </head>
  <body>


<main role="main">

  <section class="text-center" style="margin-bottom:20px;">
    <div class="container-fluid">
      <h1>Welcome to <span class="text-primary">Farm Game</span></h1>     
        <button href="javascript:void(0);" class="btn btn-primary start">Start Game</button>
        <input type='hidden' id='turn_cnt' name='turn_cnt' value='<?php echo Config::$turn; ?>' >
        <button href="javascript:void(0);" class="btn btn-success feed" Onclick="startGame()" style="display: none;">Feed</button>
        <button href="javascript:void(0);" class="btn btn-warning restart" style="display: none;">Restart</button>
        <p id="disp_msg"></p>
    </div>
  </section>

  <section>

    <div class="container-fluid gameBody" style="display: none;">

      <div class="row">
  	   <div class="col-md-3">
            <table class="table table-bordered">
      				<thead>
      				  <tr>
      					<th>Name</th>
      					<th>Total Feed Count</th>
      					<th>Status</th>
      				  </tr>
      				</thead>
      				<tbody id="tablebody">
      				  
      				</tbody>
    			 </table>
        </div>
		
        <div class="col-md-8" id="count_table"></div>
     </div>
    </div>
  </section>

</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
	$(".start").click(function(){
		$('.start').hide();
	  $('.feed').show();
	});

  $(".restart").click(function(){
    document.location.reload(true);
  });


	function startGame(){
		    let turn = $("#turn_cnt").val();
		    turn = parseInt(turn) + 1;
		    if(turn>=50)
		    {
		       	$('.feed').hide();
		    	$('.restart').show();

		    }
		    $("#turn_cnt").val(turn);
		    
		    console.log(turn);
			let url = "ajaxGameExecuter.php?turn="+turn;
	
		 $.post(url, function(res, status){
              if(res)
              {
              	$('.gameBody').show();
              	data = jQuery.parseJSON(res);
              	//console.log(data);
                let cow_cnt = 2;
                let bunny_cnt =4;

              	var farmerArr = data.all_entity.FARMER.toString().split('#'); if(farmerArr.length > 1) { var farmerStatus = '<span class="label label-danger">Died<label>';}else{var farmerStatus = '<span class="label label-success">Live<label>';}

              	var cow1Arr = data.all_entity.COW1.toString().split('#'); if(cow1Arr.length > 1) { var cow1Status = '<span class="label label-danger">Died<label>';cow_cnt--;}else{var cow1Status = '<span class="label label-success">Live<label>';}

              	var cow2Arr = data.all_entity.COW2.toString().split('#'); if(cow2Arr.length > 1) { var cow2Status = '<span class="label label-danger">Died<label>';cow_cnt--;}else{var cow2Status = '<span class="label label-success">Live<label>';}

              	var bunny1Arr = data.all_entity.BUNNY1.toString().split('#'); if(bunny1Arr.length > 1) { var bunny1Status = '<span class="label label-danger">Died<label>';bunny_cnt--;}else{var bunny1Status = '<span class="label label-success">Live<label>';}

              	var bunny2Arr = data.all_entity.BUNNY2.toString().split('#'); if(bunny2Arr.length > 1) { var bunny2Status = '<span class="label label-danger">Died<label>';bunny_cnt--;}else{var bunny2Status = '<span class="label label-success">Live<label>';}

              	var bunny3Arr = data.all_entity.BUNNY3.toString().split('#'); if(bunny3Arr.length > 1) { var bunny3Status = '<span class="label label-danger">Died<label>';bunny_cnt--;}else{var bunny3Status = '<span class="label label-success">Live<label>';}

              	var bunny4Arr = data.all_entity.BUNNY4.toString().split('#'); if(bunny4Arr.length > 1) { var bunny4Status = '<span class="label label-danger">Died<label>';bunny_cnt--;}else{var bunny4Status = '<span class="label label-success">Live<label>';}

              	var str = '<tr><td>Farmer</td><td>'+farmerArr[0]+'</td><td>'+farmerStatus+'</td></tr>';
              	str += '<tr><td>Cow 1</td><td>'+cow1Arr[0]+'</td><td>'+cow1Status+'</td></tr>';
              	str += '<tr><td>Cow 2</td><td>'+cow2Arr[0]+'</td><td>'+cow2Status+'</td></tr>';
              	str += '<tr><td>Bunny 1</td><td>'+bunny1Arr[0]+'</td><td>'+bunny1Status+'</td></tr>';
              	str += '<tr><td>Bunny 2</td><td>'+bunny2Arr[0]+'</td><td>'+bunny2Status+'</td></tr>';
              	str += '<tr><td>Bunny 3</td><td>'+bunny3Arr[0]+'</td><td>'+bunny3Status+'</td></tr>';
              	str += '<tr><td>Bunny 4</td><td>'+bunny4Arr[0]+'</td><td>'+bunny4Status+'</td></tr>';
              	
              	$('#count_table').append('<button type="button" class="btn btn_custom">'+turn+'<br><span class="label label-warning">'+data.recent_entity+'</span></button>');
		            //console.log(bunny_cnt+', '+cow_cnt);
              	$('#tablebody').html(str);
              	if(data.all_die_entity=='yes')
              	{
              		$('.feed').hide();
      		    		$('.restart').show();
      		    		$('.label-success').html('Died').removeClass('label-success').addClass('label-danger');
                  $('#disp_msg').html('<div class="alert alert-danger" role="alert">Farmer died, Game Over!</div>');
              	}
                else if(turn ==50 && data.all_die_entity=='no' && cow_cnt>=1 && bunny_cnt>=1)
                {
                  $('.feed').hide();
                  $('.restart').show();
                  $('#disp_msg').html('<div class="alert alert-success" role="alert">Congrats, You won the game!</div>');
                }
                else if(turn==50)
                {
                  $('.feed').hide();
                  $('.restart').show();
                }

               

              }
          });    
	}

</script>

</html>
