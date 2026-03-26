<!DOCTYPE html>
<html>
  <head>
    <style>
      .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: white; /* Optional: background to hide page content */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
      }

      #loadingImage {
        width: 100px; /* adjust as needed */
        height: auto;
      }
    </style>
  </head>
    <!-- <body onload="formSubmit()"> -->
    <body>
      <form action="https://uatpaymenthub.infinitium.com/api/pymt/pw/v1.1/payment" method="post" name="frm" id="frm">
        <label for="fname">JWT:</label><br>
        <input type="text" id="jwt" name="jwt" value="<?php echo $jwt;?>"><br>
        <input type="submit" value="Submit">
      </form> 
      <div class="loader-wrapper" id="loaderWrapper">
        <img id="loadingImage" src="https://apimobile.ring.healthcare/assets/logo/785.gif" alt="Loading..." />
      </div>
      <script>
        // function formSubmit(){

        //     document.getElementById("frm").submit();
        // }
        
        // document.addEventListener("DOMContentLoaded", function () {

        //   document.querySelector('label[for="fname"]').style.display = "none";
        //   document.getElementById("jwt").style.display = "none";
        //   document.querySelector('input[type="submit"]').style.display = "none";

        //   setTimeout(function () {
        //     var loadingImage = document.getElementById('loadingImage');
        //     var form = document.getElementById('frm');

        //     if (loadingImage) loadingImage.style.display = 'none';
        //     if (form) form.submit();
        //   }, 3000);
        // });
        
        // $(document).ready(function() {
        //     setTimeout(function() {
        //       $('#loadingMessage').hide();
        //       $('#frm').submit();
        //     }, 3000);
        //   });

        document.addEventListener("DOMContentLoaded", function () {
        document.querySelector('label[for="fname"]').style.display = "none";
        document.getElementById("jwt").style.display = "none";
        document.querySelector('input[type="submit"]').style.display = "none";

        setTimeout(function () {
          var loader = document.getElementById('loaderWrapper');
          if (loader) loader.style.display = 'none';

          var form = document.getElementById('frm');
          if (form) form.submit();
        }, 3000);
      });
      </script>
    </body>
</html>