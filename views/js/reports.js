//Local storage varaible
if(localStorage.getItem('captureRange2') != null){
  $('#daterange-btn2 span').html(localStorage.getItem("captureRange2"));
} else {
  $('#daterange-btn2 span').html('<i class="fa fa-calendar"></i> Date Range')
}

//Dates range
$('#daterange-btn2').daterangepicker({
  ranges: {
    'Today': [moment(), moment()],
    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
 },
  startDate: moment(),
  endDate  : moment()
},
function (start, end) {
  $('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  var initialDate = start.format('YYYY-MM-DD');
  var finalDate = end.format('YYYY-MM-DD');

  var captureRange = $('#daterange-btn2 span').html();
  localStorage.setItem('captureRange2', captureRange);
  console.log('localStorage', localStorage);

  window.location = "index.php?route=sales-report&initialDate="+initialDate+"&finalDate="+finalDate;

}
)


//Cancel dates range
$('.cancelBtn').on("click", function(){
  localStorage.removeItem('captureRange2');
  localStorage.clear();
  window.location = "sales-report";
})

//Capture today's button
$('.ranges ul li').on('click', function(){
  var todayButton = $(this).attr('data-range-key');
  if(todayButton == "Today"){
    var d = new Date();
    var day = d.getDate();
    var month = d.getMonth()+1;
    var year = d.getFullYear();

    if(month < 10){
      var initialDate = year+"-0"+month+"-"+day;
      var finalDate = year+"-0"+month+"-"+day;
    } else if(day < 10){
      var initialDate = year+"-"+month+"-0"+day;
      var finalDate = year+"-"+month+"-0"+day;
    } else if(month < 10 && day < 10){
      var initialDate = year+"-0"+month+"-0"+day;
      var finalDate = year+"-0"+month+"-0"+day;
    } else {
      var initialDate = year+"-"+month+"-"+day;
      var finalDate = year+"-"+month+"-"+day;
    }

    localStorage.setItem("captureRange2", "Today");
    window.location = "index.php?route=sales-report&initialDate="+initialDate+"&finalDate="+finalDate;
    
  }
})  