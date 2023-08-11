import swal from "sweetalert";

const showBasicAlert = document.getElementById('show-basic-alert');

showBasicAlert.addEventListener('click', (event) => {
    event.preventDefault();

    swal("Hello World!");
})