import swal from "sweetalert";

const startBooking = document.getElementById('start-booking');

const tickets = {
    morning: 3,
    evening: 0,
}

let showTime = '';
let buyTickets = false;
let noOfTickets = 0;

const startBookingOnClick = async (event) => {
    event.preventDefault();

    showTime = await swal({
        title: "Choose a Show Time",
        text: "Morning show starts @ 9am, ends @ 10am, Evening show starts @ 4pm, ends @ 5pm",
        buttons: {
            morning: {
                text: "Morning",
                value: "morning"
            },
            evening: {
                text: "Evening",
                value: "evening",
            }
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
                        value: 1,
                    }
                },
                button: "Get Tickets"
            });
        }

        if(noOfTickets) {
            swal({
                title: "Thank You!",
                text: noOfTickets + " tickets booked for " + showTime +" show",
                icon: "success"
            });
        }
        else {
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