<?php get_header(); // Includes header.php ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:wght@400;500;700&display=swap');


    .header,
    .footer,
    .top-header,
    .info-items-container,
    .xoo-wsc-basket {
        display: none !important;
    }

    /* Reset and Global */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        font-size: 16px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    a {
        text-decoration: none;
    }
    
    p,li {
        color: black;
    }


    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
        margin-bottom: 220px;
    }

    .lander-header {
        padding: 16px 0;
        background: linear-gradient(68deg, #111 -3.57%, #2d2d2d 68.28%), #000;
        box-shadow: 0 2px 8px #0000000d;
        margin-bottom: 35px;
    }

    .lander-header img {
        display: block;
        margin: 0 auto;
        max-width: 165px;
        padding: 8px;
    }
    
    
    h1 {
        color: #151515;
        font-family: Schibsted Grotesk, sans-serif;
        font-size: 48px;
        font-style: normal;
        font-weight: 700;
        line-height: 130%;
        letter-spacing: -.48px !important;
        text-transform: capitalize;
        padding-top: 0;
        margin: 0 0 0px;
    }
</style>

<div class="lander-single-page">
    <main id="main" class="site-main" role="main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <!-- Optional Header and Content -->
                <!--
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                -->

                <div class="lander-header">
                    <img src="https://therefinedman.co/cdn/shop/files/Fit-styled.png?v=1747521476&width=330" alt="Lander Logo">
                </div>

                <div class="container">
                    <div class="landing-iwt-heading">
                        <h1><?php the_title(); ?> </h1>
                        <h1>We found the best t-shirt</h1>
                    </div>
                    
                    <div style="margin-bottom: 30px; margin-top: 30px;" class="iwt-authorinfo-inline"> 
                        <div class="iwt-author-media"> 
                        <img src="//therefinedman.co/cdn/shop/files/Profile-Picture.png?v=1747521484"></div> 
                        <div class="iwt-author-content"> <div class="iwt-author-name"> 
                        <h4 style="margin-bottom: 0;
    font-size: 15px;">By&nbsp;Harry W.</h4></div> <div class="iwt-author-text"> 
                        <p style="margin-bottom: 0;
    font-size: 13px;">Last Updated March 25, 2025</p></div></div>
                    </div>
                    <style>
                        .iwt-authorinfo-inline .iwt-author-media {
                            width: 54px;
                            height: 54px;
                            border-radius: 128.57px;
                            border: none;
                            overflow: hidden;
                        }
                        .iwt-authorinfo-inline {
                                display: flex  ;
                                align-items: center;
                                gap: 12px;
                            }
                    </style>

                    <div class="hero-content">
                        <div class="iwt-content">
                            <p>
                                In this review, we take the top 5 rated t-shirts for athletic physiques, and put them through our rigorous 8-factor test, to find you the ultimate t-shirt for fit, style, quality, durability and more…
                            </p>
                            <ul>
                                <li>
                                    A great T-shirt follows your natural lines to create what we call a “Tailored Fit” — a sharp, well-proportioned look that tells people you’ve got your life in order. Tailored fit is the epitome of understated confidence — something which gives you that extra edge every time you step into a room.
                                </li>
                                <li>
                                    Most t-shirts today fall into the “fast fashion” category — made with low-quality materials and a disregard of durability. We, on the other hand, are looking for timeless luxury — the kind that people truly notice and appreciate, and which makes you proud to have in your wardrobe.
                                </li>
                                <li>
                                    Lastly, we wear t-shirts everywhere — so we want to find one versatile enough to work everywhere: bar, boardroom, restaurant, office, day-out… you get the idea.
                                </li>
                            </ul>
                        </div>
                        
                        
                        <div class="iwt-block iwt-banner"> 
                            <div class="iwt-banner-media" > 
                                <img src="//therefinedman.co/cdn/shop/files/TA_comparison_article_desktop_3x_3c3b7a34-13cc-4bb9-8b37-6d701c75a3f7.png?v=1747522460" alt="">
                            </div> 
                        </div>
                        
                        <div  style="margin-top: 20px;" class="iwt-block iwt-heading iwt-block-title_V7gctC"> <h2>What to Look for in the Perfect Athletic Fit Shirt</h2></div>
                        
                        <div class="iwt-block iwt-content check-listing iwt-block-content_ck9NLH"> <p>Investing in high-quality fabrics with performance features like stretch, moisture-wicking, and breathability can make all the difference in fit and function. When choosing the best shirt for a muscular physique, consider the following key factors:</p><ul><li><strong>Fit &amp; Tailoring</strong> – Shirts should contour the body without excess fabric or tight restrictions.</li><li><strong>Fabric &amp; Stretch</strong> – Look for moisture-wicking, breathable, and flexible materials.</li><li><strong>Comfort &amp; Durability</strong> – Soft, high-quality materials that maintain shape and structure over time.</li><li><strong>Versatility</strong> – Suitable for various occasions, from casual to business settings.</li></ul></div>
                        
                        <div class="iwt-block iwt-banner"> 
                            <div class="iwt-banner-media" > 
                                <img src="/wp-content/themes/dudeshirts/img/Screenshot 2025-07-02 at 10.22.56.png" alt="">
                            </div> 
                        </div>
                        
                        <div style="margin-top: 20px;" class="iwt-block iwt-heading iwt-block-title_V7gctC"> <h2>What to Look for in the Perfect Athletic Fit Shirt</h2></div>
                        
                        <div class="iwt-block iwt-content check-listing iwt-block-content_ck9NLH"> <p>Investing in high-quality fabrics with performance features like stretch, moisture-wicking, and breathability can make all the difference in fit and function. When choosing the best shirt for a muscular physique, consider the following key factors:</p><ul><li><strong>Fit &amp; Tailoring</strong> – Shirts should contour the body without excess fabric or tight restrictions.</li><li><strong>Fabric &amp; Stretch</strong> – Look for moisture-wicking, breathable, and flexible materials.</li><li><strong>Comfort &amp; Durability</strong> – Soft, high-quality materials that maintain shape and structure over time.</li><li><strong>Versatility</strong> – Suitable for various occasions, from casual to business settings.</li></ul></div>
                        
                         <section class="product-card">
                            <div class="badge">1 BEST OVERALL</div>
                        
                            <div class="product-info">
                              <div class="product-image">
                                <img src="https://therefinedman.co/cdn/shop/files/Untitled_design_25.png?v=1747522077" alt="T-Shirt">
                              </div>
                              <div class="product-details">
                                <h2>NO | Noriks T-Shirt</h2>
                                <p class="price"><del>£35,00</del> <strong>£14,00</strong></p>
                                <div class="bundle">SAVE UP TO 60% WITH BUNDLES</div>
                                <ul class="specs">
                                  <li><strong>Main Specifications</strong></li>
                                  <li>Available in 25+ Colours</li>
                                  <li>Tailored Fit – Enhances Chest & Arms</li>
                                  <li>Super Soft – Shape Retention</li>
                                </ul>
                              </div>
                              <div class="score">
                                <div class="score-text">Overall Score</div>
                                <div class="score-value">4.9/5</div>
                                <div class="stars">★★★★★</div>
                                <div class="logo">DS</div>
                              </div>
                               <a href="https://dudeshirts.d4web.eu/product/coastal-2-pack/" class="shop-button">SHOP NOW</a>
                              <p class="shipping-info">FREE Shipping on Orders +£150 · 35-Day Returns</p>
                            </div>
                        
                          
                        
                            <div class="pros-cons">
                              <div class="pros">
                                <h3>Pros</h3>
                                <ul>
                                  <li>✔ Tailored fit for a <strong>sharp look</strong> and effortless confidence</li>
                                  <li>✔ <strong>4-way stretch luxury fabric</strong> for optimal movement and comfort</li>
                                  <li>✔ <strong>Moulds perfectly</strong> to any physique</li>
                                  <li>✔ <strong>Versatile design</strong> that works for both smart and casual</li>
                                  <li>✔ The more you buy <strong>the more you save</strong></li>
                                </ul>
                              </div>
                              <div class="cons">
                                <h3>Cons</h3>
                                <ul>
                                  <li>✘ Only available online</li>
                                  <li>✘ Often sell out quickly due to high demand</li>
                                </ul>
                              </div>
                            </div>
                        
                            <div class="bottom-line">
                              <h4>The Bottom Line</h4>
                              <p>
                                TA is for men who appreciate simplicity, luxury and timeless style - paired with a second-to-none fit.
                                Where others compromise, TA’s Tailored Fit delivers a sharp, well-proportioned look which commands attention in any setting.
                              </p>
                              <p>
                                TA’s T-Shirts offer a lasting impression in professional, social and casual settings, through their timeless versatility.
                                Their bundles offer the best value for money compared to others on the list.
                              </p>
                              <p><strong>That’s why they’re our top choice.</strong></p>
                            </div>
                          </section>
                          <style>
                                .product-card {
                
                                  background: #fff;
                                  border-radius: 6px;
                                  overflow: hidden;
                                  box-shadow: 0 0 10px rgba(0,0,0,0.1);
                                }
                                
                                .badge {
                                  background: #3aa243;
                                  color: #fff;
                                  font-weight: bold;
                                  text-align: center;
                                  padding: 0.5rem;
                                  border-radius: 4px;
                                  margin-bottom: 1rem;
                                }
                                
                                .product-info {
                                  display: flex;
                                  flex-wrap: wrap;
                                  gap: 1rem;
                                  align-items: center;
                                  padding: 20px;
                                }
                                
                                .product-image img {
                                  width: 120px;
                                  height: auto;
                                  border-radius: 4px;
                                }
                                
                                .product-details {
                                  flex: 1;
                                }
                                
                                .price {
                                  font-size: 1.2rem;
                                  margin: 0.5rem 0;
                                }
                                
                                .price del {
                                  color: #999;
                                  margin-right: 0.5rem;
                                }
                                
                                .bundle {
                                  background: #004d99;
                                  color: #fff;
                                  padding: 0.3rem 0.6rem;
                                  display: inline-block;
                                  font-size: 0.85rem;
                                  border-radius: 4px;
                                  margin-bottom: 0.5rem;
                                }
                                
                                .specs {
                                  list-style: none;
                                  padding-left: 0;
                                  font-size: 0.95rem;
                                }
                                
                                .specs li:first-child {
                                  font-weight: bold;
                                  color: #2d7a36;
                                  margin-bottom: 0.25rem;
                                }
                                
                                .score {
                                  text-align: center;
                                  min-width: 120px;
                                }
                                
                                .score-text {
                                  font-size: 0.85rem;
                                  color: #666;
                                }
                                
                                .score-value {
                                  font-size: 1.8rem;
                                  font-weight: bold;
                                }
                                
                                .stars {
                                  color: gold;
                                  font-size: 1.2rem;
                                  margin: 0.3rem 0;
                                }
                                
                                .logo {
                                  font-size: 2rem;
                                  opacity: 0.7;
                                }
                                
                                .shop-button {
                                  display: block;
                                  width: 100%;
                                  text-align: center;
                                  background: #3aa243;
                                  color: white;
                                  font-weight: bold;
                                  padding: 0.8rem;
                                  margin: 1rem 0 0.5rem;
                                  text-decoration: none;
                                  border-radius: 4px;
                                }
                                
                                .shipping-info {
                                    font-size: 0.85rem;
                                    color: #666;
                                    display: block;
                                    margin: 0 auto;
                                }
                                
                                .pros-cons {
                                  display: flex;
                                  flex-direction: column;
                                  gap: 1rem;
                                  margin: 0rem 0 1.5rem 0;
                                  padding: 20px;
                                }
                                
                                .pros, .cons {
                                  padding: 1rem;
                                  border-radius: 6px;
                                }
                                
                                .pros {
                                  border: 2px solid #3aa243;
                                }
                                
                                .cons {
                                  border: 2px solid #e53935;
                                  background: #fff8f8;
                                }
                                
                                .pros h3, .cons h3 {
                                  margin-bottom: 0.5rem;
                                }
                                
                                .pros ul, .cons ul {
                                  list-style: none;
                                  padding: 0;
                                  margin: 0;
                                }
                                
                                .pros li, .cons li {
                                  margin: 0.4rem 0;
                                }
                                
                                .bottom-line {
                                  border-top: 1px solid #ccc;
                                  padding-top: 1rem;
                                  padding: 20px;
                                }
                                
                                .bottom-line h4 {
                                  font-weight: bold;
                                  margin-bottom: 0.5rem;
                                }

                          </style>
                        
                         <div  style="margin-top: 20px;" class="iwt-block iwt-heading iwt-block-title_V7gctC"> <h2>Conclusion</h2></div>
                        
                        <div class="iwt-block iwt-content check-listing iwt-block-content_ck9NLH"> <p>Investing in high-quality fabrics with performance features like stretch, moisture-wicking, and breathability can make all the difference in fit and function. When choosing the best shirt for a muscular physique, consider the following key factors:</p><ul><li><strong>Fit &amp; Tailoring</strong> – Shirts should contour the body without excess fabric or tight restrictions.</li><li><strong>Fabric &amp; Stretch</strong> – Look for moisture-wicking, breathable, and flexible materials.</li><li><strong>Comfort &amp; Durability</strong> – Soft, high-quality materials that maintain shape and structure over time.</li><li><strong>Versatility</strong> – Suitable for various occasions, from casual to business settings.</li></ul></div>
                        
                        
                        <section class="top-picks">
                            <h2>Our Top 5 Tested Picks</h2>
                        
                            <div class="pick highlight">
                              <div class="pick-info">
                                <img src="https://dudeshirts.d4web.eu/wp-content/uploads/2025/05/black.png" alt="TA T-Shirt" />
                                <div class="text">
                                  <strong>NO</strong>
                                  <span>NORIKS  Fit</span>
                                </div>
                              </div>
                              <a href="https://dudeshirts.d4web.eu/product/one-green/" class="details-btn highlight-btn">Shop now ↓</a>
                            </div>
                        
                            <div class="pick">
                              <div class="pick-info">
                                <img src="https://dudeshirts.d4web.eu/wp-content/uploads/2025/05/beige-1.png" alt="BYLT" />
                                <div class="text">
                                  <strong>BYLT</strong>
                                  <span>Premium Basics</span>
                                </div>
                              </div>
                              <a href="https://dudeshirts.d4web.eu/product/one-green/" class="details-btn">Shop now ↓</a>
                            </div>
                        
                            <div class="pick">
                              <div class="pick-info">
                                <img src="https://dudeshirts.d4web.eu/wp-content/uploads/2025/05/blue.png" alt="True Classic" />
                                <div class="text">
                                  <strong>True Classic</strong>
                                  <span>Affordable Quality</span>
                                </div>
                              </div>
                              <a href="https://dudeshirts.d4web.eu/product/one-green/" class="details-btn">Shop now ↓</a>
                            </div>
                        
                            <div class="pick">
                              <div class="pick-info">
                                <img src="https://dudeshirts.d4web.eu/wp-content/uploads/2025/05/gray.png" alt="CUTS" />
                                <div class="text">
                                  <strong>CUTS</strong>
                                  <span>Elevated Essentials</span>
                                </div>
                              </div>
                              <a href="https://dudeshirts.d4web.eu/product/one-green/" class="details-btn">Shop now ↓</a>
                            </div>
                        
                            <div class="pick">
                              <div class="pick-info">
                                <img src="https://dudeshirts.d4web.eu/wp-content/uploads/2025/05/green-1.png" alt="Reigning Champ" />
                                <div class="text">
                                  <strong>Reigning Champ</strong>
                                  <span>Premium Loungewear</span>
                                </div>
                              </div>
                              <a href="https://dudeshirts.d4web.eu/product/one-green/" class="details-btn">Shop now ↓</a>
                            </div>
                          </section>
                          
                          
                          
                          
                          <style>
                              .top-picks {
               
                                }
                                
                                .top-picks h2 {
                                  font-size: 1.5rem;
                                  margin-bottom: 1.5rem;
                                }
                                
                                .pick {
                                  display: flex;
                                  justify-content: space-between;
                                  align-items: center;
                                  padding: 1rem;
                                  border-bottom: 1px solid #eee;
                                }
                                
                                .pick:last-child {
                                  border-bottom: none;
                                }
                                
                                .pick-info {
                                  display: flex;
                                  align-items: center;
                                  gap: 1rem;
                                }
                                
                                .pick-info img {
                                  width: 60px;
                                  height: auto;
                                  border-radius: 4px;
                                }
                                
                                .text strong {
                                  display: block;
                                  font-weight: 600;
                                  font-size: 1rem;
                                }
                                
                                .text span {
                                  font-size: 0.9rem;
                                  color: #555;
                                }
                                
                                .details-btn {
                                  padding: 0.5rem 1rem;
                                  background: #fff;
                                  border: 1px solid #ccc;
                                  border-radius: 6px;
                                  color: #111;
                                  font-weight: 500;
                                  text-decoration: none;
                                  font-size: 0.9rem;
                                  transition: background 0.2s ease;
                                }
                                
                                .details-btn:hover {
                                  background: #f4f4f4;
                                }
                                
                                .highlight {
                                  background: #f0fff0;
                                  border-radius: 4px;
                                }
                                
                                .highlight-btn {
                                  background: #158000;
                                  color: white;
                                  border: none;
                                }
                                
                                .highlight-btn:hover {
                                  background: #106600;
                                }
                          </style>
                          
                        
                        <br/>
                        <div class="iwt-block iwt-content check-listing iwt-block-content_ck9NLH"> <p>Investing in high-quality fabrics with performance features like stretch, moisture-wicking, and breathability can make all the difference in fit and function. When choosing the best shirt for a muscular physique, consider the following key factors:</p><ul><li><strong>Fit &amp; Tailoring</strong> – Shirts should contour the body without excess fabric or tight restrictions.</li><li><strong>Fabric &amp; Stretch</strong> – Look for moisture-wicking, breathable, and flexible materials.</li><li><strong>Comfort &amp; Durability</strong> – Soft, high-quality materials that maintain shape and structure over time.</li><li><strong>Versatility</strong> – Suitable for various occasions, from casual to business settings.</li></ul></div>
                    
                           
                          <div class="section-image">
                            <div class="video-wrapper">
                            <video 
                              autoplay muted loop playsinline 
                              class="why-video">
                              <source src="https://mensbestbasics.com/cdn/shop/videos/c/vp/89e20d28314147559987bfa06ca3ead8/89e20d28314147559987bfa06ca3ead8.HD-1080p-2.5Mbps-47090714.mp4?v=0" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          </div>
                        
                    </div>
                </div>
                
                <section class="bottom-banner">
                    <div class="product-info">
                      <img src="https://therefinedman.co/cdn/shop/files/ima34ge.jpg?v=1747521484" alt="Product Image">
                      <div class="text-info">
                        <h2>NORIKS T-Shirt #1 Top Choice</h2>
                        <div class="rating">
                          <span class="stars">★★★★★</span>
                          <span class="score">4.9/5</span>
                          <span class="reviews">(4,132 Reviews)</span>
                        </div>
                      </div>
                    </div>
                    <a href="https://dudeshirts.d4web.eu/product/coastal-2-pack/" class="shop-btn">SHOP NOW →</a>
                  </section>
                  
                  <style>
                      .bottom-banner {
                          display: flex;
                          justify-content: space-between;
                          align-items: center;
                          background: #fff;
                          padding: 1rem 2rem;
                          box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                          border-top: 4px solid #eee;
                          
                            position: fixed;
                            bottom: 0;
                            width: 100%;
                            z-index: 99999999999;
                        }
                        
                        .product-info {
                          display: flex;
                          align-items: center;
                          gap: 1rem;
                        }
                        
                        .product-info img {
                          width: 60px;
                          height: auto;
                          border-radius: 4px;
                        }
                        
                        .text-info h2 {
                          font-size: 1.2rem;
                          font-weight: 600;
                          margin: 0;
                        }
                        
                        .rating {
                          margin-top: 0.25rem;
                          font-size: 0.95rem;
                          color: #555;
                        }
                        
                        .stars {
                          color: #ffc107;
                          font-size: 1rem;
                          margin-right: 0.3rem;
                        }
                        
                        .shop-btn {
                          background: #158000;
                          color: #fff;
                          padding: 0.75rem 1.5rem;
                          font-weight: bold;
                          text-decoration: none;
                          border-radius: 6px;
                          font-size: 0.95rem;
                          transition: background 0.2s ease;
                        }
                        
                        .shop-btn:hover {
                          background: #106600;
                        }
                  </style>
                
                
                
            </article>
        <?php endwhile; else : ?>
            <p>No lander found.</p>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); // Includes footer.php ?>
