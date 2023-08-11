import swal from "sweetalert";

const startBooking = document.getElementById('start-booking');

let tickets = {
    morning: 6,
    noon: 0,
    evening: 15,
    night: 10
}

const selectShowTimeFormHTML = `<select id="show-time-selector" class="form-select" aria-label="Default select example">
<option value="morning">Morning</option>
<option value="noon">Noon</option>
<option value="evening">Evening</option>
<option value="night">Night</option>
</select>`;

const parser = new DOMParser();
const doc = parser.parseFromString(selectShowTimeFormHTML, 'text/html');
const selectField = doc.getElementById('show-time-selector');

const selectFieldOnChange = async (event) => {
    console.log(event.target.value);
    swal.setActionValue(event.target.value);
}

selectField.addEventListener('change', selectFieldOnChange );

const startBookingOnClick = async (event) => {
    event.preventDefault();

    let showTime = '';
    let buyTickets = false;
    let noOfTickets = 0;

    showTime = await swal({
        title: "Choose a Show Time",
        text: "Morning show starts @ 9am, noon show starts @ 12am, evening show starts @ 4pm, night show starts @ 8pm",
        content: selectField,
        button: {
            text: "Check Availability",
            value: selectField.value ? selectField.value : "morning",
        }
    });

    if(showTime) {

        if(tickets[showTime] > 0) {
            buyTickets = await swal({
                title: "Voila!",
                text: "Tickets Available for " + showTime + " show",
                icon: "success",
                buttons: {
                    cancel: {
                        text: 'Cancel',
                        visible: true,
                    },
                    buy: {
                        text: 'Buy Tickets',
                    }
                }
            });
        }
        else {
            swal({
                title: "Sorry!",
                text: "Tickets currently not available for " + showTime + " show, check again tomorrow",
                icon: "info",
            });
        }

        if(buyTickets) {
            noOfTickets = await swal({
                title: "Select Tickets",
                text: "Please select the no. of tickets you want",
                content: {
                    element: "input",
                    attributes: {
                        type: "number",
                        min: 1,
                        max: tickets[showTime],
                    }
                },
                button: {
                    text: "Get Tickets",
                    value: "1",
                }
            });

            noOfTickets = parseInt(noOfTickets, 10);
            console.log(typeof(noOfTickets));
            console.log('noOfTickets:' + noOfTickets);
        }

        

        if(noOfTickets >= 1) {
            tickets[showTime] = tickets[showTime] - noOfTickets;
            console.log(tickets);
            swal({
                title: "Thank You!",
                text: noOfTickets + " tickets booked for " + showTime +" show",
                icon: "success"
            });
        }
        else if(noOfTickets === null) {
            swal({
                title: "Cancelled!",
                text: "Ticket Booking Cancelled",
                icon: "error"
            });
        }
        
    }
}

if(startBooking) {
    startBooking.addEventListener('click', startBookingOnClick);
}