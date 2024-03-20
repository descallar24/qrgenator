<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <style>
        .qr-container {
            position: relative;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }
        .qr-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            opacity: 0.5; /* Lower the opacity here (value between 0 and 1) */
        }
        .logo1 {
            position: absolute;
            top: 50%;
            left: 8%;
            transform: translate(-50%, -50%);
            z-index: 10;
            opacity: 1; /* Lower the opacity here (value between 0 and 1) */
        }
    </style>
</head>
<body>

<div class="col-md-3"></div>
<div class="col-md-6 well">
    <h3 class="text-primary text-center">QR Code Generator</h3> 
    <hr style="border-top:1px dotted #ccc;"/>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="form-group">
            <form method="POST" action="">
                <input type="text" name="code" id="code" class="form-control" value="<?php echo isset($_POST['code']) ? $_POST['code'] : '' ?>"/>
                <br>
                <button class="btn btn-primary form-control" name="generate" onclick="storeInput()">Generate</button>
            </form>
            <?php 
                if(isset($_POST['generate']) && !empty($_POST['code'])) {
                    $generated_name = $_POST['code']; // Store the inputted name
            ?>
            <div class="qr-container">
                <img src="generate.php?code=<?php echo $generated_name ?>" alt="" class="qr-code">
                <img src="logo.png" alt="Logo" class="qr-logo">
            </div>
            <br>
            <button class="btn btn-success form-control" onclick="saveQR('<?php echo $generated_name ?>')">Save QR as PNG</button>
            <?php
                }
            ?>
        </div>
    </div>
</div>

<script>
    function saveQR(name) {
        var qrContainer = document.querySelector('.qr-container');
        var qrCodeImg = qrContainer.querySelector('.qr-code');
        var logoImg = qrContainer.querySelector('.qr-logo');
        
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        canvas.width = qrCodeImg.width;
        canvas.height = qrCodeImg.height;
        
        // Draw QR code image onto canvas
        ctx.drawImage(qrCodeImg, 0, 0);
        
        // Draw logo onto canvas with opacity
        ctx.globalAlpha = parseFloat(window.getComputedStyle(logoImg).opacity); // Get the opacity of the logo
        ctx.drawImage(logoImg, (canvas.width - logoImg.width) / 2, (canvas.height - logoImg.height) / 2); // Center the logo
        
        // Convert canvas to PNG image
        var link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = name !== '' ? name + '.png' : 'qr_code.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>

</body>
</html>
