# Farm Game

**Design Pattern Used**

  - Abstract Factory
      Here I  want to encapsulate the logic of choice, what of the factories use to a given task.

**File Structure**

  - index.php
 	Main application executer. where all UI part & jquery Ajax call is included
 - ajaxGameExecuter.php
    This is one Ajax Calling file which routes us to start farm game function
 - farmFactory.php
    All OOPS Logic is included here. Also, In this file I also shown how to do basic error handling


**OOPS Logic in farmFactory**
 - Config Class
      - This class acts like a configuration class. all static constants are mentioned here

 - fedInterface
      - This Interface include the 2 important function definition i.e. storeFedTurns,checkTurnLimit

 - abstractFarmGameFactory
      - This class contain one static function called 'startFarmGame' & here I encapsulate the logic of choice to hide the complexity of application

 - customException
      - This class contain errorMessage function if any error occur while executing the game

 - displayGameResult
      - This class shows the messge at the end of game execution

 - terminateGame
      - This class executes when game is over all when exception case came

 - continueGame
      - This case will executes in ideal conditions.
      - The function goForAction will randomly choose our entity i.e. Farmer, Cow & Bunny to fed.                    
 - farmLand
     - This class implements the fedInterface.
     - This class contain all operations like storing fed count of each animal & also keeps the track on feeding
