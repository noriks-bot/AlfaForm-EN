<!-- Size Chart Modal Styles -->
<style>
/* --- Base UI bits you already had --- */
#size-suggestion-result { border: 1px solid #ccc; }
.body-type-options { display: flex; justify-content: space-between; gap: 5px; }
.body-type-option {
  display: flex; flex-direction: column; align-items: center; cursor: pointer;
  padding: 5px; border: 1px solid #ccc; border-radius: 2px; width: auto; text-align: center;
  transition: all 0.2s ease;
}
.body-type-option input { display: none; }
.body-type-option img { width: 100px; height: 100px; margin-bottom: 5px; }
.body-type-option:hover { background-color: #e0e0e0; }
.body-type-option.selected { border: 2px solid #f39c13; background-color: #fff3d6; }
.slike-mobile-only { display: flex; }

/* --- Modal base --- */
/* Height is AUTO on ALL screens now (desktop same as mobile). */
#custom-size-chart-modal-secondary {
  display: none;              /* hidden by default; shown via .show */
  position: fixed;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 90%;
  max-width: 800px;
  height: auto;               /* << auto height */
  background: #fff;
  border-radius: 3px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.25);
  z-index: 9999999;
  overflow: visible;          /* no forced scrollbars */
  font-family: sans-serif;
}

/* Single-column content wrapper (only image) */
.size-chart-left {
  display: flex;              /* center the image inside */
  align-items: center;        /* vertical center */
  justify-content: center;    /* horizontal center */
  background: white;
  padding: 0;
}

/* Image fills modal width, keeps aspect ratio */
.size-chart-left img {
  display: block;
  width: 100%;
  height: auto;
  object-fit: contain;
  margin: 0;                  /* ensure no offsets */
}

/* When opened */

#custom-size-chart-modal-secondary.show { display: block; }

/* --- Mobile tweaks (kept minimal) --- */
@media (max-width: 768px) {
  .info-box-desktop { display: none !important; }
  .second-one, .third-one { display: inline-block; width: 49%; }
  #size-suggestion-result { padding-top: 3px; padding-bottom: 3px; }
  .form-title { margin-top: 4px; text-align: left; padding-left: 10px; font-size: 15px; }
  .size-chart-field { margin-top: 10px; text-align: left; }
  .size-chart-field label { text-align: left; }

  /* Modal stays auto-height on mobile too; nothing else needed */
}

/* Desktop cleanups */
@media (min-width: 769px) {
  .slike-mobile-only { display: none !important; }
  .info-box-mobile  { display: none !important; }
}
</style>

<!-- Modal HTML -->
<div id="custom-size-chart-modal-secondary" aria-modal="true" role="dialog">
  <span id="close-size-chart-x-secondary" style="position: absolute;
    top: 5px; right: 5px; font-size: 24px; font-weight: bold; cursor: pointer;
    background: black; border-radius: 1px; width: 40px; height: 40px; text-align: center; color: white;">&times;</span>

  <div class="size-chart-left">
      
     
      
    <img
    
    style="margin-top: 70px;margin-bottom: 70px;"
    
      src="https://noriks.com/si/wp-content/uploads/2026/04/bokserice_si.jpg"
      alt="Size Guide">
      
      
      
       
       
      
      
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const modal2 = document.getElementById("custom-size-chart-modal-secondary");
  const openBtn2 = document.getElementById("open-size-chart-secondary");
  const closeX = document.getElementById("close-size-chart-x-secondary");

  // Open using a class so CSS controls display across breakpoints
  openBtn2?.addEventListener("click", function (e) {
    e.preventDefault();
    modal2.classList.add("show");
    
    console.log("cliclk");
    
  });

  // Close
  closeX?.addEventListener("click", function () {
    modal2.classList.remove("show");
  });

  // Optional: close on ESC
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") modal2.classList.remove("show");
  });
});
</script>
