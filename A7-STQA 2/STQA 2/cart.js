var num = 0;
var prod_rate = 0;
var total = 0;
function decrement(elem){
  num = document.getElementById("itemCount"+elem).innerHTML;
  if(num>0)
  {
    prod_rate = document.getElementById("itemRate"+elem).innerHTML;
    total = document.getElementById("totalPrice").innerHTML; 
    total-=parseInt(prod_rate);
    num--;
    document.getElementById("itemCount"+elem).innerHTML = num;
    document.getElementById("prod_quant"+elem).value = num;
    document.getElementById("itemPrice"+elem).innerHTML = prod_rate*num;
    document.getElementById("totalPrice").innerHTML = total;
  }
}
function increment(elem){
  num=0;
  num = document.getElementById("itemCount"+elem).innerHTML;
  prod_rate = document.getElementById("itemRate"+elem).innerHTML; 
  total = document.getElementById("totalPrice").innerHTML;
  total = parseInt(total) + parseInt(prod_rate); 
  document.getElementById("itemCount"+elem).innerHTML = ++num;
  document.getElementById("prod_quant"+elem).value = num;   
  document.getElementById("itemPrice"+elem).innerHTML = prod_rate*num;
  document.getElementById("totalPrice").innerHTML = total;
  num=0;
}

