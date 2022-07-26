const date = new Date().toISOString().slice(0,10)
document.getElementById('meeting-time').setAttribute("min", date);
