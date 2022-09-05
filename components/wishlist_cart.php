<?php

if(isset($_POST['add_to_wishlist'])){

   if($id == 'false'){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name ='$name' AND id ='$id'");
      $check_wishlist_numbers->execute([$name, $id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name ='$name' AND id ='$id'");
      $check_cart_numbers->execute([$name, $id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $message[] = 'already added to wishlist!';
      }elseif($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      }else{
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(pid, name, price, image) VALUES('$pid','$name','$price','$image')");
         $insert_wishlist->execute([$pid, $name, $price, $image]);
         $message[] = 'added to wishlist!';
      }

   }

}

if(isset($_POST['add_to_cart'])){

   if($id == 'false'){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name ='$name' AND id ='$id'");
      $check_cart_numbers->execute([$name, $id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      }else{

         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name ='$name' AND id ='$id'");
         $check_wishlist_numbers->execute([$name, $id]);

         if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name ='$name' AND id ='$id'");
            $delete_wishlist->execute([$name, $id]);
         }

         $insert_cart = $conn->prepare("INSERT INTO `cart`(pid, name, price, qty, image) VALUES('$pid','$name','$price','$qty','$image')");
         $insert_cart->execute([$pid, $name, $price, $qty, $image]);
         $message[] = 'added to cart!';
         
      }

   }

}

?>