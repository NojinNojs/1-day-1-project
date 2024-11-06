function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46 || charCode == 44) {
        // Allow one decimal point or comma
        if (evt.target.value.indexOf(',') > -1 || evt.target.value.indexOf('.') > -1) {
            return false;
        } else {
            return true;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

document.getElementById('amount').addEventListener('input', function(e) {
    // Remove non-numeric characters except comma
    this.value = this.value.replace(/[^0-9,]/g, '');
    
    // Replace dot with comma
    this.value = this.value.replace('.', ',');
    
    // Ensure only one comma
    var parts = this.value.split(',');
    if (parts.length > 2) {
        this.value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Add thousand separators (dots)
    var wholePart = parts[0];
    var decimalPart = parts.length > 1 ? ',' + parts[1] : '';
    
    // Add dots every 3 digits
    wholePart = wholePart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    
    this.value = wholePart + decimalPart;
});