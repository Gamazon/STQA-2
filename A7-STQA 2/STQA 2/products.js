var num = 1;
var rate = 0;
function decrementFunc(){
  num = document.getElementById("itemCount").innerHTML;
  if(num>0)
  {
    num--;
    document.getElementById("itemCount").innerHTML = num;
    document.getElementById("itemCount2").innerHTML = num; 
    document.getElementById("prod_quant").value =num;
    document.getElementById("total_price").innerHTML=rate*num;
  }
}
function incrementFunc(){
  num = document.getElementById("itemCount").innerHTML;
  num++;
  document.getElementById("itemCount").innerHTML=num;
  document.getElementById("itemCount2").innerHTML = num;
  document.getElementById("prod_quant").value =num;
  document.getElementById("total_price").innerHTML= rate*num;
}

function addToCart(){
    if(num == 0){
        document.getElementById("alert").style.display = "block";
        setTimeout(function(){
            document.getElementById("alert").style.display = "none";     
        },2000) ;
    }
    else{
        document.getElementById("success").style.display = "block";
        setTimeout(function(){
            document.getElementById("success").style.display = "none";  
            $('#staticBackdrop').modal('hide');
            document.getElementById("itemCount").innerHTML = 1;
            document.getElementById("itemCount2").innerHTML = 1;
            num = 1;
        },2000); 
    }
}
function clearCart(){
  document.getElementById("itemCount").innerHTML = 1;
  document.getElementById("itemCount2").innerHTML = 1;
  num = 1;
  document.getElementById("total_price").innerHTML=0;
}
function getValue(elem)
{
  var x = elem.id;
  switch (x) {
      case "Apple":
        document.getElementById("item_name").innerHTML="Apple";
        document.getElementById("item_price").innerHTML="&#x20B9;180 per kg";
        document.getElementById("prod_name").value = "Apple";
        document.getElementById("total_price").innerHTML="180";
        rate = 180;
        break;
      case "Orange":
        document.getElementById("item_name").innerHTML="Orange";
        document.getElementById("item_price").innerHTML="&#x20B9;60 per kg";
        document.getElementById("prod_name").value = "Orange";
        document.getElementById("total_price").innerHTML="60";
        rate = 60;
        break;
      case "Grapes":
        document.getElementById("item_name").innerHTML="Grapes";
        document.getElementById("item_price").innerHTML="&#x20B9;55 per kg";
        document.getElementById("prod_name").value = "Grapes";
        document.getElementById("total_price").innerHTML="55";
        rate = 55;
        break;
      case "Mango":
        document.getElementById("item_name").innerHTML="Mango";
        document.getElementById("item_price").innerHTML="&#x20B9;500 per Dozen";
        document.getElementById("prod_name").value = "Mango";
        document.getElementById("total_price").innerHTML="500";
        rate = 500;
        break;
      case "Banana":
        document.getElementById("item_name").innerHTML="Banana";
        document.getElementById("item_price").innerHTML="&#x20B9;60 per Dozen";
        document.getElementById("prod_name").value = "Banana";
        document.getElementById("total_price").innerHTML="60";
        rate = 60;
        break;
      case "Papaya":
        document.getElementById("item_name").innerHTML="Papaya";
        document.getElementById("item_price").innerHTML="&#x20B9;50 per kg";
        document.getElementById("prod_name").value = "Papaya";
        document.getElementById("total_price").innerHTML="50";
        rate = 50;
        break;
      case "Mint":
        document.getElementById("item_name").innerHTML="Mint";
        document.getElementById("item_price").innerHTML="&#x20B9;50 per 30g";
        document.getElementById("prod_name").value = "Mint";
        document.getElementById("total_price").innerHTML="50";
        rate = 50;
        break;
      case "Sage":
        document.getElementById("item_name").innerHTML="Sage";
        document.getElementById("item_price").innerHTML="&#x20B9;299 per 100g";
        document.getElementById("prod_name").value = "Sage";
        document.getElementById("total_price").innerHTML="299";
        rate = 299;
        break;
      case "Thyme":
        document.getElementById("item_name").innerHTML="Thyme";
        document.getElementById("item_price").innerHTML="&#x20B9;100 per 30g";
        document.getElementById("prod_name").value = "Thyme";
        document.getElementById("total_price").innerHTML="100";
        rate = 100;
        break;
      case "Rosemary":
        document.getElementById("item_name").innerHTML="Rosemary";
        document.getElementById("item_price").innerHTML="&#x20B9;99 per 50g";
        document.getElementById("prod_name").value = "Rosemary";
        document.getElementById("total_price").innerHTML="99";
        rate = 99;
        break;
      case "Parsley":
        document.getElementById("item_name").innerHTML="Parsley";
        document.getElementById("item_price").innerHTML="&#x20B9;60 per 30g";
        document.getElementById("prod_name").value = "Parsley";
        document.getElementById("total_price").innerHTML="60";
        rate = 60;
        break;
      case "Basil":
        document.getElementById("item_name").innerHTML="Basil";
        document.getElementById("item_price").innerHTML="&#x20B9;125 per 30g";
        document.getElementById("prod_name").value = "Basil";
        document.getElementById("total_price").innerHTML="125";
        rate = 125;
        break;    
      default:
        return false;
  }
}