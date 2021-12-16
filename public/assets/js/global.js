$(document).ready(() => {
    // Initializing tooltips.
    $('[data-toggle="tooltip"]').tooltip();

    // |‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾| //
    // |    SECRETS KEYBOARD CODES    | //
    // |______________________________| //

    console.log('Hello stranger ! Have you come in search of riches ?');
    console.log('Well I must admit that this site contains two secrets.');
    console.log('Those secrets are some visual easter eggs.');
    console.log('In order to activate those secrets you need to input the directions of the legendary Konami Code anywhere on the site.');
    console.log('You then need to input two letters, used letters are : R, C, B or N.');
    console.log('If the combination is not right, you need to start from the beginning.');
    console.log('Happy hunting !');

    // Up, up, down, down, left, right, left, right, R, B
    let rainbowKeyCodes = [38, 38, 40, 40, 37, 39, 37, 39, 82, 66];

    // Up, up, down, down, left, right, left, right, N, C
    let nyanCatKeyCodes = [38, 38, 40, 40, 37, 39, 37, 39, 78, 67];

    let position = 0;

    let body = document.body;

    let red = 0;
    let green = 0;
    let blue = 0;

    let isRainbowActive = false;
    let rainbowTimeoutHolder;

    let isNyanCatActive = false;

    // Listening for inputs for both secret codes.
    $(document).keydown(function (event) {
        if (event.keyCode === rainbowKeyCodes[position]) {
            position++;

            if (position === rainbowKeyCodes.length) {
                if (isRainbowActive) {
                    isRainbowActive = false;

                    clearTimeout(rainbowTimeoutHolder);

                    if (isNyanCatActive) {
                        body.style.backgroundColor = '';
                    } else {
                        body.style.backgroundColor = '#343a40';
                    }
                } else {
                    isRainbowActive = true;

                    rainbow();
                }

                position = 0;
            }
        } else if (event.keyCode === nyanCatKeyCodes[position]) {
            position++;
            
            if (position === rainbowKeyCodes.length) {
                if (isNyanCatActive) {
                    isNyanCatActive = false;

                    window.location.href = '/proposal';
                } else {
                    isNyanCatActive = true;

                    $(body).empty();
                    $(body).load('../../assets/secrets/nyan-cat.html');
                }

                position = 0;
            }
        } else {
            position = 0;
        }
    });

    // Display a magnificient rainbow !
    function rainbow() {       
        if (red <= 255 && green == 0 && blue == 0) {
            red ++;
        }
    
        if (red == 255 && blue == 0 && green <= 255) {
            green ++;
        }
    
        if (red == 255 && green == 255 && blue <= 255) {
            blue ++;
        }
    
        if (blue == 255 && green == 255 && red > 0) {
            red --;
        }
    
        if (red == 0 && blue == 255 && green > 0) {
            green --;
        }
    
        if (red == 0 && green == 0 && blue > 0) {
            blue --;
        }
    
        rainbowTimeoutHolder = setTimeout(function() {
            rainbow();
        }, 10);
    
        body.style.backgroundColor = 'rgb(' + red + ',' + green + ',' + blue +')';
    }
});