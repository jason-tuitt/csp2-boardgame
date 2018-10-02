
<style type="text/css">
  #subNavBarContainer,
  .subNavBarUl,
  .subNavBarLi {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }

  #subNavBarContainer {
    background-color: #000000c9;
    display: flex;
    flex: 1;
    justify-content: flex-end;
    color:white;
  }

  .subNavBarUl {
    list-style: none;
    display: flex;
    justify-content: flex-end;
    margin-right: 2rem;
    padding: 4px;
    /*background-color: #000000c9;*/
  }

  .subNavBarLi {
    display: flex;
/*    justify-content: flex-end;
    align-items: center;*/
    padding: 0px 15px;
    margin: 3px 0px;
    border-left: 2px solid white;
    text-align: center;
  }

  .subNavBarUl li:last-child {
    border-right: 1.5px solid white;
  }

  .subNavBarLi a:active,
  .subNavBarLi a:hover,
  .subNavBarLi a:visited,
  .subNavBarLi a:link {
    color:white;
  }

  #headerNavigation h1,
  #headerNavigation h1:active,
  #headerNavigation h1:hover,
  #headerNavigation h1:visited,
  #headerNavigation h1:link {
    color:black;
    text-decoration: none;
  }

  #headerNavigation {
    position: fixed;
    top:0;
    left: 0;
    width: 100%;
    /*margin-bottom: 5px;*/
    z-index: 10000;
  }


  span#cartQuantity {
    background-color: #071108 !important;
    margin: 0 5px;
    padding: 0px 2px;
    color: white;
    border-radius: 5px;
  }

  .mainnavbar {
    height: 10vh !important;
    display: flex;
    background-color: white !important;
    color:black !important;
  }

  #navleft {
    flex:2;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-content: flex-start;
    padding-left: 30px;
  }

  #navleft h1,
  #navleft h3,
  #navleft a {
    padding: 0;
    margin:0;
  }

  #navcenter{
    flex:2;
    display: flex;
    align-items: flex-end;
  }

  #navcenter input {
    width:50%;
    margin-right: 10px;
    padding: 3px 8px;
    border-radius: 15px;
    border: 1px solid #000000c9;
    /*background-color: #00000015;*/
    background-color: #00000013;
    margin-bottom: 20px;
  }

  #navcenter span {
    margin-bottom: 20px;
    padding:5px 10px;
  }

  #navcenter span:hover {
    cursor: pointer;
    background-color: #00000015;
    /*color:white;*/
    /*padding:5px;*/
    border-radius: 10px;
  }

  #navcenter input:focus {
    background-color: #f1f1f1;
    outline: none;
  }

  #navright{
    flex:1;
    display: flex;
    list-style: none;
    justify-content: center;
    align-content: flex-end;
    align-items: flex-end;
  }

  #navright li {
    list-style: none;
  }
  #navright i {
    margin-right: 10px; 
  }



</style>

<header id="headerNavigation">
<nav class="mainnavbar navbar-expand-lg">
  <div id="navleft">
    <a class="navbar-brand" href="#"><h1>The Bored Gamer</h1></a>
    <h3 class="navbar-brand">Curing boredom, one boardgame at a time.</h3>
  </div>
  <div id="navcenter">
    <input type="text" placeholder="Search for a game!">
    <span><i class="fas fa-search"></i></a></span>
  </div>
  <div id="navright">
    <ul>
      <li><i class="fab fa-facebook"></i><span>Facebook</span></li>
      <li><i class="fab fa-twitter-square"></i><span>Twitter</span></li>
      <li><i class="fab fa-instagram"></i><span>Instagram</span></li>
    </ul>
  </div>
</nav>
<nav id='subNavBarContainer'>
  <div id="subNavLeft">
  </div>
  <div id="subNavRight">
    <ul class='subNavBarUl'>
      <li class="subNavBarLi">
        <?php 
          if(!isset($_SESSION['user_data'])) echo '<a href="./login.php">Wishlist</a>';
          else echo '<a href="./catalog.php">Wishlist</a>';
        ?>
      </li>
      <li class="subNavBarLi">
        <?php 
          if(!isset($_SESSION['user_data'])) echo '<a href="./login.php">Track My Orders</a>';
          else echo '<a href="./view_orders.php">Track My Orders</a>';
        ?>
      </li>
      <li class="subNavBarLi">
        <span> 
          <?php 
          if(!isset($_SESSION['user_data'])) echo 'Guest';
          else {
            // echo '<a href="../views/account.php">'.$_SESSION['user_data']['first_name'].'</a>';
            echo '<a href="../views/account.php">My Account</a>';
          }
          ?>
        </span>
      </li>
    <!-- </ul> -->
    <!-- <ul class='subNavBarUl'> -->
      <li class="subNavBarLi">
        <?php 
        if(!isset($_SESSION['user_data'])) echo '<a class="cart-register" href="./register.php">Register</a>';
        else echo '<a class="cart-register" href="./cart.php">My Cart <i class="fas fa-shopping-cart"></i><span id="cartQuantity">'.$_SESSION['cartQuantity'].'</span></a>'; 
        ?>
      </li>
      <li class="subNavBarLi">
        <?php 
          if(!isset($_SESSION['user_data'])) echo '<a href="./login.php">Login</a>';
          else echo '<a href="../controllers/logout.php">Logout</a>';
         ?>
      </li>
    </ul>
  </div>
</nav>
</header>