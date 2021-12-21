<?php
  require_once "pdo.php";
  session_start();
  if(!(isset($_SESSION["id_cust"])))
  {
    session_destroy();
    die('<div style="display: block; font-size: 1.5em; width: 20%; margin: 0px auto 0px auto;">Please log in to continue shopping!&#128533;</div>');
  }
  if(isset($_POST["update"]))
  {
    $values = $_POST["total"];
    while($values>0)
    {
      if(isset($_POST["prod_quant".$values]) && $_POST["prod_quant".$values]>=0)
      {
        if(isset($_POST["prod_name".$values]) && strlen($_POST["prod_name".$values])>0)
        {
          $name = $_POST["prod_name".$values];
          $stmt = $pdo->prepare('select prod_id from product where name = :id');
          $stmt->execute(array( ':id' => $name));
          if($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
            $stmt = $pdo->prepare("UPDATE cart SET quantity =:qt where cust_id = ".$_SESSION['id_cust']." AND prod_id=".$row["prod_id"]);
            $temp = $stmt->execute(array( ':qt' => $_POST["prod_quant".$values]));    
          }
          else
          {
            $_SESSION["error"] = "Can't find the product".$_POST["prod_name".$values]." in database.";
          }
        }
        else{
          $_SESSION["error"] = 'Product name is mandatory.';
        }
      }
      else
      {
        $_SESSION["error"] = 'Product quantity must not be negative.';
      }
      $values--;
    }
    $stmt = $pdo->prepare("DELETE FROM cart WHERE quantity = 0 ");
    $temp = $stmt->execute();    
    if(!(isset($_SESSION["error"])))
    {  
      $_SESSION["success"] = 'Your cart is successfully updated.'; 
    }
    header("Location: cart.php");
    return;
  }
  if(isset($_POST["delete"]))
  {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE cust_id =".$_SESSION['id_cust']);
    $temp = $stmt->execute();
    header("Location: products.php");
    return;
  }
  $rows = '<div class="alert alert-danger" id="cartError" role="alert" style="display: block; font-size: 1.4em; width: 60%; margin: 30px auto 0px auto;">
          Cart is Empty!&#128533;</div>';
  $stmt = $pdo->query("SELECT * FROM cart where cust_id =".$_SESSION['id_cust']);
  $cnt = 0;
  $row ="";
  $total=0;
  while($temp=$stmt->fetch(PDO::FETCH_ASSOC))
  {
    $cnt +=1;
    $stmt1 = $pdo->prepare('SELECT * FROM product where prod_id = :id');
    $stmt1->execute(array( ':id' => $temp['prod_id']));
    $prod = $stmt1->fetch(PDO::FETCH_ASSOC);
    $price = $prod['price'] * $temp['quantity'];
    $total += $price;
    $row.= "<input type=\"hidden\" id=\"prod_name".$cnt."\" value =\"".$prod['name']."\" name=\"prod_name".$cnt."\">\n<input type=\"hidden\" id=\"prod_quant".$cnt."\" name=\"prod_quant".$cnt."\" value=".$temp['quantity']." ><tbody>\n<tr>\n<td>" .$cnt ."</td>\n<td>" .$prod['name'] ."</td>\n<td>\n<div class=\"innerDiv\">\n<button type=\"button\"";
    $row.= "class=\"btn btn-outline-dark btn-sm\" onclick=\"decrement(".$cnt.");\" id=\"decrement".$cnt."\"> - </button>\n<span style=\"padding-right: 10px;padding-left: 10px;\" id=\"itemCount".$cnt."\"> ";
    $row.=  $temp['quantity']." </span>\n<button type=\"button\" class=\"btn btn-outline-dark btn-sm\" onclick=\"increment(".$cnt.");\" id=\"increment".$cnt."\">+</button>";
    $row.=  "</div>\n</td>\n<td><span id=\"itemRate".$cnt."\" name=\"itemRate".$cnt."\">".$prod['price']."</span></td>\n<td><span id=\"itemPrice".$cnt."\" name=\"itemPrice".$cnt."\">".$price."</span></td>\n</tr>\n<tr>\n";
  }
  if($cnt>0)
  {
    $rows = "<input type=\"hidden\" id=\"total\" value =".$cnt." name=\"total\"><div id=\"tableDiv\">\n<table>\n<thead>\n<tr>\n<th>#</th>\n<th>Product Name</th>\n<th>Quantity</th>\n<th>Rate</th>\n<th>Price</th>\n</tr>\n</thead>";
    $rows.= $row."<td>Total</td>\n<td></td>\n<td></td>\n<td></td>\n<td><span id=\"totalPrice\" name=\"totalPrice\">".$total."</span></td>\n</tr>\n</tbody>\n</table>\n<button type=\"submit\" name=\"update\" class=\"btn btn-success\" style=\"margin-top: 10px;\">Update</button>";   
    $rows.= "\n<button type=\"button\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#staticBackdrop\" style=\"margin-top: 10px;\">Checkout</button>\n</div>";
  }
  
?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleCart.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <style>
        
      #container{
        height: 100%;
      }
    </style>

</head>



<body>
    <header>
    <nav class="navbar navbar-light" >
    <a class="navbar-brand" href="#">
      <img src="logo.PNG" id="logo" alt="Home" loading="lazy">
    </a>
    <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Logout</a>
        </li>
      </ul>
    </nav>
    </header>
  <form id="cartForm" name="cartForm" method = "POST" >
  <div id="container">
    <?php
      if ( isset($_SESSION['error']) ) {
        echo('<div class="alert alert-danger" id="cartError" role="alert" style="display: block; text-align:center; height:46px; top:25px; width: 60%; margin: 0px auto 0px auto;">');
        echo(htmlentities($_SESSION['error'])."&#128533;</p></div>\n");
        unset($_SESSION['error']);
      }
      if ( isset($_SESSION['success']) ) {
        echo('<div class="alert alert-success" id="cartSuccess" role="alert" style="display: block; text-align:center; height:46px; top:25px; width: 60%; margin: 0px auto 0px auto;">');
        echo(htmlentities($_SESSION['success'])."&#128516;</p></div>\n");
        unset($_SESSION['success']);
      }
    ?>
    <?= $rows;?>
      
  </div>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Order Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert" id="cartModal">
                   Congratulations! Your order has been placed.&#128516;
                  </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="delete" id="delete" >Understood</button>
            </div>
          </div>
        </div>
      </div>
    </form>
   
    <script lang="JavaScript" src="cart.js"></script>
</body>
</html>