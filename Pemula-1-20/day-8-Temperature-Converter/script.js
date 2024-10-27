function convertTemperature() {
    const inputValue = parseFloat(document.getElementById("inputValue").value);
    const inputUnit = document.getElementById("inputUnit").value;
    const outputUnit = document.getElementById("outputUnit").value;
    let result;
  
    if (isNaN(inputValue)) {
      document.getElementById("result").innerText = "Please enter a valid number";
      return;
    }
  
    // Conversion logic
    if (inputUnit === outputUnit) {
      result = inputValue;
    } else if (inputUnit === "celsius") {
      result = outputUnit === "fahrenheit" ? (inputValue * 9/5) + 32 : inputValue + 273.15;
    } else if (inputUnit === "fahrenheit") {
      result = outputUnit === "celsius" ? (inputValue - 32) * 5/9 : ((inputValue - 32) * 5/9) + 273.15;
    } else if (inputUnit === "kelvin") {
      result = outputUnit === "celsius" ? inputValue - 273.15 : (inputValue - 273.15) * 9/5 + 32;
    }
  
    document.getElementById("result").innerText = `Result: ${result.toFixed(2)} ${outputUnit.charAt(0).toUpperCase() + outputUnit.slice(1)}`;
  }
  