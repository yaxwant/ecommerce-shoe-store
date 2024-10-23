<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enhanced UI</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    .carousel-inner {
      background-color: #ffceff;
    }
    .carousel-item h1 {
      font-size: 3rem;
    }
    .carousel-item h2 {
      font-size: 1.75rem;
    }
    .carousel-item p {
      font-size: 1.1rem;
    }
    .product-image-wrapper {
      margin-bottom: 30px;
    }
    .product-image-wrapper .single-products {
      border: 1px solid #f1f1f1;
      padding: 15px;
      transition: transform 0.3s;
    }
    .product-image-wrapper .single-products:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    }
    .product-overlay {
      background: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.3s;
    }
    .product-image-wrapper:hover .product-overlay {
      opacity: 1;
    }
  </style>
</head>
<body>

<section id="slider">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div id="slider-carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#slider-carousel" data-slide-to="1"></li>
            <li data-target="#slider-carousel" data-slide-to="2"></li>
          </ol>
          
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row">
                <div class="col-sm-6">
                  <h1><span>AY</span>-SHOP</h1>
                  <h2>E commerce Site</h2>
                  <p>Welcome To Our Shopping Mart For Your Ease.</p>
                </div>
                <div class="col-sm-6">
                  <img src="images/home/girl1.jpg" class="girl img-fluid" alt="">
                  <img src="images/home/pricing.png" class="pricing img-fluid" alt="">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row">
                <div class="col-sm-6">
                  <h1><span>AY</span>-SHOP</h1>
                  <h2>100% Responsive Design</h2>
                  <p>Welcome To Our Shopping Mart For Your Ease.</p>
                </div>
                <div class="col-sm-6">
                  <img src="images/home/girl2.jpg" class="girl img-fluid" alt="">
                  <img src="images/home/pricing.png" class="pricing img-fluid" alt="">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row">
                <div class="col-sm-6">
                  <h1><span>AY</span>-SHOP</h1>
                  <h2>E commerce site</h2>
                  <p>Welcome To Our Shopping Mart For Your Ease.</p>
                </div>
                <div class="col-sm-6">
                  <img src="images/home/girl3.jpg" class="girl img-fluid" alt="">
                  <img src="images/home/pricing.png" class="pricing img-fluid" alt="">
                </div>
              </div>
            </div>
          </div>
          
          <a href="#slider-carousel" class="carousel-control-prev" role="button" data-slide="prev">
            <i class="fas fa-angle-left"></i>
          </a>
          <a href="#slider-carousel" class="carousel-control-next" role="button" data-slide="next">
            <i class="fas fa-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <?php include 'sidebar.php'; ?>
      </div>
      <div class="col-sm-9">
        <div class="features_items">
          <h2 class="title text-center">Features Items</h2>
          
          <?php
          $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                    WHERE pr.`PROID`=p.`PROID` AND p.`CATEGID` = c.`CATEGID` AND PROQTY>0";
          $mydb->setQuery($query);
          $cur = $mydb->loadResultList();
          
          foreach ($cur as $result) {
          ?>
          <div class="col-sm-4">
            <div class="product-image-wrapper">
              <div class="single-products">
                <form method="POST" action="cart/controller.php?action=add">
                  <input type="hidden" name="PROPRICE" value="<?php echo $result->PROPRICE; ?>">
                  <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $result->PROQTY; ?>">
                  <input type="hidden" name="PROID" value="<?php echo $result->PROID; ?>">
                  <div class="productinfo text-center">
                    <img src="<?php echo web_root . 'admin/products/' . $result->IMAGES; ?>" class="img-fluid" alt="">
                    <h2>&#8369; <?php echo $result->PRODISPRICE; ?></h2>
                    <p><?php echo $result->PRODESC; ?></p>
                    <button type="submit" name="btnorder" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                  </div>
                  <div class="product-overlay">
                    <div class="overlay-content">
                      <h3>&#8369; <?php echo $result->PRODISPRICE; ?></h3>
                      <p><?php echo $result->PRODESC; ?></p>
                      <button type="submit" name="btnorder" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="choose">
                <ul class="nav nav-pills nav-justified">
                  <li>
                    <?php
                    if (isset($_SESSION['CUSID'])) {
                      echo '<a href="' . web_root . 'customer/controller.php?action=addwish&proid=' . $result->PROID . '" class="btn btn-danger"><i class="fas fa-plus-square"></i> Add to wishlist</a>';
                    } else {
                      echo '<a href="#" class="btn btn-danger" data-target="#smyModal" data-toggle="modal" data-id="' . $result->PROID . '"><i class="fas fa-plus-square"></i> Add to wishlist</a>';
                    }
                    ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>

        <div class="recommended_items">
          <h2 class="title text-center">Recommended Items</h2>
          <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row">
                  <?php
                  $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                            WHERE pr.`PROID`=p.`PROID` AND p.`CATEGID` = c.`CATEGID` AND PROQTY>0 LIMIT 3";
                  $mydb->setQuery($query);
                  $cur = $mydb->loadResultList();
                  
                  foreach ($cur as $result) {
                  ?>
                  <div class="col-sm-4">
                    <div class="product-image-wrapper">
                      <div class="single-products">
                        <form method="POST" action="cart/controller.php?action=add">
                          <input type="hidden" name="PROPRICE" value="<?php echo $result->PROPRICE; ?>">
                          <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $result->PROQTY; ?>">
                          <input type="hidden" name="PROID" value="<?php echo $result->PROID; ?>">
                          <div class="productinfo text-center">
                            <img src="<?php echo web_root . 'admin/products/' . $result->IMAGES; ?>" class="img-fluid" alt="">
                            <h2>&#8369; <?php echo $result->PRODISPRICE; ?></h2>
                            <p><?php echo $result->PRODESC; ?></p>
                            <button type="submit" name="btnorder" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="carousel-item">
                <div class="row">
                  <?php
                  $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                            WHERE pr.`PROID`=p.`PROID` AND p.`CATEGID` = c.`CATEGID` AND PROQTY>0 LIMIT 3,6";
                  $mydb->setQuery($query);
                  $cur = $mydb->loadResultList();
                  
                  foreach ($cur as $result) {
                  ?>
                  <div class="col-sm-4">
                    <div class="product-image-wrapper">
                      <div class="single-products">
                        <form method="POST" action="cart/controller.php?action=add">
                          <input type="hidden" name="PROPRICE" value="<?php echo $result->PROPRICE; ?>">
                          <input type="hidden" id="PROQTY" name="PROQTY" value="<?php echo $result->PROQTY; ?>">
                          <input type="hidden" name="PROID" value="<?php echo $result->PROID; ?>">
                          <div class="productinfo text-center">
                            <img src="<?php echo web_root . 'admin/products/' . $result->IMAGES; ?>" class="img-fluid" alt="">
                            <h2>&#8369; <?php echo $result->PRODISPRICE; ?></h2>
                            <p><?php echo $result->PRODESC; ?></p>
                            <button type="submit" name="btnorder" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#recommended-item-carousel" role="button" data-slide="prev">
              <i class="fas fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#recommended-item-carousel" role="button" data-slide="next">
              <i class="fas fa-angle-right"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
