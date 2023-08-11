import swal from "sweetalert";

const deleteBtnClick = async (event) => {

    event.preventDefault();

    const confirmation = await swal({
        title: 'Think for a minute!',
        text: 'Your action cannot be reversed! May be you can pause subscription and continue with the free plan',
        icon: 'warning',
        buttons: {
            delete: {
                text: "Delete Account",
                value: 'delete',
                className: "btn btn-danger btn-sm",
            },
            cancel: {
                text: "Cancel",
                value: null,
                className: 'btn btn-secondary btn-sm',
                visible: true,
            },
            pause: {
                text: "Pause Subscription",
                value: 'pause',
                className: "btn btn-success btn-sm",
            },
        }
    });
    
    switch(confirmation) {
        case 'delete':
            console.log('account deleted permanently');
            break;
        case 'pause':
            console.log('pause account');
            break;
        default:
            console.log('Glad you are back!');
    }

}

const deleteBtn = document.getElementById('delete-account');


if(deleteBtn) {
    deleteBtn.addEventListener('click', deleteBtnClick);
}

const saveBtn = document.getElementById('save-changes');

const saveBtnClick = async (event) => { 

    event.preventDefault();

    let profileData = new FormData();

    profileData.append("name", document.getElementById("name").value);
    profileData.append("email", document.getElementById("email").value);

    const result = await fetch('backend.php', {
        method: 'POST',
        body: profileData,
    });
    
    const json = await result.json();
    
    switch (json.status) {
        case 'success':
            swal({
                "title": "Saved",
                "text": json.message,
                "icon": "success"
            });
            break;
        case 'error':
            swal({
                "title": "Check Again!",
                "text": json.message,
                "icon": "error"
            });
            break;
    }
}

if(saveBtn) {
    saveBtn.addEventListener("click", saveBtnClick);
}