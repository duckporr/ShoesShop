function printElement(elementId) {
    var element = document.getElementById(elementId);
    var originalContent = document.body.innerHTML; // Save current page content
    document.body.innerHTML = element.innerHTML; // Set content of the element to be printed
    window.print(); // Open the print dialog
    document.body.innerHTML = originalContent; // Restore original page content
}