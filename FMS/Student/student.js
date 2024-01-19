document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('reservationForm');
    const table = document.querySelector('.tb table');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const dateInput = document.getElementById('fdate');
        const timeInput = document.getElementById('ftime');
        const roomSelect = document.getElementById('froom');
        const purposeInput = document.getElementById('fpurpose');

        // Validate date, time, and purpose (you can add your validation logic here)

        // Create a new row
        const newRow = table.insertRow(-1);

        // Add data to the row cells
        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);
        const cell4 = newRow.insertCell(3);

        cell1.textContent = dateInput.value;
        cell2.textContent = timeInput.value;
        cell3.textContent = roomSelect.options[roomSelect.selectedIndex].text;
        cell4.textContent = purposeInput.value;

        // Clear form inputs
        dateInput.value = '';
        timeInput.value = '';
        roomSelect.selectedIndex = 0;
        purposeInput.value = '';
    });
});
