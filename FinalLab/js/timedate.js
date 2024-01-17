function getTheDate() {
  var Todays = new Date();
  var theDate = "" + (Todays.getMonth() + 1) + " / " + Todays.getDate() + " / " + (Todays.getFullYear() - 100);
  document.getElementById("data").innerHTML = theDate;
}


var timerID = null;
var timerRunning = false;

function StopClock() {
  if (timerRunning) clearTimeout(timerID);
  timerRunning = false;
}

function StartClock() {
  StopClock();
  getTheDate();
  ShowTime();
}

function ShowTime() {
  var now = new Date();
  var hours = now.getHours();
  var minutes = now.getMinutes();
  var seconds = now.getSeconds();
  var timeValue = "" + (hours > 12 ? hours - 12 : hours);

  timeValue += (minutes < 10 ? ":0" : ":") + minutes;
  timeValue += (seconds < 10 ? ":0" : ":") + seconds;
  timeValue += seconds > 12 ? "P.M" : " A.M.";

  document.getElementById("zegarek").innerHTML = timeValue;
  timerID = setTimeout("ShowTime()", 1000);
  timerRunning = true;
}
