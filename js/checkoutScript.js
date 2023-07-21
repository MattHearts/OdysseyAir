function formatCardNumber(input) {
    // Remove any non-digit characters from the input value
    var cardNumber = input.value.replace(/\D/g, '');
  
    // Apply the formatting by adding a space after every fourth digit
    var formattedCardNumber = '';
    for (var i = 0; i < cardNumber.length; i++) {
      if (i > 0 && i % 4 === 0) {
        formattedCardNumber += ' ';
      }
      formattedCardNumber += cardNumber.charAt(i);
    }
  
    // Update the input value with the formatted card number
    input.value = formattedCardNumber.trim().substring(0, 19);
  }