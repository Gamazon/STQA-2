<?php
    require_once "pdo.php";
    session_start();
    if(!(isset($_SESSION["id_cust"])))
    {
      session_destroy();
      die('<div style="display: id="sessionMessage" block; font-size: 1.5em; width: 20%; margin: 0px auto 0px auto;">Please log in to continue shopping!&#128533;</div>');
    }
    if(isset($_POST["addToCart"]))
    {
      if(isset($_POST["prod_quant"]) && $_POST["prod_quant"]>0)
      {
        if(isset($_POST["prod_name"]) && strlen($_POST["prod_name"])>0)
        {
          $stmt = $pdo->prepare('SELECT prod_id from product where name = :id');
          $stmt->execute(array( ':id' => $_POST["prod_name"]));
          if($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
            $stmt1 = $pdo->prepare("SELECT order_id, quantity from cart where cust_id = ".$_SESSION['id_cust']." AND prod_id = ".$row['prod_id']);
            $stmt1->execute();
            if($temp = $stmt1->fetch(PDO::FETCH_ASSOC))
            {
              $quant = $temp['quantity'] + $_POST["prod_quant"] ;
              $stmt2 = $pdo->prepare("UPDATE cart SET quantity =:qt where cust_id = ".$_SESSION['id_cust']." AND prod_id = ".$row["prod_id"]);
              $temp = $stmt2->execute(array(':qt' => $quant));
              $_SESSION["success"] = $_POST["prod_name"].' is successfully added to cart.';    
            }
            else 
            {
              $stmt2 = $pdo->prepare("INSERT INTO cart(cust_id, prod_id, quantity) VALUES (".$_SESSION['id_cust'].",".$row["prod_id"].",".$_POST["prod_quant"].");");
              $temp = $stmt2->execute(array( ':qt' => $_POST["prod_quant"]));
              $_SESSION["success"] = $_POST["prod_name"].' is successfully added to cart.'; 
            }    
          }
          else
          {
            $_SESSION["error"] = "Can't find the product in database.";
          }
        }
        else{
          $_SESSION["error"] = 'Product name is mandatory.';
        }
      }
      else{
        $_SESSION["error"] = 'Product quantity must be greater than 1.';
      }
          header("Location: products.php");
    return;
    }
?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Page</title>
    <link rel="stylesheet" href="style.css"> </link>
    <link rel="stylesheet" href="style2.css"> </link>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <style>
    

    </style>


</head>
<body>
    <header>
    <nav class="navbar navbar-light">
    <a class="navbar-brand" href="#">
      <img src="logo.PNG" id="logo" alt="Home" loading="lazy">
    </a>

    <ul class="nav justify-content-end">

      <li class="nav-item">
       <span class="nav-link" onclick="window.location.hash = '#fruits';">Fruits</span> 
      </li>

      <li class="nav-item">
        <span class="nav-link" onclick="window.location.hash = '#herbs';">Herbs</span> 
       </li>

        <li class="nav-item">
        <button class="productButtons" id="userInfo" onclick="location.href = 'user.php';">
          <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        </svg>
      </button>
        </li>
        
        <li class="nav-item">
        <button class="productButtons" id="cartInfo" onclick="location.href = 'cart.php';">
          <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-cart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
          </svg>
        </button>    
        </li>
          
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Logout</a>
        </li>
      </ul>
    </nav>
    </header>


    <div id="container">
    <div class="fruitCategory" id="fruits">
      <div id="container">
        <?php
          if ( isset($_SESSION['error']) ) {
            echo('<div class="alert alert-danger" id="productsError" role="alert" style="display: block; height:46px; top:10px; width: 60%; margin: 0px auto 0px auto;">');
            echo(htmlentities($_SESSION['error'])."&#128533;</p></div>\n");
            unset($_SESSION['error']);
          }
          if ( isset($_SESSION['success']) ) {
            echo('<div class="alert alert-success" id="productsSuccess" role="alert" style="display: block; height:46px; top:10px; width: 60%; margin: 0px auto 0px auto;">');
            echo(htmlentities($_SESSION['success'])."&#128516;</p></div>\n");
            unset($_SESSION['success']);
          }
        ?>
        <div class="categoryHead">
          <h3>FRUITS</h3>
          <p>Fruit is nature's Candy!</p>
        </div>
        <hr class="myhr">
        <div class="products">
          <p>Our widest range of nutritious Fruits</p>
          <div class="row">
            <div class="column">
              <div class="productCard">
                <img src="apple.jpg" alt="Apples" style="width:100%">
                <h2>Apple</h2>
                <p class="price">&#x20B9;180 per kg</p>
                <p>100% Wax free. Good source of Vitamin C, Dietary Fiber, Flavonoids and antioxidants.</p>
                <p><button type="button" id="Apple" name="Apple" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
              </div>
            </div>
            <div class="column">
              <div class="productCard">
                <img src="oranges.jpg" alt="Orange" style="width:100%">
                <h2>Orange</h2>
                <p class="price">&#x20B9;60 per kg</p>
                <p>Rich in Vitamin C and Potassium. Act as natural coolants and have antiseptic properties</p>
                <p><button type="button" id="Orange" name="Orange" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
              </div>
            </div>
            <div class="column">
              <div class="productCard">
                <img src="grapes.jpg" alt="Grapes" style="width:100%">
                <h2>Grapes</h2>
                <p class="price">&#x20B9;55 per kg</p>
                <p>Packed with nutrients and antioxidants, has high amounts of the phytonutrient resveratrol which is good for the heart</p>
                <p><button type="button" id="Grapes" name="Grapes" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
              </div>
            </div>   
          </div>
          <div class="row">
            <div class="column">
              <div class="productCard">
                <img src="mango.jpg" alt="Mango" style="width:100%">
                <h2>Mango</h2>
                <p class="price">&#x20B9;500 per Dozen</p>
                <p>Improves immunity, digestive health and eyesight, as well as lowers the risk of certain cancers.</p>
                <p><button type="button" id="Mango" name="Mango" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
              </div>
            </div>
            <div class="column">
              <div class="productCard">
                <img src="banana.jpg" alt="Banana" style="width:100%">
                <h2>Banana</h2>
                <p class="price">&#x20B9;60 per Dozen</p>
                <p>Rich in potassium, vitamin C, B6 and Dietary Fiber</p>
                <p><button type="button" id="Banana" name="Banana" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
              </div>
            </div>
            <div class="column">
              <div class="productCard">
                <img src="papaya.jpg" alt="Papaya" style="width:100%">
                <h2>Papaya</h2>
                <p class="price">&#x20B9;50 per kg</p>
                <p>Good source of magnesium, potassium, calcium, dietary fiber, vitamins A and C</p>
                <p><button type="button" id="Papaya" name="Papaya" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
              </div>
            </div>   
          </div>
        </div>
      </div>
      </div>

    
    <div class="herbCategory" id="herbs">
      <div class="categoryHead">
        <h3>HERBS</h3>
        <p>Food is incomplete without Herbs!</p>
      </div>
      <hr class="myhr">
      <div class="products">
        <p>Our widest range of nutritious Fruits</p>
        <div class="row">
        <div class="column">
          <div class="productCard">
            <img src="mint.jpg" alt="Mint" style="width:100%">
            <h2>Mint</h2>
            <p class="price">&#x20B9;50 per 30g</p>
            <p>Contains fair amounts of several nutrients and is an especially good source of vitamin A and antioxidants.</p>
            <p><button type="button" id="Mint" name="Mint" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
          </div>
        </div>
        <div class="column">
          <div class="productCard">
            <img src="sage.jpg" alt="Sage" style="width:100%">
            <h2>Sage</h2>
            <p class="price">&#x20B9;299 per 100g </p>
            <p>Relieves headache and sore throat pain, reducing oxidative stress in the body, protects against free radical damage, reduces inflammation, protects against bacterial and viral infections.</p>
            <p><button type="button" id="Sage" name="Sage" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
          </div>
        </div>  
        <div class="column">
          <div class="productCard">
            <img src="thyme.jpg" alt="Thyme" style="width:100%">
            <h2>Thyme</h2>
            <p class="price">&#x20B9;100 per 30g</p>
            <p>Packed with Vitamin C, good source of Vitamin A, copper, fiber, iron and manganese, can be used for treating diarrhea, arthritis, sore throat, cough.</p>
            <p><button type="button" id="Thyme" name="Thyme" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
          </div>
        </div>   
        </div>
        <div class="row">
          <div class="column">
          <div class="productCard">
            <img src="rosemary.jpg" alt="Rosemary" style="width:100%">
            <h2>Rosemary</h2>
            <p class="price">&#x20B9;99 per 50g</p>
            <p>Helps to boost the immune system and improve blood circulation, considered as a cognitive stimulant and can help improve memory performance and quality.</p>
            <p><button type="button" id="Rosemary" name="Rosemary" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
          </div>
          </div>
          <div class="column">
            <div class="productCard">
              <img src="parsley.jpg" alt="Parsley" style="width:100%">
              <h2>Parsley</h2>
              <p class="price">&#x20B9;60 per 30g</p>
              <p>Rich in antioxidants and nutrients like vitamins A, K, and C, parsley may improve blood sugar and support heart, kidney, and bone health.</p>
              <p><button type="button" id="Parsley" name="Parsley" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
            </div>
          </div>
        <div class="column">
          <div class="productCard">
            <img src="basil.jpg" alt="Basil" style="width:100%">
            <h2>Basil</h2>
            <p class="price">&#x20B9;125 per 30g</p>
            <p> Improves digestive health, aid in weight loss, regulates blood sugar, cools the body, relives stress, reduces inflammation and prevents certain infections.</p>
            <p><button  type="button" id="Basil" name="Basil" onclick="getValue(this)" data-toggle="modal" data-target="#staticBackdrop">Add to Cart</button></p>
          </div>
        </div>
          </div>
      </div>
    </div>

    
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Item</h5>
          </div>
          <div class="alert alert-danger" id="alert" role="alert" style="display: none;">
            Alert! Quantity must be greater than 0.
          </div>
          
          <div class="alert alert-success" id="success" role="alert" style="display: none;">
            Congratulations! Item has been added to Cart.
          </div>
          <form id="productForm" name="productForm" method="POST">
            <div class="modal-body" >
              <span class="modalSpans" id="item_name">Item Name</span>
              <span class="modalSpans" id="item_price">Item Price</span>
              <span class="modalSpans" >X</span>
              <span class="modalSpans" id="itemCount">1</span>
              <span class="modalSpans" >=</span>
              <span class="modalSpans" id="total_price"></span>
              <input type="hidden" id="prod_name" name="prod_name">
              <input type="hidden" id="prod_quant" name="prod_quant" value="1"> 
              <div class="outerDiv" style="display: inline;">
                <div class="innerDiv">
                  <span class="modalSpans">Qt.</span> 
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decrementFunc();" id="decrement"> - </button>
                <span id="itemCount2">1</span>    
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="incrementFunc();" id="increment">+</button>
                  </div>
              </div>
              </span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" onclick="clearCart()" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-outline-success" onclick="addToCart()" id="addToCart" name="addToCart" value="cartAdd" >Add to Cart</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    
    
   
    <script lang="JavaScript" src="products.js"></script>
</body>
</html>

