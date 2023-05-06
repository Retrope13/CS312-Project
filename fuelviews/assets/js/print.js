document.getElementById('printable-view-btn').addEventListener('click', function() {
    // Generate tables for printable view
    generatePrintableView();

    // Show the printable view
    document.getElementById('main-content').classList.add('hidden');
    document.getElementById('printable-view').classList.remove('hidden');

    // Print the page
    window.print();

    // Hide the printable view and show main content
    document.getElementById('printable-view').classList.add('hidden');
    document.getElementById('main-content').classList.remove('hidden');
});

function generatePrintableView() {
    const printableTables = document.getElementById('printable-tables');
    
    // Clear the previous content
    printableTables.innerHTML = '';

    // Generate the upper table
    const upperTable = document.createElement('table');
    // Add your code to generate the upper table
    printableTables.appendChild(upperTable);

    // Generate the lower table
    const lowerTable = document.createElement('table');
    // Add your code to generate the lower table
    printableTables.appendChild(lowerTable);
}
