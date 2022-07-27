const date = new Date().toISOString().slice(0,10)
document.getElementById('meetingTime').setAttribute("min", date);
