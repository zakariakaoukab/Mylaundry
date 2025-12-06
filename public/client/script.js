  // Initialize flatpickr for the datetime inputs
  document.addEventListener('DOMContentLoaded', function() {
    var datetimePicker1 = flatpickr("#datetime-input1", {
      enableTime: true,
      minDate: "today",
      maxDate: new Date().fp_incr(20), // 20 days from today
      time_24hr: true,
      dateFormat: "Y-m-d H:i",
      defaultDate: "today",
      minTime: "09:00",
      maxTime: "18:00",
      onChange: function(selectedDates, dateStr, instance) {
        if (selectedDates.length > 0) {
          // Get the selected date from datetime-input1
          var selectedDate = selectedDates[0];
          
          // Calculate the date 48 hours after the selected date
          var minDate = new Date(selectedDate.getTime() + 48 * 60 * 60 * 1000);
          
          // Set the minimum date for datetime-input2
          datetimePicker2.set("minDate", minDate);
        }
      }
    });
  
    var datetimePicker2 = flatpickr("#datetime-input2", {
      enableTime: true,
      minDate: "today",
      maxDate: new Date().fp_incr(20), // 20 days from today
      time_24hr: true,
      dateFormat: "Y-m-d H:i",
      minTime: "09:00",
      maxTime: "18:00",
    });
  });
