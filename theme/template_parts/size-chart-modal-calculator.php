<!-- Size Chart Modal Styles -->
<style>



#size-suggestion-result {
border: 1px solid #ccc;
}

.body-type-options {
    display: flex;
    justify-content: space-between;
    gap: 5px;
}

.body-type-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 2px;
    width: auto;
    text-align: center;
    transition: all 0.2s ease;
}

.body-type-option input {
    display: none;
}

.body-type-option img {
    width: 100px;
    height: 100px;
    margin-bottom: 5px;
}

.body-type-option:hover {
    background-color: #e0e0e0;
}

/*
.body-type-option input:checked + img {
    border: 2px solid #f39c13;
    
}
*/

.body-type-option.selected {
    border: 2px solid #f39c13;
    background-color: #fff3d6;
}













#custom-size-chart-modal {
    min-height: 85%;
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 800px;
    background: #fff;
    border-radius: 3px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.25);
    z-index: 9999999;
    overflow: hidden;
    font-family: sans-serif;
    flex-direction: row;
}
.size-chart-left {
    flex: 1;
    background: #f9f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0px;
}
.size-chart-left img {
    max-width: 100%;
    height: auto;
}
.size-chart-right {
    flex: 1;
    background: #f3f4f6;
    padding: 20px 20px 20px 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.size-chart-right h3 {
 font-size: 19px;
    margin-bottom: 2px;
    font-weight: 700;
    color: #1d1d1f;
    font-family: 'Roboto', sans-serif;
}
.size-chart-field {
    margin-bottom: 10px;
}
.size-chart-field label {
    font-weight: 600;
    display: block;
    margin-bottom: 2px;
    color: black;
    font-size: 14px;
     font-family: 'Roboto', sans-serif;
}
.size-chart-field input {
    background: white;
    width: 100%;
    padding: 5px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 2px;
    box-shadow: none;
}
#size-suggestion-result {
  font-weight: bold;
    color: black;
    display: block;
    margin: 0 auto;
    text-align: center;
}

#size-suggestion-result strong {
    font-size: 60px;
    display: block;
    color: #002039;
    line-height: 1.1;
}

#close-size-chart-btn3 {
 color: white;
   
    text-align: center;
    background: #f39c13;
    display: inline-block;
    border-radius: 3px;
    margin: 0 auto;
    padding: 10px 20px 10px 20px;
    cursor: pointer;
}





 .slike-mobile-only {
            display: flex;
    }

@media (max-width: 768px) {
    
    .info-box-desktop {
            display: none !important;
    }

    
    .second-one, .third-one {
     display: inline-block;
     width: 49%;
  }
  
  
#size-suggestion-result  {
    padding-top: 3px;
     padding-bottom: 3px;
}
    
    .form-title  {
      margin-top: 4px;
    text-align: left;
    padding-left: 10px;
    font-size: 15px;
  }

    .size-chart-field  {
    margin-top: 10px;
    text-align: left;
  }
  
      .size-chart-field  label  {
    text-align: left;
  }
  

  #custom-size-chart-modal {
    width: 100%;
    height: 100%;
    flex-direction: column;
    overflow-y: auto;
  }

  .size-chart-left {
    display:none;
  }

  .size-chart-right {
    flex: 1 1 100%;
    padding: 10px 10px;
  }

  #size-suggestion-result strong {
    font-size: 25px;
  }

  #close-size-chart-btn3 {
    width: 100%;
    text-align: left;
  }
  
  .size-chart-right  {
        text-align: center;
  }
  .find-your-size-instructions {
      margin-bottom: 55px;
  }
  
  
      #close-size-chart-btn3 {
    text-align: center;
  }
    .find-your-size-instructions {
    margin: 1px 10px 0px 10px !important;
  }
  
  .form-title {
      margin-top: 5px;
  }
  
  
  .find-your-size-instructions{
         
           margin-top: 4px !important;
    margin-bottom: 10px !important;
    color: black;
    line-height: 1.1;
    text-align: left;
    font-size: 12px;
    margin-right: 42px;
    padding-right: 50px;
    font-family: 'Roboto', sans-serif;
          
         
         
  }
  
  
  .find-your-size-instructions2 {
         
       margin-top: 4px !important;
    margin-bottom: 10px !important;
    color: black;
    line-height: 1.1;
    text-align: left;
    font-size: 12px;
    margin-right: 42px;
    padding-right: 0px;
    font-family: 'Roboto', sans-serif;
          

          
         
         
  }
  
  .body-type-option {
         
         text-align: center !important;
         
         
  }
  
  #close-size-chart-btn3 {
         height: 70px;
                 padding-top: 17px !important;
        font-size: 21px;
         
         
  }
  
}



@media (min-width: 769px) {
    
    
    

    .slike-mobile-only {
            display: none !important;
    }

    .info-box-mobile   {
            display: none !important;
    }

}
</style>

<!-- Modal HTML -->
<div id="custom-size-chart-modal">
    
    <span id="close-size-chart-x" style="position: absolute;
    top: 5px;
    right: 5px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    background: black;
    border-radius: 1px;
    width: 40px;
    height: 40px;
    text-align: center;
    color: white;">&times;</span>

    
    <div style="background: #fdfdff;" class="size-chart-left">
        
        
        <img class="sc_m_img1" style="display: none; width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;" src="<?php echo get_field("size_chart_modal_image1", "options"); ?>" alt="Vodnik po velikostih">
    
    
    
    <img class="sc_m_img2" style="width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;" src="<?php echo get_field("size_chart_modal_image2", "options"); ?>" alt="Vodnik po velikostih">
    
    
    
    <img class="sc_m_img3" style="display: none; width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;" src="<?php echo get_field("size_chart_modal_image3", "options"); ?>" alt="Vodnik po velikostih">
    
    
    
    
    
    </div>
    <div class="size-chart-right">
        <div>
            <h3 class="form-title"><?php echo get_field("size_chart_modal_t1","options"); ?></h3>
            <p class="find-your-size-instructions" style="color: black;
    line-height: 1.1;
    font-size: 14px;    margin-bottom: 20px;
    margin-right: 42px;
    font-family: 'Roboto', sans-serif;"><?php echo get_field("size_chart_modal_t2","options"); ?></p>
    
    
<div class="slike-mobile-only" style="padding: 0;  justify-content: space-between; align-items: center; gap: 0px; margin-top: 15px;">

        
          <img class="sc_m_img1" style="width:  33.33%; border:none; margin: 0 auto; display:inline; height: auto;
 
 " src="<?php echo get_field("size_chart_modal_image1", "options"); ?>" alt="Vodnik po velikostih">
    
    
    
    <img class="sc_m_img2" style="width:  33.33%;   border:none; margin: 0 auto; display:inline; height: auto;
  
  " src="<?php echo get_field("size_chart_modal_image2", "options"); ?>" alt="Vodnik po velikostih">
    
    
    
    <img class="sc_m_img3" style="; width: 33.33%;  border:none;  margin: 0 auto; display:inline; height: auto;

" src="<?php echo get_field("size_chart_modal_image3", "options"); ?>" alt="Vodnik po velikostih">
    
        
    </div>
           
           
           <div style="margin-bottom: 0px;" class="size-chart-field">
                <label style="margin-bottom: 2px; display: block;"><?php echo get_field("size_chart_modal_t5","options"); ?></label>
                <div class="body-type-options">
                    <label class="body-type-option">
                        <input type="radio" name="body-type" value="sport">
                        <img src="/wp-content/uploads/2025/07/1_thinpng.png" alt="Flat">
                        <span><?php echo get_field("size_chart_modal_t6","options"); ?></span>
                    </label>
                    <label class="body-type-option selected">
                        <input type="radio" name="body-type" value="medium" checked>
                        <img src="/wp-content/uploads/2025/07/2_medium.png" alt="Average">
                        <span><?php echo get_field("size_chart_modal_t7","options"); ?></span>
                    </label>
                    <label class="body-type-option">
                        <input type="radio" name="body-type" value="fat">
                        <img src="/wp-content/uploads/2025/07/3_bigbelly.png" alt="Round">
                        <span><?php echo get_field("size_chart_modal_t8","options"); ?></span>
                    </label>
                </div>
            </div>
           
           
            <div class="size-chart-field second-one">
                <label for="user-height"><?php echo get_field("size_chart_modal_t3","options"); ?></label>
                <input type="number" id="user-height" placeholder="e.g. 180">
            </div>
            <div class="size-chart-field third-one">
                <label for="user-weight"><?php echo get_field("size_chart_modal_t4","options"); ?></label>
                <input type="number" id="user-weight" placeholder="e.g. 75">
            </div>
            
            
            
            
            
            
            <div id="size-suggestion-result">
                <?php echo get_field("size_chart_modal_t9","options"); ?> <strong> <br/></strong>
            </div>
            
            
            
        </div>
        
          <p class="find-your-size-instructionsno find-your-size-instructions2" style="color: black;
    line-height: 1.1;
    font-size: 12px;
 margin: 1px 10px 27px 10px;
    font-style: italic; text-align: center;"><?php echo get_field("size_chart_modal_t10","options"); ?></p>
        
        
         
            <div class="info-box-mobile info-box" style="
    padding: 2px 2px 0px 2px;
    background: white;
    /* color: white !important; */
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    font-size:12px;
    /* border-radius: 0; */
">
    

    
    30-dnevna garancija za zamenjavo velikosti

         
   
     </div>
<div class="info-box-mobile  info-box" style="
    padding: 0px 2px 4px 2px;
    background: white;
    /* color: white; */
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    margin-bottom: 5px;
     font-size:12px;
">
    
         <a href="tel:+38517776471" style="
    color: #7b8a9b;
    font-weight: 500;
    font-size: 12px;
    font-family: 'Roboto', sans-serif; display: flex; align-items: center; text-decoration: none; ">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right: 6px;    width: 17px;
    height: 17px;" viewBox="0 0 16 16">
    <path d="M3.654 1.328a.678.678 0 0 1 .737-.07l2.547 1.272a.678.678 0 0 1 .291.901L6.29 5.72a.678.678 0 0 0 .145.776l2.457 2.457a.678.678 0 0 0 .776.145l2.29-1.24a.678.678 0 0 1 .901.291l1.272 2.547a.678.678 0 0 1-.07.737l-1.175 1.769c-.46.692-1.232 1.043-2.036.964-2.322-.238-4.96-2.223-6.856-4.12C1.77 7.667-.214 5.03.024 2.707c.079-.804.272-1.577.964-2.036L3.654 1.33z"></path>
  </svg>
  01 777 64 71
</a>

<a href="mailto:info@noriks.com" style="
    color: #7b8a9b;
    font-weight: 500;
    font-size: 12px;
    font-family: 'Roboto', sans-serif; display: flex; align-items: center; text-decoration: none;">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right: 6px;    width: 17px;
    height: 17px;" viewBox="0 0 16 16">
    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.217L8 8.083 0 4.217V4zm0 1.383v6.234l5.803-3.122L0 5.383zM6.761 8.83 0 12.383V12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.383l-6.761-3.553L8 9.917l-1.239-.653zM16 5.383l-5.803 3.112L16 11.617V5.383z"></path>
  </svg>
  info@noriks.com
</a>
     </div>    
       
        
        <a id="close-size-chart-btn3"><?php echo get_field("size_chart_modal_t11","options"); ?></a>
        
        <div class="info-box-desktop-wrapper">
          <div class="info-box-desktop info-box" style="
    padding: 2px 2px 0px 2px;
    background: white;
    /* color: white !important; */
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    font-size:12px;
    /* border-radius: 0; */
">
    

    
     30-dnevna garancija za zamenjavo velikosti

         
   
     </div>
<div class="info-box-desktop  info-box" style="
    padding: 0px 2px 4px 2px;
    background: white;
    /* color: white; */
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    margin-bottom: 5px;
     font-size:12px;
">
    
         <a href="tel:+38517776471" style="
    color: #7b8a9b;
    font-weight: 500;
    font-size: 12px;
    font-family: 'Roboto', sans-serif; display: flex; align-items: center; text-decoration: none; ">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right: 6px;    width: 17px;
    height: 17px;" viewBox="0 0 16 16">
    <path d="M3.654 1.328a.678.678 0 0 1 .737-.07l2.547 1.272a.678.678 0 0 1 .291.901L6.29 5.72a.678.678 0 0 0 .145.776l2.457 2.457a.678.678 0 0 0 .776.145l2.29-1.24a.678.678 0 0 1 .901.291l1.272 2.547a.678.678 0 0 1-.07.737l-1.175 1.769c-.46.692-1.232 1.043-2.036.964-2.322-.238-4.96-2.223-6.856-4.12C1.77 7.667-.214 5.03.024 2.707c.079-.804.272-1.577.964-2.036L3.654 1.33z"></path>
  </svg>
  01 777 64 71
</a>

<a href="mailto:info@noriks.com" style="
    color: #7b8a9b;
    font-weight: 500;
    font-size: 12px;
    font-family: 'Roboto', sans-serif; display: flex; align-items: center; text-decoration: none;">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right: 6px;    width: 17px;
    height: 17px;" viewBox="0 0 16 16">
    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.217L8 8.083 0 4.217V4zm0 1.383v6.234l5.803-3.122L0 5.383zM6.761 8.83 0 12.383V12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.383l-6.761-3.553L8 9.917l-1.239-.653zM16 5.383l-5.803 3.112L16 11.617V5.383z"></path>
  </svg>
  info@noriks.com
</a>
     </div>    
        
        </div>
        
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal3 = document.getElementById("custom-size-chart-modal");
    const openBtn = document.getElementById("open-size-chart");
    const closeBtn3 = document.getElementById("close-size-chart-btn3");
    const closeX = document.getElementById("close-size-chart-x");

    const heightInput = document.getElementById("user-height");
    const weightInput = document.getElementById("user-weight");
    const resultDiv = document.getElementById("size-suggestion-result");

    const bodyTypeOptions = document.querySelectorAll('.body-type-option input');
    const bodyTypeContainers = document.querySelectorAll('.body-type-option');

    // Image elements
    const img1 = document.querySelector(".sc_m_img1");
    const img2 = document.querySelector(".sc_m_img2");
    const img3 = document.querySelector(".sc_m_img3");

    const sizes = ["S", "M", "L", "XL", "2XL", "3XL"];

    // Modal controls
    openBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        modal3.style.display = "flex";
    });

    closeBtn3?.addEventListener("click", function () {
        modal3.style.display = "none";
    });

    closeX?.addEventListener("click", function () {
        modal3.style.display = "none";
    });

    function getBaseSize(height, weight) {
         if (height <= 170 && weight <= 65) return "S";
        if (height <= 175 && weight <= 75) return "M";
        if (height <= 180 && weight <= 99) return "L";
        if (height <= 180 && weight >= 100) return "XL";
        if (height <= 185 && weight <= 105) return "XL";
        if (height <= 190 && weight <= 125) return "2XL";
        return "3XL";
    }

    function adjustSize(baseSize, bodyType) {
        let index = sizes.indexOf(baseSize);
        if (bodyType === "sport" && index > 0) {
            index -= 1;
        } else if (bodyType === "fat" && index < sizes.length - 1) {
            index += 1;
        }
        return sizes[index];
    }

    function updateSizeSuggestion() {
        const height = parseInt(heightInput.value, 10);
        const weight = parseInt(weightInput.value, 10);
        const selectedInput = document.querySelector('.body-type-option input:checked');

        if (!isNaN(height) && !isNaN(weight) && selectedInput) {
            const baseSize = getBaseSize(height, weight);
            const bodyType = selectedInput.value;
            const finalSize = adjustSize(baseSize, bodyType);
            resultDiv.innerHTML = `Priporočena velikost: <strong>${finalSize}</strong>`;
            resultDiv.style.display = "block";
            
            
            /* new code to trigger click */ 
               // ✅ Trigger click on custom variation button
        const variationButtonsWrapper = document.querySelector('.variation-buttons[data-attribute-name="velicina"]');
        if (variationButtonsWrapper) {
            const targetButton = variationButtonsWrapper.querySelector(`.variation-button[data-value="${finalSize}"]`);
            if (targetButton) {
                targetButton.click();
            }
        }
            
             /* new code to trigger click */ 
            
            
        } else {
            resultDiv.innerHTML = "";
            resultDiv.style.display = "none";
        }
    }

    function updateImages(bodyType) {
        img1.style.display = "none";
        img2.style.display = "none";
        img3.style.display = "none";

        if (bodyType === "sport") {
            img1.style.display = "block";
        } else if (bodyType === "medium") {
            img2.style.display = "block";
        } else if (bodyType === "fat") {
            img3.style.display = "block";
        }
    }

    bodyTypeOptions.forEach(input => {
        input.addEventListener("change", function () {
            bodyTypeContainers.forEach(c => c.classList.remove("selected"));
            this.closest('.body-type-option').classList.add("selected");

            const selectedType = this.value;
            updateImages(selectedType);
            updateSizeSuggestion();
        });
    });

    heightInput?.addEventListener("input", updateSizeSuggestion);
    weightInput?.addEventListener("input", updateSizeSuggestion);

    resultDiv.style.display = "none";

    // Initial state: highlight checked option and set corresponding image
    const defaultChecked = document.querySelector('.body-type-option input:checked');
    if (defaultChecked) {
        defaultChecked.closest('.body-type-option').classList.add("selected");
        updateImages(defaultChecked.value);
    }
});
</script>

