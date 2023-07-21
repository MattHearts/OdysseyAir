<link rel="stylesheet" href="../css/checkin.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="layout">

        <div class="forms">
            <h1>Check-In</h1>
            Please fill in your ....<br>

            <?php
            for($x=0;$x<$check1->x;$x++)
            {
                ?>
            
             
                <h2><?php echo $check1->passengerNameList[$x]." ".$check1->passengerSurnameList[$x]." ".$check1->passengerIDList[$x];?></h2>
                <div class="passenger-form">
                    <div class="form">
                    <form method= "post" >
                    <div class="single-form">

                    <label for="document-type<?php echo $x;?>">Document Type</label><br>
                    <select name="document-type<?php echo $x;?>" id="passenger-type" required>
                    <option value="Passport">Passport</option>
                    <option value="ID">National ID</option>

                    </select>

                    </div>
                    <div class="single-form">
                    <label for="document-num<?php echo $x;?>">Document Number</label>
                        <input type="text" class="form-control" id="document-number" placeholder="e.x AR4323087" required name="document-num<?php echo $x;?>">
                    </div>
                    <div class="single-form">
                    <label for="country-of-issue<?php echo $x;?>">Country of Issue</label>
                        <input type="text" class="form-control" id="country-of-issue" placeholder="e.x Greece" required name="country-of-issue<?php echo $x;?>">
                    </div>
                    <div class="single-form">
                    <label for="nationality<?php echo $x;?>">Nationality</label>
                        <input type="text" class="form-control" id="nationality" placeholder="e.x Greek" required name="nationality<?php echo $x;?>">
                    </div>
                    <div class="single-form">
                    <label for="dateBirth<?php echo $x;?>">Date of Birth</label>
                    <input type="date" class="form-control" id="dateBirth" placeholder="dateBirth" required name="dateBirth<?php echo $x;?>" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                

                    </div>
                    
                
                    </div>
                <?php
            }
            ?>
                <div class="check-in-btn">
                <button type="submit" class="button"><span>Check In</span>
        </form>
            </div>            
            </div>
            </div>