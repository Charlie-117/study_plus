/* function for spinner at landing page */

setTimeout(function() {
   $("#loading").addClass("animate__animated animate__zoomOut");
   setTimeout(function() {
      $("#loading").removeClass("animate__animated animate__zoomOut");
      $("#loading").css("display", "none");
   }, 300);
}, 200);