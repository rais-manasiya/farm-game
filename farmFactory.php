<?php
class Config {// all hardcode things

   //Static Members
    public static $entity_limit = array('FARMER'=>15,'COW1'=>10,'BUNNY1'=>8,'COW2'=>10,'BUNNY2'=>8,'BUNNY3'=>8,'BUNNY4'=>8);
    public static $entity_count = array('FARMER'=>0,"COW"=>0,"BUNNY"=>0);
    public static $turn = 0;
    public static $total_turn_limit =50;
    public static $all_die_entity = 'no';
    public static $all_entity = array('FARMER'=>0,'COW1'=>0,'BUNNY1'=>0,'COW2'=>0,'BUNNY2'=>0,'BUNNY3'=>0,'BUNNY4'=>0);

    //non-static Members
    private static $instance = null;  
    public static function getInstance() ///Here I have shown Singltan pattern example which is Very easy  non-static members of the class
      {
        if (self::$instance == null)
        {
          self::$instance = new Config();
        }
        return self::$instance;
      }
}

Interface fedInterface {// Farm animal fedding interface
    public function storeFedTurns($entity,$en_key);//It stores the fed turns of all Animals 
    public function checkTurnLimit();  //for checking the turn limit of all animals
    public function __construct($entity,$turn);
   } 

abstract class abstractFarmGameFactory {//Farm Abstract factory metods
  
    public static function startFarmGame($turn) {//game starting function

      try{

       if($turn==Config::$total_turn_limit )//termination condition
          
                return new terminateGame();
       if($turn>Config::$total_turn_limit || $_SESSION['farm_game']['all_die_entity'] === 'yes')//Quickly show the reset message after 50 turns..here we can add more functionality like we can display game result
                return new displayGameResult($turn);
                        
        if($turn>=0 && $turn<Config::$total_turn_limit)//quick start the game activity here
                return new continueGame($turn);

        throw new customException("Bad Turns");       
        }
      catch(customException $e)  {
           echo $e->errorMessage();
           return new terminateGame();
      }
       
    }
    abstract public function goForAction();
}

class customException extends Exception {
  public function errorMessage() {
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile().': <b>'.$this->getMessage().'</b> is not a valid Turns';
    $_SESSION['farm_game']['game_status'] = $errorMsg;
    return $errorMsg;
  }
}

class displayGameResult extends abstractFarmGameFactory {
    public function goForAction() {
        $_SESSION['farm_game']['game_status'] = 'Turns are Over! Reset Your Game by refreshing page!!';
        return;
    }
}

class terminateGame extends abstractFarmGameFactory {
    public function goForAction() {
        $_SESSION['farm_game']['game_status'] = 'Game Over!!';
        return;
    }
}


class continueGame extends abstractFarmGameFactory {

    private $whose_turn,$turn;
    public function __construct($turn)
    {
      $this->turn = $turn;
    
    }
    
    public function goForAction() {
      $this->whose_turn =array_rand($this->arrayExclude($_SESSION['farm_game']['all_entity'],preg_grep('/die$/', $_SESSION['farm_game']['all_entity'])));//To randomly pick animal to fed
      return new farmLand($this->whose_turn,$this->turn);
    }

    function arrayExclude($array, Array $excludeKeys){
    foreach($excludeKeys as $key => $val){
        unset($array[$key]);
    }
    return $array;
  }
}

class farmLand implements fedInterface{

  private $turn;
    public function __construct($entity,$turn)
    {
       $this->turn = $turn;
       $this->storeFedTurns($entity,preg_replace("/[^a-zA-Z]+/", "", $entity));
       $this->checkTurnLimit();
    }

    public function storeFedTurns($entity,$en_key) {
      
      $_SESSION['farm_game']['all_entity'][$entity]++;
      $_SESSION['farm_game']['entity_count'][$en_key]++;
      $_SESSION['farm_game']['recent_entity'] = $entity;
   }

   function checkTurnLimit(){

      foreach($_SESSION['farm_game']['all_entity'] as $entity => $value){
        if(!stristr($_SESSION['farm_game']['all_entity'][$entity],"#die")){
          $limit = Config::$entity_limit[$entity];
          $m = floor($this->turn/$limit);
          if( $m >  $_SESSION['farm_game']['all_entity'][$entity]){
            $_SESSION['farm_game']['all_entity'][$entity]=$_SESSION['farm_game']['all_entity'][$entity].'#die';
            if($entity == 'FARMER'){
              $_SESSION['farm_game']['all_die_entity']='yes';
              $_SESSION['farm_game']['game_status'] = 'Farmer Died!! Game Over!!';
            }
          }
        }
      }
   }

} 
?>