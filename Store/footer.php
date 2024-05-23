<!-- 
    - #FOOTER
  -->

<footer class="footer">

  <div class="footer-top section">
    <div class="container">

      <div class="footer-brand">

        <a href="#" class="logo">
          <img src="./assets/images/logo.svg" width="160" height="50" alt="Footcap logo">
        </a>

        <ul class="social-list">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-pinterest"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

        </ul>

      </div>

      <div class="footer-link-box">

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Contact Us</p>
          </li>

          <li>
            <address class="footer-link">
              <ion-icon name="location"></ion-icon>

              <span class="footer-link-text">
                2751 S Parker Rd, Aurora, CO 80014, United States
              </span>
            </address>
          </li>

          <li>
            <a href="tel:+557343673257" class="footer-link">
              <ion-icon name="call"></ion-icon>

              <span class="footer-link-text">+557343673257</span>
            </a>
          </li>

          <li>
            <a href="mailto:footcap@help.com" class="footer-link">
              <ion-icon name="mail"></ion-icon>

              <span class="footer-link-text">footcap@help.com</span>
            </a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">My Account</p>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward-outline"></ion-icon>

              <span class="footer-link-text">My Account</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward-outline"></ion-icon>

              <span class="footer-link-text">View Cart</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward-outline"></ion-icon>

              <span class="footer-link-text">Wishlist</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward-outline"></ion-icon>

              <span class="footer-link-text">Compare</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="chevron-forward-outline"></ion-icon>

              <span class="footer-link-text">New Products</span>
            </a>
          </li>

        </ul>

        <div class="footer-list">

          <p class="footer-list-title">Opening Time</p>

          <table class="footer-table">
            <tbody>

              <tr class="table-row">
                <th class="table-head" scope="row">Mon - Tue:</th>

                <td class="table-data">8AM - 10PM</td>
              </tr>

              <tr class="table-row">
                <th class="table-head" scope="row">Wed:</th>

                <td class="table-data">8AM - 7PM</td>
              </tr>

              <tr class="table-row">
                <th class="table-head" scope="row">Fri:</th>

                <td class="table-data">7AM - 12PM</td>
              </tr>

              <tr class="table-row">
                <th class="table-head" scope="row">Sat:</th>

                <td class="table-data">9AM - 8PM</td>
              </tr>

              <tr class="table-row">
                <th class="table-head" scope="row">Sun:</th>

                <td class="table-data">Closed</td>
              </tr>

            </tbody>
          </table>

        </div>

        <div class="footer-list" id="footer-list">

          <p class="footer-list-title">Write Review</p>

          <p class="newsletter-text">
            Authoritatively morph 24/7 potentialities with error-free reviews.
          </p>

          <!-- <form action="" class="newsletter-form"> -->
          <input type="text" id="review"  placeholder="Review" class="newsletter-input" required>
          <input type="number" id="order_id" placeholder="Order Id" class="newsletter-input" required>

          <button type="submit" onclick="return writeReview()" class="btn btn-primary">Write </button>
          <!-- </form> -->

        </div>

      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">

      <p class="copyright">
        &copy; 2022 <a href="#" class="copyright-link">codewithsadee</a>. All Rights Reserved
      </p>

    </div>
  </div>

</footer>





<!-- 
    - #GO TO TOP
  -->

<a href="#top" class="go-top-btn" data-go-top>
  <ion-icon name="arrow-up-outline"></ion-icon>
</a>





<!-- 
    - custom js link
  -->
<script src="./assets/js/script.js"></script>

<!-- 
    - ionicon link
  -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
  <?php if (isset($s_id)) { ?>
    var s_id = <?php echo $s_id; ?>;
  <?php } ?>
  function writeReview() {
    let order_id = document.getElementById("order_id").value;
    let review = document.getElementById("review").value;
    console.log(order_id);
    console.log(review);
    $.ajax({
      url: '/../../reward_system/ajax_review.php',
      type: 'get',
      data: {
        s_id: s_id,
        order_id: order_id,
        review: review,
        option: 1,
      },
      // dataType: 'JSON',
      success: function (response) {
        alert(s_id, order_id, review, 1);
        console.log(s_id, order_id, review, 1);
        console.log(response);
      }
    });
  }
</script>
</body>

</html>