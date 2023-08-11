import swal from "sweetalert";

const customHTML = document.getElementById('custom-html');

const formHTML = `<form class="text-start">
<div class="mb-3">
  <label for="email" class="form-label">Email address</label>
  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
</div>
<div class="mb-3">
  <label for="password" class="form-label">Password</label>
  <input type="password" class="form-control" id="password" name="password">
</div>
</form>`;

const parser = new DOMParser();
const doc = parser.parseFromString(formHTML, 'text/html');
const form = doc.querySelector('form');

let email = doc.getElementById('email');
let password = doc.getElementById('password');

let data = {
    email: '',
    password: '',
}

const setEmail = async (event) => {
    data.email = event.target.value;
    swal.setActionValue(JSON.stringify(data));
}

const setPassword = async (event) => {
    data.password = event.target.value;
    swal.setActionValue(JSON.stringify(data));
}

const loginBtnOnClick = async (event) => {
    event.preventDefault();
    const login = await swal({
        text: "Login here...",
        content: form,
        button: {
            text: "Login",
        }
    });

    console.log(login);
}

email.addEventListener('change', setEmail);
password.addEventListener('change', setPassword);

if(customHTML) {
    customHTML.addEventListener('click', loginBtnOnClick)
}