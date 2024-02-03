function showPopup(userID) {
    document.getElementById('deleteUser').value = userID;
    document.getElementById('deletePopup').style.display = 'block';
}

function hidePopup() {
    document.getElementById('deletePopup').style.display = 'none';
}

function showActivatePopup(userID) {
    document.getElementById('activateUser').value = userID;
    document.getElementById('activatePopup').style.display = 'block';
}

function hideActivatePopup() {
    document.getElementById('activatePopup').style.display = 'none';
}

function showDeactivatePopup(userID) {
    document.getElementById('deactivateUser').value = userID;
    document.getElementById('deactivatePopup').style.display = 'block';
}

function hideDeactivatePopup() {
    document.getElementById('deactivatePopup').style.display = 'none';
}

function showAddUserPopup() {
    var addUserPopup = document.getElementById('addUserPopup');
    addUserPopup.style.display = 'block';

}

function hideAddUserPopup() {
    var addUserPopup = document.getElementById('addUserPopup');
    addUserPopup.style.display = 'none';
}