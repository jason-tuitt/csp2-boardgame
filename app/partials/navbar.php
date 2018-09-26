
<style type="text/css">
  #subNavBarContainer,
  .subNavBarUl,
  .subNavBarLi {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }

  #subNavBarContainer {
    background-color: #364652;
    display: flex;
    flex: 1;
    justify-content: flex-end;
  }

  .subNavBarUl {
    list-style: none;
    display: flex;
    justify-content: flex-end;
    margin-right: 2rem;
    background-color: lightgrey;
  }

  .subNavBarLi {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 2px 5px 2px 10px;
    margin-left: 10px;
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

</style>

<header id="headerNavigation">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Board Game Store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
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
        Welcome, 
        <span> 
          <?php 
          if(!isset($_SESSION['user_data'])) echo 'Guest';
          else echo $_SESSION['user_data']['first_name'];
          ?>
        </span>
      </li>
    </ul>
    <ul class='subNavBarUl'>
      <li class="subNavBarLi">
        <?php 
        if(!isset($_SESSION['user_data'])) echo '<a class="cart-register" href="./register.php">Register</a>';
        else echo '<a class="cart-register" href="./cart.php">Go to my Cart<span id="cartQuantity">'.$_SESSION['cartQuantity'].'</span></a>'; 
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