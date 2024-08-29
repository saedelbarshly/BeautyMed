let currentYear = document.getElementById('year')



currentYear.textContent = new Date().getFullYear()

$(function(){
    $('#datepicker').datepicker();
  });